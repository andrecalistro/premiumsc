<?php

namespace Admin\Controller;

/**
 * OrdersStatuses Controller
 *
 * @property \Admin\Model\Table\OrdersStatusesTable $OrdersStatuses
 */
class OrdersStatusesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $ordersStatuses = $this->OrdersStatuses->find()
            ->toArray();

        if ($this->request->is(['post', 'put'])) {
            $ordersStatuses = $this->OrdersStatuses->patchEntities($ordersStatuses, $this->request->getData('orders_statuses'));
            if ($this->OrdersStatuses->saveMany($ordersStatuses)) {
                $this->Flash->success(__('Status alterados com sucesso'));
                return $this->redirect(['controller' => 'orders-statuses', 'action' => 'index']);
            }
            $this->Flash->error(__('Ocorreu um problema ao salvar os status. Por favor, tente novamente.'));
        }

        $this->set(compact('ordersStatuses'));
        $this->set('_serialize', ['ordersStatuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Orders Status id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ordersStatus = $this->OrdersStatuses->get($id);

        $this->set('ordersStatus', $ordersStatus);
        $this->set('_serialize', ['ordersStatus']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ordersStatus = $this->OrdersStatuses->newEntity();
        if ($this->request->is('post')) {
            $ordersStatus = $this->OrdersStatuses->patchEntity($ordersStatus, $this->request->getData());
            if ($this->OrdersStatuses->save($ordersStatus)) {
                $this->Flash->success(__('O status do pedido foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O status do pedido não foi salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('ordersStatus'));
        $this->set('_serialize', ['ordersStatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Orders Status id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ordersStatus = $this->OrdersStatuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ordersStatus = $this->OrdersStatuses->patchEntity($ordersStatus, $this->request->getData());
            if ($this->OrdersStatuses->save($ordersStatus)) {
                $this->Flash->success(__('O status do pedido foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O status do pedido não foi salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('ordersStatus'));
        $this->set('_serialize', ['ordersStatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Orders Status id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ordersStatus = $this->OrdersStatuses->get($id);
        if ($this->OrdersStatuses->delete($ordersStatus)) {
            $this->Flash->success(__('O status do pedido foi excluído.'));
        } else {
            $this->Flash->error(__('O status do pedido não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
