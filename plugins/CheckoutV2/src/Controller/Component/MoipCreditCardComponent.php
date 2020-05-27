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
class MoipCreditCardComponent extends Component
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

        foreach ($this->Payments->findConfig('moip_credit_card') as $key => $value) {
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
            ->setPhone($order->customer->telephone_separated['area_code'], $order->customer->telephone_separated['number'])
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
            ->setPhone($order->customer->telephone_separated['area_code'], $order->customer->telephone_separated['number'])
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
     * @param $data
     * @return bool
     */
    public function process($orders_id, $data)
    {
        $order = $this->Order->getOrder($orders_id);
        $installments = $this->Payments->installments($this->payment_config, $order->total);
        $invoice = $this->moip->orders()->setOwnId($orders_id);
//            ->addInstallmentCheckoutPreferences([1, 6], 0, 100);
        $customer = $this->createCustomer($order);

        foreach ($order->orders_products as $product) {
            $invoice->addItem($product->name, $product->quantity, $product->product->code, (int)number_format($product->price, 2, "", ""));
        }

        $tax = (int)number_format($installments[$data['installment']]['regular'] * $data['installment'] - $order->total, 2, "", "");

        $discount = $order->discount + $order->coupon_discount;

        $invoice->setShippingAmount((int)number_format($order->shipping_total, 2, "", ""))
            ->setCustomer($customer)
            ->setDiscount($discount)
            ->setAddition($tax)
            ->create();

        $payment = $invoice->payments()
            ->setCreditCardHash($data['hash'], $this->createCustomerCreditCard($order, $data))
            ->setInstallmentCount($data['installment'])
            ->setStatementDescriptor(substr($this->store->name, 0, 13))
            ->execute();

        $moip_order = $this->moip->payments()->get($payment->getId());

        $status = $this->getConfig('status_' . strtolower($moip_order->getStatus()));

        if ($status <> 6) {
            $this->Order->update([
                'payment_id' => $invoice->getId() . "_" . $payment->getId(),
                'payment_method' => 'moip_credit_card',
                'total_without_discount' => $order->total,
                'payment_brand' => $data['card_type'],
                'payment_installment' => $data['installment'],
                'payment_card_number' => substr($data['card_number'], -4),
                'payment_name' => $data['card_name'],
                'payment_document' => $data['document'],
                'payment_birth_date' => Date::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d'),
                'payment_installment_value' => $installments[$data['installment']]['regular'],
                'orders_statuses_id' => 1
            ], $orders_id);

            $this->Order->addHistory($orders_id, $status);

            return true;
        } else {
            Log::write('alert', 'Pagamento nao aprovado: ' . $payment->status, ['escope' => 'moip']);
            return false;
        }
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