<?php

namespace CheckoutV2\Controller;

use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * Class CieloDebitCardController
 * @package App\Controller
 *
 * @property \Checkout\Controller\Component\CieloComponent $Cielo
 */
class CieloCreditCardController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Checkout.Cielo', [
            'payment_config' => $this->payment_config
        ]);
        $this->loadComponent('Checkout.Order', [
            'payment_config' => $this->payment_config
        ]);
    }

    /**
     *
     */
    public function process()
    {
        $credit_card = $this->Cielo->creditCard($this->request->getSession()->read('orders_id'), $this->request->getData(), $this->store);

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
}