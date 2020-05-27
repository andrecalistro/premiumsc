<?php

namespace Admin\Controller;

/**
 * CustomersAddresses Controller
 *
 * @property \Admin\Model\Table\CustomersAddressesTable $CustomersAddresses
 */
class CustomersAddressesController extends AppController
{
    /**
     * @param null $customers_id
     * @return \Cake\Http\Response|null
     */
    public function add($customers_id = null)
    {
        if (!$customers_id || !$this->CustomersAddresses->Customers->exists(['id' => $customers_id])) {
            $this->Flash->error(__('Cliente não encontrado'));
            return $this->redirect(['controller' => 'customers', 'plugin' => 'admin']);
        }

        $customersAddress = $this->CustomersAddresses->newEntity();
        if ($this->request->is('post')) {
            $this->request->getData();
            $customersAddress = $this->CustomersAddresses->patchEntity($customersAddress, $this->request->getData());
            if ($this->CustomersAddresses->save($customersAddress)) {
                $this->Flash->success(__('O endereço foi salvo.'));
            }else{
                $this->Flash->error(__('O endereço não foi salvo. Por favor, tente novamente.'));
            }
            return $this->redirect(['controller' => 'customers', 'action' => 'edit', $customers_id, 'plugin' => 'admin']);
        }

        $customer = $this->CustomersAddresses->Customers->get($customers_id);

        $this->set(compact('customersAddress', 'customer'));
        $this->set('_serialize', 'customersAddress');
    }

    /**
     * @param null $id
     * @param null $customers_id
     * @return \Cake\Http\Response|null
     */
    public function edit($id = null, $customers_id = null)
    {
        if (!$customers_id || !$this->CustomersAddresses->Customers->exists(['id' => $customers_id])) {
            $this->Flash->error(__('Cliente não encontrado'));
            return $this->redirect(['controller' => 'customers', 'plugin' => 'admin']);
        }

        $customersAddress = $this->CustomersAddresses->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customersAddress = $this->CustomersAddresses->patchEntity($customersAddress, $this->request->getData());
            if ($this->CustomersAddresses->save($customersAddress)) {
                $this->Flash->success(__('O endereço foi salvo.'));
            }else{
                $this->Flash->error(__('O endereço não foi salvo. Por favor, tente novamente.'));
            }
            return $this->redirect(['controller' => 'customers', 'action' => 'edit', $customers_id, 'plugin' => 'admin']);
        }

        $customer = $this->CustomersAddresses->Customers->get($customers_id);

        $this->set(compact('customersAddress', 'customer'));
        $this->set('_serialize', 'customersAddress');
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
            $this->Flash->success(__('O endereço foi excluído'));
        } else {
            $this->Flash->error(__('O endereço não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect($this->referer());
    }
}
