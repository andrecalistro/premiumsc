<?php

namespace CheckoutV2\Controller;

use Cake\Event\Event;

/**
 * CustomersAddresses Controller
 *
 * @property \Theme\Model\Table\CustomersAddressesTable $CustomersAddresses
 */
class CustomersAddressesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->pageTitle = 'Meus Endereços';
        $customersAddresses = $this->CustomersAddresses->find()
            ->where(['customers_id' => $this->Auth->user('id')])
            ->toArray();
        $this->set(compact('customersAddresses'));
        $this->set('_serialize', ['customersAddresses']);
    }

    /**
     * @param Event $event
     * @return \Cake\Network\Response|void|null
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setTheme('CheckoutV2');
        $this->viewBuilder()->setLayout('CheckoutV2.checkout');
        $this->set(false, $this->_steps);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->pageTitle = 'Cadastrar novo endereço';
        $customersAddress = $this->CustomersAddresses->newEntity();
        if ($this->request->is('post')) {
            $customersAddress = $this->CustomersAddresses->patchEntity($customersAddress, $this->request->getData());
            $customersAddress->customers_id = $this->Auth->user('id');
            if ($this->CustomersAddresses->save($customersAddress)) {
                $this->Flash->success(__('Seu endereço foi salvo.'));

                return $this->redirect(['controller' => 'customers-addresses', 'action' => 'index']);
            }
            $this->Flash->error(__('Seu endereço não foi salvo. Por favor, tente novamente.'));
        }
        $customers = $this->CustomersAddresses->Customers->find('list', ['limit' => 200]);
        $this->set(compact('customersAddress', 'customers'));
        $this->set('_serialize', ['customersAddress']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customers Address id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->pageTitle = 'Editar endereço';
        $customersAddress = $this->CustomersAddresses->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customersAddress = $this->CustomersAddresses->patchEntity($customersAddress, $this->request->getData());
            if ($this->CustomersAddresses->save($customersAddress)) {
                $this->Flash->success(__('Seu endereço foi salvo.'));

                return $this->redirect(['controller' => 'customers-addresses', 'action' => 'index']);
            }
            $this->Flash->error(__('O seu endereço não foi salvo. Por favor, tente novamente.'));
        }
        $customers = $this->CustomersAddresses->Customers->find('list', ['limit' => 200]);
        $this->set(compact('customersAddress', 'customers'));
        $this->set('_serialize', ['customersAddress']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customers Address id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customersAddress = $this->CustomersAddresses->get($id);
        if ($this->CustomersAddresses->delete($customersAddress)) {
            $this->Flash->success(__('O seu endereço foi excluído.'));
        } else {
            $this->Flash->error(__('O seu endereço não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['controller' => 'customers-addresses', 'action' => 'index']);
    }
}
