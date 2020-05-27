<?php

namespace CheckoutV2\Controller;

use Cake\Routing\Router;

/**
 * Class CieloDebitCardController
 * @package App\Controller
 *
 * @property \Checkout\Controller\Component\CieloComponent $Cielo
 * @property \Checkout\Controller\Component\OrderComponent $Order
 */
class CieloDebitCardController extends AppController
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
        $debit_card = $this->Cielo->debitCard($this->request->getSession()->read('orders_id'), $this->request->getData(), $this->store);

        if ($debit_card) {
            //$this->Order->finalizeOrder();
            $data = [
                'status' => true,
                'redirect' => $debit_card//Router::url(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')], true)
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
     * @param $orders_id
     * @return \Cake\Http\Response|null
     */
    public function processReturn($orders_id)
    {
        $payment = $this->Cielo->processDebit($this->request->getData('PaymentId'), $orders_id);
        if ($payment) {
            $this->Order->finalizeOrder();
            return $this->redirect(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')]);
        }
        $this->Flash->error(__('Pagamento não autorizado. Entre em contato com o banco emissor do seu cartão para mais informações.'));
        return $this->redirect(['controller' => 'checkout', 'action' => 'payment']);
    }
}