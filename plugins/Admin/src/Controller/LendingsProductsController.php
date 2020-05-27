<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * LendingsProducts Controller
 *
 * @property \Admin\Model\Table\LendingsProductsTable $LendingsProducts
 *
 * @method \Admin\Model\Entity\LendingsProduct[] paginate($object = null, array $settings = [])
 */
class LendingsProductsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Lendings', 'Products']
        ];
        $lendingsProducts = $this->paginate($this->LendingsProducts);

        $this->set(compact('lendingsProducts'));
        $this->set('_serialize', ['lendingsProducts']);
    }

    /**
     * View method
     *
     * @param string|null $id Lendings Product id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lendingsProduct = $this->LendingsProducts->get($id, [
            'contain' => ['Lendings', 'Products']
        ]);

        $this->set('lendingsProduct', $lendingsProduct);
        $this->set('_serialize', ['lendingsProduct']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lendingsProduct = $this->LendingsProducts->newEntity();
        if ($this->request->is('post')) {
            $lendingsProduct = $this->LendingsProducts->patchEntity($lendingsProduct, $this->request->getData());
            if ($this->LendingsProducts->save($lendingsProduct)) {
                $this->Flash->success(__('The lendings product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lendings product could not be saved. Please, try again.'));
        }
        $lendings = $this->LendingsProducts->Lendings->find('list', ['limit' => 200]);
        $products = $this->LendingsProducts->Products->find('list', ['limit' => 200]);
        $this->set(compact('lendingsProduct', 'lendings', 'products'));
        $this->set('_serialize', ['lendingsProduct']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lendings Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lendingsProduct = $this->LendingsProducts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lendingsProduct = $this->LendingsProducts->patchEntity($lendingsProduct, $this->request->getData());
            if ($this->LendingsProducts->save($lendingsProduct)) {
                $this->Flash->success(__('The lendings product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lendings product could not be saved. Please, try again.'));
        }
        $lendings = $this->LendingsProducts->Lendings->find('list', ['limit' => 200]);
        $products = $this->LendingsProducts->Products->find('list', ['limit' => 200]);
        $this->set(compact('lendingsProduct', 'lendings', 'products'));
        $this->set('_serialize', ['lendingsProduct']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lendings Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lendingsProduct = $this->LendingsProducts->get($id);
        if ($this->LendingsProducts->delete($lendingsProduct)) {
            $this->Flash->success(__('The lendings product has been deleted.'));
        } else {
            $this->Flash->error(__('The lendings product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
