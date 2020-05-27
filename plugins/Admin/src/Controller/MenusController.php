<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Menus Controller
 *
 * @property \Admin\Model\Table\MenusTable $Menus
 *
 * @method \Admin\Model\Entity\Menu[] paginate($object = null, array $settings = [])
 */
class MenusController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentMenus', 'ChildMenus'],
            'order' => ['Menus.name' => 'ASC'],
        ];
        $menus = $this->paginate($this->Menus);

        $this->set(compact('menus'));
        $this->set('_serialize', ['menus']);
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => ['ParentMenus', 'Rules', 'ChildMenus']
        ]);

        $this->set('menu', $menu);
        $this->set('_serialize', ['menu']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menu = $this->Menus->newEntity();
        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('O menu foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O menu não pode ser salvo. Por favor, tente novamente.'));
        }
        $parentMenus = $this->Menus->ParentMenus->find('list', ['limit' => 200]);
        $rules = $this->Menus->Rules->find('list', ['limit' => 200]);
		$statuses = [1 => 'Ativo', 0 => 'Inativo'];
        $this->set(compact('menu', 'parentMenus', 'rules', 'statuses'));
        $this->set('_serialize', ['menu']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => ['Rules']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('O menu foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
			$this->Flash->error(__('O menu não pode ser salvo. Por favor, tente novamente.'));
        }
        $parentMenus = $this->Menus->ParentMenus->find('list', ['limit' => 200]);
        $rules = $this->Menus->Rules->find('list', ['limit' => 200]);
		$statuses = [1 => 'Ativo', 0 => 'Inativo'];
        $this->set(compact('menu', 'parentMenus', 'rules', 'statuses'));
        $this->set('_serialize', ['menu']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
			$this->Flash->success(__('O menu foi apagado.'));
        } else {
			$this->Flash->error(__('O menu não pode ser apagado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
