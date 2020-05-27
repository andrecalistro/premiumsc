<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Variations Controller
 *
 * @property \Admin\Model\Table\VariationsTable $Variations
 *
 * @method \Admin\Model\Entity\Variation[] paginate($object = null, array $settings = [])
 */
class VariationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['VariationsGroups']
        ];
        $variations = $this->paginate($this->Variations);

        $this->set(compact('variations'));
        $this->set('_serialize', ['variations']);
    }

    /**
     * View method
     *
     * @param string|null $id Variation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $variation = $this->Variations->get($id, [
            'contain' => ['VariationsGroups', 'Products']
        ]);

        $this->set('variation', $variation);
        $this->set('_serialize', ['variation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $variation = $this->Variations->newEntity();
        if ($this->request->is('post')) {
            $variation = $this->Variations->patchEntity($variation, $this->request->getData());
            if ($this->Variations->save($variation)) {
                $this->Flash->success(__('The variation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The variation could not be saved. Please, try again.'));
        }
        $variationsGroups = $this->Variations->VariationsGroups->find('list', ['limit' => 200]);
        $products = $this->Variations->Products->find('list', ['limit' => 200]);
        $this->set(compact('variation', 'variationsGroups', 'products'));
        $this->set('_serialize', ['variation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Variation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $variation = $this->Variations->get($id, [
            'contain' => ['Products']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $variation = $this->Variations->patchEntity($variation, $this->request->getData());
            if ($this->Variations->save($variation)) {
                $this->Flash->success(__('The variation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The variation could not be saved. Please, try again.'));
        }
        $variationsGroups = $this->Variations->VariationsGroups->find('list', ['limit' => 200]);
        $products = $this->Variations->Products->find('list', ['limit' => 200]);
        $this->set(compact('variation', 'variationsGroups', 'products'));
        $this->set('_serialize', ['variation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Variation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $variation = $this->Variations->get($id);
        if ($this->Variations->delete($variation)) {
            $this->Flash->success(__('The variation has been deleted.'));
        } else {
            $this->Flash->error(__('The variation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
