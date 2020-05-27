<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Exception\Exception;
use Cake\I18n\Date;
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
class PagseguroCreditCardComponent extends Component
{
    public $Payments;
    public $Order;
    public $statuses;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');

        foreach ($this->Payments->findConfig('pagseguro_credit_card') as $key => $value) {
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

    public function process($orders_id, $data)
    {
        try {
            $paymentConfig = $this->getConfig('payment_config');

            /** @var Order $order */
            $order = $this->Order->getOrder($orders_id);

            $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
            $creditCard->setReceiverEmail($this->getConfig('email'));
            $creditCard->setReference(Text::slug($this->getConfig('store')->name) . "#" . $order->id);
            $creditCard->setCurrency("BRL");

            foreach ($order->orders_products as $product) {
                $creditCard->addItems()->withParameters(
                    $product->products_id,
                    $product->name,
                    $product->quantity,
                    number_format(
                        $product->price, 2, '.', ''
                    )
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
                $creditCard->setExtraAmount($totalDiscount);
            }

            $creditCard->setSender()->setName($order->customer->name);
            if ($this->getConfig('environment') == 'sandbox') {
                $creditCard->setSender()->setEmail($this->getConfig('sandbox_email'));
            } else {
                $creditCard->setSender()->setEmail($order->customer->email);
            }
            if ($order->customer->telephone_separated) {
                $creditCard->setSender()->setPhone()->withParameters(
                    $order->customer->telephone_separated['area_code'],
                    $order->customer->telephone_separated['number']
                );
            }

            $creditCard->setSender()->setDocument()->withParameters(
                $this->getTypeAndDocument($order->customer->document_clean),
                empty($order->customer->document_clean) ? $order->customer->company_document_clean : $order->customer->document_clean
            );

            $creditCard->setSender()->setHash($data['hash']);
            $creditCard->setSender()->setIp($order->ip);
            $creditCard->setShipping()->setAddress()->withParameters(
                $order->address,
                $order->number,
                $order->neighborhood,
                preg_replace('/\D/', '', $order->zipcode),
                $order->city,
                $order->state,
                'BRA',
                $order->complement
            );
            $creditCard->setBilling()->setAddress()->withParameters(
                $order->address,
                $order->number,
                $order->neighborhood,
                preg_replace('/\D/', '', $order->zipcode),
                $order->city,
                $order->state,
                'BRA',
                $order->complement
            );
            $creditCard->setToken($data['token']);
            $creditCard->setShipping()->setCost()->withParameters(number_format($order->shipping_total, 2, ".", ""));

            $installment = explode("_", $data['installment']);
            $creditCard->setInstallment()->withParameters(
                $installment[0],
                number_format($installment[1], 2, ".", ""),
                $paymentConfig->installment_free > 1 ? (int)$paymentConfig->installment_free : null
            );
            $creditCard->setHolder()->setBirthdate($data['birth_date']);
            $creditCard->setHolder()->setName($data['card_name']);
            $creditCard->setHolder()->setPhone()->withParameters(
                substr(preg_replace('/\D/', '', $data['telephone']), 0, 2),
                substr(preg_replace('/\D/', '', $data['telephone']), 2)
            );
            $creditCard->setHolder()->setDocument()->withParameters(
                $this->getTypeAndDocument(preg_replace('/\D/', '', $data['document'])),
                preg_replace('/\D/', '', $data['document'])
            );
            $creditCard->setMode('DEFAULT');
            $creditCard->setNotificationUrl(Router::url(['controller' => 'pagseguro-credit-card', 'action' => 'notification', 'plugin' => 'CheckoutV2'], true));

            $result = $creditCard->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            $status = $this->statuses[$result->getStatus()];

            if ($this->getConfig($status) <> 6) {
                $this->Order->update([
                    'payment_id' => $result->getCode(),
                    'payment_method' => 'pagseguro_credit_card',
                    'total_without_discount' => $order->total,
                    'payment_brand' => $data['card_type'],
                    'payment_installment' => $installment[0],
                    'payment_card_number' => substr($data['card_number'], -4),
                    'payment_name' => $data['card_name'],
                    'payment_document' => $data['document'],
                    'payment_birth_date' => Date::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d'),
                    'payment_installment_value' => number_format($installment[1], 2, ".", ""),
                ], $orders_id);
                $this->Order->addHistory($orders_id, 1);
                $this->Order->addHistory($orders_id, $this->getConfig($status));

                return true;
            } else {
                Log::write('alert', 'Pagamento nao aprovado', ['escope' => 'pagseguro_credit_card']);
                return false;
            }
        } catch (Exception $e) {
            Log::write('alert', 'Pagamento nao aprovado: ' . $e->getMessage(), ['escope' => 'pagseguro_credit_card']);
            return false;
        }
    }

    public function getSessionCode()
    {
        try {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            return $sessionCode->getResult();
        } catch (Exception $e) {
            Log::write('error', $e->getMessage());
            return false;
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
     * @param $total
     * @param null $brand
     * @return array|bool
     * @throws \Exception
     */
    public function getInstallments($total, $brand = null)
    {
        $paymentConfig = $this->getConfig('payment_config');
        $options = [
            'amount' => number_format($total, 2, '.', ''),
            'card_brand' => $brand,
            'max_installment_no_interest' => $paymentConfig->installment_free > 1 ? $paymentConfig->installment_free : null
        ];

        try {
            /** @var \PagSeguro\Domains\Responses\Installments $results */
            $results = \PagSeguro\Services\Installment::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials(),
                $options
            );

            $installments = [];

            /** @var \PagSeguro\Domains\Responses\Installment $installment */
            foreach ($results->getInstallments() as $installment) {
                $installments[$installment->getQuantity()] = [
                    'cardBrand' => $installment->getCardBrand(),
                    'quantity' => $installment->getQuantity(),
                    'amount' => $installment->getAmount(),
                    'totalAmount' => $installment->getTotalAmount(),
                    'interestFree' => $installment->getInterestFree(),
                    'installmentAmountFormatted' => number_format(
                        $installment->getAmount(), 2, ',', '.'
                    )
                ];
            }
            return $installments;
        } catch (Exception $e) {
            Log::write('error', $e->getMessage(), ['escope' => 'pagseguro_credit_card']);
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