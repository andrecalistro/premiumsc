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
 * @property \Checkout\Controller\Component\PaypalExpressComponent $PaypalExpress
 */
class PaypalExpressController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Checkout.PaypalExpress', [
            'payment_config' => $this->payment_config,
            'store' => $this->store
        ]);
        $this->loadComponent('Checkout.Order', [
            'payment_config' => $this->payment_config
        ]);
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function transaction()
    {
        $url = $this->PaypalExpress->transaction($this->request->getSession()->read('orders_id'));

        return $this->redirect($url);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function finalize()
    {
        $payment = $this->PaypalExpress->afterPay($this->request->getQuery());

        if ($payment) {
            $this->Order->finalizeOrder();
            return $this->redirect(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')]);
        }
        $this->Flash->error(__('Seu pagamento não pode ser processado pelo PayPal. Por favor, tente novamente'));
        return $this->redirect(['controller' => 'checkout', 'action' => 'payment', 'plugin' => 'CheckoutV2']);
    }
}