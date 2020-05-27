<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * StoresMenusGroups Controller
 *
 * @property \Admin\Model\Table\StoresMenusGroupsTable $StoresMenusGroups
 *
 * @method \Admin\Model\Entity\StoresMenusGroup[] paginate($object = null, array $settings = [])
 */
class StoresMenusGroupsController extends AppController
{
	public $menu_types = ['category' => 'Categoria', 'product' => 'Produto', 'page' => 'Página', 'custom' => 'URL Customizada'];
	public $statuses = [1 => 'Ativo', 0 => 'Inativo'];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $storesMenusGroups = $this->paginate($this->StoresMenusGroups);

        $this->set(compact('storesMenusGroups'));
        $this->set('_serialize', ['storesMenusGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Stores Menus Group id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $storesMenusGroup = $this->StoresMenusGroups->get($id, [
            'contain' => [
            	'StoresMenusItems' => function ($q) {
					return $q->contain(['ParentStoresMenusItems', 'ChildStoresMenusItems']);
				}
			]
        ]);

        $menu_types = $this->menu_types;

        $this->set(compact('storesMenusGroup', 'menu_types'));
        $this->set('_serialize', ['storesMenusGroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $storesMenusGroup = $this->StoresMenusGroups->newEntity();
        if ($this->request->is('post')) {
            $storesMenusGroup = $this->StoresMenusGroups->patchEntity($storesMenusGroup, $this->request->getData());
            if ($this->StoresMenusGroups->save($storesMenusGroup)) {
                $this->Flash->success(__('O menu foi salvo!'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O menu não pode ser salvo. Por favor, tente novamente.'));
        }

        $statuses = $this->statuses;

        $this->set(compact('storesMenusGroup', 'statuses'));
        $this->set('_serialize', ['storesMenusGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Stores Menus Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $storesMenusGroup = $this->StoresMenusGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $storesMenusGroup = $this->StoresMenusGroups->patchEntity($storesMenusGroup, $this->request->getData());
            if ($this->StoresMenusGroups->save($storesMenusGroup)) {
                $this->Flash->success(__('O menu foi salvo!'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O menu não pode ser salvo. Por favor, tente novamente.'));
        }

        $statuses = $this->statuses;

        $this->set(compact('storesMenusGroup', 'statuses'));
        $this->set('_serialize', ['storesMenusGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Stores Menus Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $storesMenusGroup = $this->StoresMenusGroups->get($id);
        if ($this->StoresMenusGroups->delete($storesMenusGroup)) {
            $this->Flash->success(__('O menu foi apagado!'));
        } else {
            $this->Flash->error(__('O menu não pode ser apagado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
