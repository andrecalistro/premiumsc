<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use MercadoPago\Item;
use MercadoPago\Payment;
use MercadoPago\SDK;

/**
 * Class MpCrediCardComponent
 * @package Checkout\Controller\Component
 *
 * @property \Checkout\Model\Table\PaymentsTable $Payments
 * @property \Checkout\Controller\Component\OrderComponent $Order
 */
class MpCreditCardComponent extends Component
{
    public $Payments;
    public $payment_config;
    public $store;
    public $Order;
    public $mp;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');

        foreach ($this->Payments->findConfig('mp_credit_card') as $key => $value) {
            $this->setConfig($key, $value);
        }

        $this->payment_config = $config['payment_config'];
        $this->store = $config['store'];

        $this->Order = new OrderComponent(new ComponentRegistry());
    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function process($data)
    {
        $order = $this->Order->getOrder($this->getController()->request->getSession()->read('orders_id'));
        SDK::setAccessToken($this->getConfig('access_token'));

        $installment = explode("_", $data['installment']);
        $payer_name = explode(' ', $order->customer->name);
        $payment = new Payment();
        $payment->payer = [
            'email' => $order->customer->email,
            'identification' => [
                'type' => 'CPF',
                'number' => $order->customer->document_clean
            ],
            'first_name' => isset($payer_name[0]) ? $payer_name[0] : '',
            'last_name' => isset($payer_name[1]) ? $payer_name[1] : ''
        ];
        $payment->binary_mode = true;
        $payment->external_reference = $order->id;
        $payment->transaction_amount = $order->total;
        $payment->payment_method_id = $data['payment_method_id'];
        $payment->token = $data['token'];
        $payment->statement_descriptor = $this->store->name;
        $payment->installments = $installment[0];

        $items = [];
        if ($order->orders_products) {
            foreach ($order->orders_products as $product) {
                $items[] = [
                    'id' => $product->products_id,
                    'title' => $product->name,
                    'picture_url' => $product->image,
                    'quantity' => $product->quantity,
                    'unit_price' => $product->price
                ];
            }
        }

        $payment->additional_info = [
            'items' => $items,
            'payer' => [
                'first_name' => isset($payer_name[0]) ? $payer_name[0] : '',
                'last_name' => isset($payer_name[1]) ? $payer_name[1] : '',
                'address' => [
                    'zip_code' => $order->zipcode,
                    'street_name' => $order->address,
                    'street_number' => $order->number
                ]
            ]
        ];

        $response = $payment->save();

        if ($response['body']['status'] == 'approved') {
            $this->Order->update([
                'payment_id' => $response['body']['id'],
                'payment_method' => 'mp_credit_card',
                'total_without_discount' => $order->total,
                'payment_brand' => $response['body']['payment_method_id'],
                'payment_installment' => $response['body']['installments'],
                'payment_card_number' => $response['body']['card']['last_four_digits'],
                'payment_name' => $response['body']['card']['cardholder']['name'],
                'payment_document' => $response['body']['card']['cardholder']['identification']['number'],
                'payment_birth_date' => null,
                'payment_installment_value' => $response['body']['transaction_details']['installment_amount'],
                'orders_statuses_id' => 1
            ], $order->id);

            $this->Order->addHistory($order->id, 2, 'Seu pagamento foi aprovado');
            return true;
        } else {
            return false;
        }
    }
}