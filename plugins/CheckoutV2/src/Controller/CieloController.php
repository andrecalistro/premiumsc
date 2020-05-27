<?php

namespace CheckoutV2\Controller;

use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * Class CieloController
 * @package App\Controller
 *
 * @property \Theme\Controller\Component\CieloComponent $Cielo
 */
class CieloController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Checkout.Cielo', [
            'payment_config' => $this->payment_config
        ]);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function ticket()
    {
        $ticket = $this->Cielo->ticket($this->request->getSession()->read('orders_id'));

        if ($ticket) {
            return $this->redirect(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')]);
        } else {
            $this->Flash->error(__('Ocorreu um problema ao processar seu pagamento. Por favor, tente novamente.'));
            return $this->redirect(['controller' => 'checkout', 'action' => 'payment']);
        }
    }

    /**
     *
     */
    public function creditCard()
    {
        $credit_card = $this->Cielo->creditCard($this->request->getSession()->read('orders_id'), $this->request->getData());

        if ($credit_card) {
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

    public function onlineDebit()
    {
        $online_debit = $this->Cielo->onlineDebit($this->request->getSession()->read('orders_id'), $this->request->getData());

        if ($online_debit) {
            $data = [
                'status' => true,
                'redirect' => $online_debit
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

    public function discount()
    {
        $discount = $this->Cielo->discount($this->request->getSession()->read('orders_id'), $this->request->getData('method'));

        $this->set(compact('discount'));
        $this->set('_serialize', ['discount']);
    }
}