<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * StocksStatuses Controller
 *
 * @property \Admin\Model\Table\StocksStatusesTable $StocksStatuses
 */
class StocksStatusesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $stocksStatuses = $this->paginate($this->StocksStatuses);

        $this->set(compact('stocksStatuses'));
        $this->set('_serialize', ['stocksStatuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Stocks Status id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stocksStatus = $this->StocksStatuses->get($id, [
            'contain' => []
        ]);

        $this->set('stocksStatus', $stocksStatus);
        $this->set('_serialize', ['stocksStatus']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stocksStatus = $this->StocksStatuses->newEntity();
        if ($this->request->is('post')) {
            $stocksStatus = $this->StocksStatuses->patchEntity($stocksStatus, $this->request->getData());
            if ($this->StocksStatuses->save($stocksStatus)) {
                $this->Flash->success(__('O status de estoque foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O status de estoque não foi salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('stocksStatus'));
        $this->set('_serialize', ['stocksStatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Stocks Status id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stocksStatus = $this->StocksStatuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stocksStatus = $this->StocksStatuses->patchEntity($stocksStatus, $this->request->getData());
            if ($this->StocksStatuses->save($stocksStatus)) {
                $this->Flash->success(__('O status de estoque foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O status de estoque não foi salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('stocksStatus'));
        $this->set('_serialize', ['stocksStatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Stocks Status id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stocksStatus = $this->StocksStatuses->get($id);
        if ($this->StocksStatuses->delete($stocksStatus)) {
            $this->Flash->success(__('O status de estoque foi excluído.'));
        } else {
            $this->Flash->error(__('O status de estoque não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
