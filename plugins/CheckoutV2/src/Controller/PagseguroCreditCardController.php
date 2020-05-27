<?php

namespace CheckoutV2\Controller;

use Cake\Http\Response;
use Cake\Routing\Router;
use Checkout\Controller\Component\OrderComponent;

/**
 * Class PagseguroCreditCardController
 * @package Checkout\Controller
 *
 * @property \Checkout\Controller\Component\PagseguroCreditCardComponent $PagseguroCreditCard
 * @property OrderComponent $Order
 */
class PagseguroCreditCardController extends AppController
{
    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('CheckoutV2.PagseguroCreditCard', [
            'payment_config' => $this->payment_config,
            'store' => $this->store
        ]);
        $this->loadComponent('CheckoutV2.Order', [
            'payment_config' => $this->payment_config
        ]);
        $this->Auth->allow(['notification']);
    }

    /**
     *
     */
    public function process()
    {
        $credit_card = $this->PagseguroCreditCard->process($this->request->getSession()->read('orders_id'), $this->request->getData());

        if ($credit_card) {
            $this->Order->finalizeOrder();
            $data = [
                'status' => true,
                'redirect' => Router::url(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')], true)
            ];
        } else {
            $data = [
                'status' => false,
                'message' => 'Pagamento não autorizado. Entre em contato com o banco emissor do seu cartão para mais informações.'
            ];
        }
        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
    }

    /**
     *
     */
    public function getSessionCode()
    {
        $code = $this->Pagseguro->getSessionCode();
        $cart = $this->Cart->getProducts();
        $total = $cart['subtotal']->subtotal + $this->request->getSession()->read('quote_price');
        $this->set(compact('code', 'total'));
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function getInstallments()
    {
        if(!$this->request->getData('brand')) {
            $response = new Response([
                'status' => 401,
                'body' => json_encode([
                    'message' => 'Cartão inválido'
                ])
            ]);
            return $response;
        }

        $order = $this->Order->getOrder($this->request->getSession()->read('orders_id'));
        $installments = $this->PagseguroCreditCard->getInstallments($order->total, $this->request->getData('brand'));
        return new Response([
            'status' => 201,
            'body' => json_encode([
                'installments' => $installments
            ])
        ]);
    }

    /**
     * @throws \HttpInvalidParamException
     */
    public function notification()
    {
        if(!$this->request->getData('notificationCode')) {
            throw new \HttpInvalidParamException(__('É necessario informar o codigo da compra'));
        }

        $status = $this->PagseguroCreditCard->notification($this->request->getData('notificationCode'));

        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
        $this->RequestHandler->renderAs($this, 'json');
    }
}