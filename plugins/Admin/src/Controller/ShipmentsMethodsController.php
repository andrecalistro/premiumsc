<?php

namespace Admin\Controller;

/**
 * ShipmentsMethods Controller
 *
 * @property \Admin\Model\Table\ShipmentsMethodsTable $ShipmentsMethods
 *
 * @method \Admin\Model\Entity\ShipmentsMethod[] paginate($object = null, array $settings = [])
 */
class ShipmentsMethodsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $shipmentsMethods = $this->paginate($this->ShipmentsMethods);

        $this->set(compact('shipmentsMethods'));
        $this->set('_serialize', ['shipmentsMethods']);
    }

    /**
     * View method
     *
     * @param string|null $id Shipments Method id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shipmentsMethod = $this->ShipmentsMethods->get($id, [
            'contain' => []
        ]);

        $this->set('shipmentsMethod', $shipmentsMethod);
        $this->set('_serialize', ['shipmentsMethod']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shipmentsMethod = $this->ShipmentsMethods->newEntity();
        if ($this->request->is('post')) {
            $shipmentsMethod = $this->ShipmentsMethods->patchEntity($shipmentsMethod, $this->request->getData());
            if ($this->ShipmentsMethods->save($shipmentsMethod)) {
                $this->Flash->success(__('Método de entrega foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Método de entrega não foi salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('shipmentsMethod'));
        $this->set('_serialize', ['shipmentsMethod']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Shipments Method id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shipmentsMethod = $this->ShipmentsMethods->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shipmentsMethod = $this->ShipmentsMethods->patchEntity($shipmentsMethod, $this->request->getData());
            if ($this->ShipmentsMethods->save($shipmentsMethod)) {
                $this->Flash->success(__('Método de entrega foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Método de entrega não foi salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('shipmentsMethod'));
        $this->set('_serialize', ['shipmentsMethod']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Shipments Method id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shipmentsMethod = $this->ShipmentsMethods->get($id);
        if ($this->ShipmentsMethods->delete($shipmentsMethod)) {
            $this->Flash->success(__('Método de entrega foi excluído.'));
        } else {
            $this->Flash->error(__('Método de entrega não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
