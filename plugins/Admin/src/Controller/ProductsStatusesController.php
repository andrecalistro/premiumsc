<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * ProductsStatuses Controller
 *
 * @property \Admin\Model\Table\ProductsStatusesTable $ProductsStatuses
 *
 * @method \Admin\Model\Entity\ProductsStatus[] paginate($object = null, array $settings = [])
 */
class ProductsStatusesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $productsStatuses = $this->paginate($this->ProductsStatuses);

        $this->set(compact('productsStatuses'));
        $this->set('_serialize', ['productsStatuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Products Status id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productsStatus = $this->ProductsStatuses->get($id, [
            'contain' => []
        ]);

        $this->set('productsStatus', $productsStatus);
        $this->set('_serialize', ['productsStatus']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productsStatus = $this->ProductsStatuses->newEntity();
        if ($this->request->is('post')) {
            $productsStatus = $this->ProductsStatuses->patchEntity($productsStatus, $this->request->getData());
            if ($this->ProductsStatuses->save($productsStatus)) {
                $this->Flash->success(__('The products status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The products status could not be saved. Please, try again.'));
        }
        $this->set(compact('productsStatus'));
        $this->set('_serialize', ['productsStatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Products Status id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productsStatus = $this->ProductsStatuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productsStatus = $this->ProductsStatuses->patchEntity($productsStatus, $this->request->getData());
            if ($this->ProductsStatuses->save($productsStatus)) {
                $this->Flash->success(__('The products status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The products status could not be saved. Please, try again.'));
        }
        $this->set(compact('productsStatus'));
        $this->set('_serialize', ['productsStatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Products Status id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productsStatus = $this->ProductsStatuses->get($id);
        if ($this->ProductsStatuses->delete($productsStatus)) {
            $this->Flash->success(__('The products status has been deleted.'));
        } else {
            $this->Flash->error(__('The products status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
