<?php

namespace CheckoutV2\Controller;

use Cake\I18n\Date;
use Cake\ORM\TableRegistry;
use CheckoutV2\Controller\Component\OrderComponent;

/**
 * Class PagseguroController
 * @package CheckoutV2\Controller
 *
 * @property \CheckoutV2\Controller\Component\PagseguroTicketComponent $PagseguroTicket
 * @property OrderComponent $Order
 */
class PagseguroTicketController extends AppController
{
    /**
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('CheckoutV2.PagseguroTicket', [
            'payment_config' => $this->payment_config,
            'store' => $this->store
        ]);
        $this->loadComponent('CheckoutV2.Order', [
            'payment_config' => $this->payment_config
        ]);
        $this->Auth->allow(['notification']);
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function process()
    {
        $Customers = TableRegistry::getTableLocator()->get('CheckoutV2.Customers');
        $customer = $Customers->get($this->Auth->user('id'));
        $data_customer = [];
        if ($this->request->getData('document')) {
            $data_customer['document'] = $this->request->getData('document');
        }
        if ($this->request->getData('telephone')) {
            $data_customer['telephone'] = $this->request->getData('telephone');
        }
        if ($this->request->getData('birth_date')) {
            $data_customer['birth_date'] = $this->request->getData('birth_date');
        }
        if($data_customer){
            $Customers->patchEntity($customer, $data_customer);
            $Customers->save($customer);
        }
        $ticket = $this->PagseguroTicket->process($this->request->getData());

        if ($ticket) {
            $this->Order->finalizeOrder();
            return $this->redirect(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')]);
        }
        $this->Flash->error(__('Ocorreu um problema ao processar seu pagamento. Por favor, tente novamente.'));
        return $this->redirect(['controller' => 'checkout', 'action' => 'payment']);
    }

    /**
     * @throws \HttpInvalidParamException
     */
    public function notification()
    {
        if (!$this->request->getData('notificationCode')) {
            throw new \HttpInvalidParamException(__('É necessario informar o codigo da compra'));
        }

        $status = $this->PagseguroTicket->notification($this->request->getData('notificationCode'));

        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
    }
}