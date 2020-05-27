<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\I18n\Date;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Moip\Auth\BasicAuth;
use Moip\Moip;

/**
 * Class CieloComponent
 * @package App\Controller\Component
 *
 * @property \Checkout\Model\Table\PaymentsTable $Payments
 * @property \Checkout\Controller\Component\OrderComponent $Order
 * @property Moip $moip
 */
class MoipTicketComponent extends Component
{
    public $Payments;
    public $payment_config;
    public $moip;
    public $store;

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');

        foreach ($this->Payments->findConfig('moip_ticket') as $key => $value) {
            $this->setConfig($key, $value);
        }

        if ($this->getConfig('environment') == 'sandbox') {
            $this->setConfig('environment_type', Moip::ENDPOINT_SANDBOX);
        } else {
            $this->setConfig('environment_type', Moip::ENDPOINT_PRODUCTION);
        }

        $this->moip = new Moip(new BasicAuth($this->getConfig('token'), $this->getConfig('key')), $this->getConfig('environment_type'));

        $this->payment_config = $config['payment_config'];
        $this->store = $config['store'];

        $this->Order = new OrderComponent(new ComponentRegistry());
    }

    /**
     * @param $order
     * @return mixed
     */
    public function createCustomer($order)
    {
        return $this->moip->customers()->setOwnId(uniqid())
            ->setFullname($order->customer->name)
            ->setEmail($order->customer->email)
            ->setBirthDate($order->customer->birth_date->format('Y-m-d'))
            ->setTaxDocument($order->customer->document_clean)
//            ->setPhone(substr($order->customer->telephone, 1, 2), substr($order->customer->telephone, 5, 5) . substr($order->customer->telephone, -4))
            ->addAddress('BILLING',
                $order->address, $order->number,
                $order->neighborhood, $order->city, $order->state,
                str_replace("-", "", $order->zipcode), $order->complement)
            ->addAddress('SHIPPING',
                $order->address, $order->number,
                $order->neighborhood, $order->city, $order->state,
                str_replace("-", "", $order->zipcode), $order->complement)
            ->create();
    }

    public function createCustomerCreditCard($order, $data)
    {
        return $this->moip->customers()->setOwnId(uniqid())
            ->setFullname($data['card_name'])
            ->setEmail($order->customer->email)
            ->setBirthDate(Date::createFromFormat('d/m/Y', $data['birth_date'])->format("Y-m-d"))
            ->setTaxDocument($data['document'])
//            ->setPhone(substr($order->customer->telephone, 1, 2), substr($order->customer->telephone, 5, 5) . substr($order->customer->telephone, -4))
            ->addAddress('BILLING',
                $order->address, $order->number,
                $order->neighborhood, $order->city, $order->state,
                str_replace("-", "", $order->zipcode), $order->complement)
            ->addAddress('SHIPPING',
                $order->address, $order->number,
                $order->neighborhood, $order->city, $order->state,
                str_replace("-", "", $order->zipcode), $order->complement)
            ->create();
    }

    /**
     * @param $orders_id
     * @return bool
     */
    public function process($orders_id)
    {
        $order = $this->Order->getOrder($orders_id);

        $discount = $order->discount + $order->coupon_discount;

        $invoice = $this->moip->orders()->setOwnId(uniqid());

        foreach ($order->orders_products as $product) {
            $invoice->addItem($product->name, $product->quantity, $product->product->code, (int)number_format($product->price, 2, "", ""));
        }

        $invoice->setShippingAmount((int)number_format($order->shipping_total, 2, "", ""))
            ->setDiscount((int)number_format($discount, 2, "", ""))
            ->setCustomer($this->createCustomer($order))
            ->create();

        $logo_uri = $this->store->logo_link;
        $expiration_date = date('Y-m-d', strtotime('+' . $this->payment_config->ticket_expiration_date . ' days'));
        $instruction_lines = [$this->payment_config->ticket_demonstrative, $this->payment_config->ticket_instructions, ''];
        $payment = $invoice->payments()
            ->setBoleto($expiration_date, $logo_uri, $instruction_lines)
            ->execute();

        $moip_order = $this->moip->payments()->get($payment->getId());

        $status = $this->getConfig('status_' . strtolower($moip_order->getStatus()));

        if ($status <> 6) {
            $this->Order->update([
                'payment_id' => $invoice->getId() . "_" . $payment->getId(),
                'payment_url' => $payment->getHrefPrintBoleto(),
                'payment_method' => 'moip_ticket'
            ], $orders_id);

            $this->Order->addHistory($orders_id, $status, 'Boleto gerado<br><a href="' . $payment->getHrefBoleto() . '" target="_blank">Clique aqui para emitir a 2ª via</a>');
            return true;
        }
        return false;

    }

    /**
     * @param $orders_id
     * @param $method
     * @return array
     */
    public function discount($orders_id, $method)
    {
        $order = $this->Order->getOrder($orders_id);

        $discount = 0;
        $total = $order->total;
        $discount_text = '';
        $status = false;

        switch ($method) {
            case 'ticket':
                if (isset($this->payment_config->ticket_discount) && is_numeric($this->payment_config->ticket_discount) && $this->payment_config->ticket_discount > 0) {
                    $discount = (($this->payment_config->ticket_discount / 100) * $total);
                    $total = $total - $discount;
                    $discount_text = $this->payment_config->ticket_discount . '% de desconto no boleto';
                    $status = true;
                }
                break;
            case 'debit-card':
                if (isset($this->payment_config->debit_discount) && is_numeric($this->payment_config->debit_discount) && $this->payment_config->debit_discount > 0) {
                    $discount = (($this->payment_config->debit_discount / 100) * $total);
                    $total = $total - $discount;
                    $discount_text = $this->payment_config->debit_discount . '% de desconto no débito';
                    $status = true;
                }
                break;
            default:
                break;
        }

        return [
            'status' => $status,
            'total' => $total,
            'discount' => $discount,
            'total_format' => 'R$ ' . number_format($total, 2, ",", "."),
            'discount_format' => '-R$ ' . number_format($discount, 2, ",", "."),
            'discount_text' => $discount_text
        ];
    }

    public function getPublicKey()
    {
        return $this->getConfig('public_key');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function consultStatus($id)
    {
        $moip_order = $this->moip->payments()->get($id);
        $status = $this->getConfig('status_' . strtolower($moip_order->getStatus()));
        return $status;
    }

    /**
     * @param $id
     * @return array
     */
    public function splitId($id)
    {
        $data = explode('_', $id);
        return [
            'moiṕ_order_id' => $data[0],
            'moip_payment_id' => $data[1]
        ];
    }
}