<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Exception\Exception;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Checkout\Model\Entity\Order;

/**
 * Class PagseguroComponent
 * @package Checkout\Controller\Component
 *
 * @property \Checkout\Model\Table\PaymentsTable $Payments
 * @property OrderComponent $Order
 */
class PagseguroTicketComponent extends Component
{
    public $Payments;
    public $Order;
    public $statuses;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');

        foreach ($this->Payments->findConfig('pagseguro_ticket') as $key => $value) {
            $this->setConfig($key, $value);
        }

        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");
        \PagSeguro\Configuration\Configure::setEnvironment($this->getConfig('environment'));
        \PagSeguro\Configuration\Configure::setAccountCredentials(
            $this->getConfig('email'),
            $this->getConfig('token')
        );
        \PagSeguro\Configuration\Configure::setCharset('UTF-8');
        \PagSeguro\Configuration\Configure::setLog(false, WWW_ROOT . 'logs/pagseguro.log');

        $this->Order = new OrderComponent(new ComponentRegistry());

        $this->statuses = [
            1 => 'status_waiting_payment',
            2 => 'status_payment_analysis',
            3 => 'status_approved_payment',
            4 => 'status_payment_disponivel',
            5 => 'status_waiting_payment',
            6 => 'status_canceled_payment',
            7 => 'status_canceled_payment',
            8 => 'status_canceled_payment'
        ];
    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function process($data)
    {
        try {
            /** @var Order $order */
            $order = $this->Order->getOrder($this->getController()->request->getSession()->read('orders_id'));

            $ticket = new \PagSeguro\Domains\Requests\DirectPayment\Boleto();
            $ticket->setMode('DEFAULT');
            $ticket->setReceiverEmail($this->getConfig('email'));
            $ticket->setCurrency("BRL");

            foreach ($order->orders_products as $product) {
                $ticket->addItems()->withParameters(
                    $product->products_id,
                    $product->name,
                    $product->quantity,
                    $product->price
                );
            }

            $totalDiscount = 0;

            if ($order->coupon_discount) {
                $totalDiscount += -($order->coupon_discount);
            }

            if ($order->discount) {
                $totalDiscount += -($order->discount);
            }

            if ($totalDiscount) {
                $ticket->setExtraAmount($totalDiscount);
            }

            $ticket->setReference(Text::slug($this->getConfig('store')->name) . "#" . $order->id);

            $ticket->setSender()->setName($order->customer->name);
            if ($this->getConfig('environment') == 'sandbox') {
                $ticket->setSender()->setEmail($this->getConfig('sandbox_email'));
            } else {
                $ticket->setSender()->setEmail($order->customer->email);
            }

            if ($order->customer->telephone_separated) {
                $ticket->setSender()->setPhone()->withParameters(
                    $order->customer->telephone_separated['area_code'],
                    $order->customer->telephone_separated['number']
                );
            }

            $ticket->setSender()->setDocument()->withParameters(
                $this->getTypeAndDocument($order->customer->document_clean),
                empty($order->customer->document_clean) ? $order->customer->company_document_clean : $order->customer->document_clean
            );

            $ticket->setSender()->setHash($data['hash']);
            $ticket->setSender()->setIp($order->ip);
            $ticket->setNotificationUrl(Router::url(['controller' => 'pagseguro-credit-card', 'action' => 'notification', 'plugin' => 'CheckoutV2'], true));

            $ticket->setShipping()->setAddress()->withParameters(
                $order->address,
                $order->number,
                $order->neighborhood,
                preg_replace('/\D/', '', $order->zipcode),
                $order->city,
                $order->state,
                'BRA',
                $order->complement
            );
            $ticket->setShipping()->setCost()->withParameters(number_format($order->shipping_total, 2, ".", ""));


            $result = $ticket->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            $this->Order->update([
                'payment_id' => $result->getCode(),
                'payment_url' => $result->getPaymentLink(),
                'payment_method' => 'pagseguro_ticket'
            ], $order->id);

            $this->Order->addHistory($order->id, $this->getConfig('status_waiting_payment'), 'Boleto gerado<br><a href="' . $result->getPaymentLink() . '" target="_blank">Clique aqui para emitir a 2ª via</a>');
            return true;
        } catch (\Exception $e) {
            Log::write('alert', 'Pagamento nao aprovado: ' . $e->getMessage(), ['escope' => 'pagseguro_ticket']);
            throw $e;
        }
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getSessionCode()
    {
        try {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            return $sessionCode->getResult();
        } catch (\Exception $e) {
            Log::write('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param $notificationCode
     * @return bool
     */
    public function notification($notificationCode)
    {
        if ($this->getConfig('environment') == 'sandbox') {
            $url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/';
        } else {
            $url = 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications/';
        }
        $url .= $notificationCode;
        $url .= '?email=' . $this->getConfig('email');
        $url .= '&token=' . $this->getConfig('token');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        $xml = simplexml_load_string($response);

        if (!$xml->error) {
            $reference = explode("#", (string)$xml->reference);
            $order = $this->Order->getOrder($reference[1]);
            $new_status = $this->getConfig($this->statuses[(string)$xml->status]);
            if ($order->orders_statuses_id == 1 && ($new_status == 2 || $new_status == 6)) {
                $this->Order->addHistory($order->id, $this->getConfig($this->statuses[(string)$xml->status]), '', true);
            }
            return true;
        } else {
            Log::write('error', 'Falha na notificação do PagSeguro. Errr: ' . $xml->error->message);
            return false;
        }
    }

    /**
     * @param $document
     * @return string
     */
    private function getTypeAndDocument($document)
    {
        if (strlen($document) === 11) {
            return 'CPF';
        }

        return 'CNPJ';
    }
}