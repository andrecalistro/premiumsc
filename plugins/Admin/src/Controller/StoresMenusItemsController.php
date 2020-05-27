<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\View\CellTrait;

/**
 * StoresMenusItems Controller
 *
 * @property \Admin\Model\Table\StoresMenusItemsTable $StoresMenusItems
 *
 * @method \Admin\Model\Entity\StoresMenusItem[] paginate($object = null, array $settings = [])
 */
class StoresMenusItemsController extends AppController
{
	use CellTrait;

	public $menu_types = ['category' => 'Categoria', 'product' => 'Produto', 'page' => 'Página', 'custom' => 'URL Customizada'];
	public $statuses = [1 => 'Ativo', 0 => 'Inativo'];
	public $targets = ['_self' => 'Abrir na mesma aba', '_blank' => 'Abrir em nova aba'];

    /**
     * View method
     *
     * @param string|null $id Stores Menus Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $storesMenusItem = $this->StoresMenusItems->get($id, [
            'contain' => ['ParentStoresMenusItems', 'StoresMenusGroups', 'ChildStoresMenusItems']
        ]);

		$statuses = $this->statuses;
		$targets = $this->targets;
		$menu_types = $this->menu_types;

        $this->set(compact('storesMenusItem', 'statuses', 'targets', 'menu_types'));
        $this->set('_serialize', ['storesMenusItem']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
    	if (!$id) {
			return $this->redirect(['controller' => 'stores-menus-groups', 'action' => 'index']);
		}
		$stores_menus_groups_id = $id;

        $storesMenusItem = $this->StoresMenusItems->newEntity();
        if ($this->request->is('post')) {
            $storesMenusItem = $this->StoresMenusItems->patchEntity($storesMenusItem, $this->request->getData());
            if ($this->StoresMenusItems->save($storesMenusItem)) {
                $this->Flash->success(__('O item de menu foi salvo!'));

                return $this->redirect(['controller' => 'stores-menus-groups', 'action' => 'view', $storesMenusItem->stores_menus_groups_id]);
            }
            $this->Flash->error(__('O item de menu não pode ser salvo. Por favor, tente novamente.'));
        }
        $parentStoresMenusItems = $this->StoresMenusItems->ParentStoresMenusItems
			->find('list', ['limit' => 200])
			->where(['stores_menus_groups_id' => $stores_menus_groups_id]);
        $storesMenusGroups = $this->StoresMenusItems->StoresMenusGroups->find('list', ['limit' => 200]);

		$statuses = $this->statuses;
		$targets = $this->targets;
		$menu_types = $this->menu_types;

		$this->set(compact('storesMenusItem', 'parentStoresMenusItems', 'storesMenusGroups', 'statuses', 'targets', 'menu_types', 'stores_menus_groups_id'));
        $this->set('_serialize', ['storesMenusItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Stores Menus Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $storesMenusItem = $this->StoresMenusItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $storesMenusItem = $this->StoresMenusItems->patchEntity($storesMenusItem, $this->request->getData());
            if ($this->StoresMenusItems->save($storesMenusItem)) {
                $this->Flash->success(__('O item de menu foi salvo!'));

                return $this->redirect(['controller' => 'stores-menus-groups', 'action' => 'view', $storesMenusItem->stores_menus_groups_id]);
            }
            $this->Flash->error(__('O item de menu não pode ser salvo. Por favor, tente novamente.'));
        }
        $parentStoresMenusItems = $this->StoresMenusItems->ParentStoresMenusItems
			->find('list', ['limit' => 200])
			->where(['stores_menus_groups_id' => $storesMenusItem->stores_menus_groups_id, 'id !=' => $storesMenusItem->id]);
        $storesMenusGroups = $this->StoresMenusItems->StoresMenusGroups->find('list', ['limit' => 200]);

		$statuses = $this->statuses;
		$targets = $this->targets;
		$menu_types = $this->menu_types;

        $this->set(compact('storesMenusItem', 'parentStoresMenusItems', 'storesMenusGroups', 'statuses', 'targets', 'menu_types'));
        $this->set('_serialize', ['storesMenusItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Stores Menus Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $storesMenusItem = $this->StoresMenusItems->get($id);
		$stores_menus_groups_id = $storesMenusItem->stores_menus_groups_id;
        if ($this->StoresMenusItems->delete($storesMenusItem)) {
            $this->Flash->success(__('O item de menu foi apagado!'));
        } else {
            $this->Flash->error(__('O item de menu não pode ser apagado. Por favor, tente novamente.'));
        }

		return $this->redirect(['controller' => 'stores-menus-groups', 'action' => 'view', $stores_menus_groups_id]);
    }


	/**
	 *
	 */
	public function getMenuTypeHtml()
	{
		$menu_type = $this->request->getData('menu_type');
		$current = $this->request->getData('current');

		$content = $this->cell('Admin.MenuType::' . $menu_type, [$current])->render();

		$this->set(compact('content'));
		$this->set('_serialize', ['content']);
	}
}
