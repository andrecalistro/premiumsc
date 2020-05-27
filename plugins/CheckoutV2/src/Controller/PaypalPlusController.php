<?php

namespace CheckoutV2\Controller;

use Cake\Core\Configure;
use Cake\I18n\Date;
use Cake\Network\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Checkout\Controller\Component\OrderComponent;
use PayPal\Api\Payment;

/**
 * Class CieloController
 * @package App\Controller
 *
 * @property OrderComponent Order
 *
 * @property \Checkout\Controller\Component\PaypalPlusComponent PaypalPlus
 */
class PaypalPlusController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Checkout.PaypalPlus', [
            'payment_config' => $this->payment_config,
            'store' => $this->store
        ]);
        $this->loadComponent('Checkout.Order', [
            'payment_config' => $this->payment_config
        ]);
    }

    /**
     *
     */
    public function execute()
    {
        $payment = $this->PaypalPlus->afterPay($this->request->getData());

        if ($payment) {
            $this->Order->finalizeOrder();
            $data = [
                'status' => true,
                'redirect' => Router::url(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')], true)
            ];
        } else {
            $data = [
                'status' => false,
                'message' => 'Seu pagamento não pode ser processado pelo PayPal. Por favor, tente novamente'
            ];
        }
        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
    }
}