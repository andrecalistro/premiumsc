<?php

namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \Admin\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentCategories']
        ];
        $categories = $this->paginate($this->Categories);

        $total = $this->request->getParam('paging')['Categories']['count'];

        if ($total == 0) {
            $messageTotal = __("NENHUMA CATEGORIA ENCONTRADA");
        } else {
            $messageTotal = sprintf(__n("%s CATEGORIA NA BASE DE DADOS", "%s CATEGORIAS NA BASE DE DADOS", $total), $total);
        }

        $this->set(compact('categories', 'messageTotal'));
        $this->set('_serialize', ['categories']);
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => [
                'ParentCategories',
                'Products' => function ($q) {
                    return $q->contain([
                        'ProductsImages' => function ($q) {
                            return $q->order(['ProductsImages.main' => 'DESC']);
                        }
                    ])
                        ->order([
                            'ProductsCategories.order_show' => 'ASC',
                            'Products.id' => 'DESC'
                        ]);
                }
            ]
        ]);

        $this->set('category', $category);
        $this->set('_serialize', ['category']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('A categoria foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A categoria não foi salva. Por favor, tente novamente.'));
        }
        $categories = $this->Categories->ParentCategories->find('list', ['limit' => 200]);
        $statuses = [0 => 'Inativa', 1 => 'Ativa'];
        $products = $this->Categories->ProductsMain->find('list')->order(['name' => 'ASC'])->toArray();
        $this->set(compact('category', 'categories', 'products', 'statuses'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('A categoria foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A categoria não foi salva. Por favor, tente novamente.'));
        }
        $categories = $this->Categories->ParentCategories->find('list', ['limit' => 200])
            ->where(['id <>' => $id]);
        $statuses = [0 => 'Inativa', 1 => 'Ativa'];
        $products = $this->Categories->ProductsMain->find('list')->order(['name' => 'ASC'])->toArray();
        $this->set(compact('category', 'categories', 'statuses', 'products'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('A categoria foi excluída.'));
        } else {
            $this->Flash->error(__('A categoria não foi excluída. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function refreshCount()
    {
        $categories = $this->Categories->find()
            ->contain(['ParentCategories', 'ChildCategories'])
            ->toArray();

        foreach ($categories as $category) {
            $categoriesIds = [$category->id];

            if ($category->list_categories_child) {
                $categoriesIds = array_merge($categoriesIds, $category->list_categories_child);
            }

            $products = $this->Categories->Products->find()
                ->matching('Categories', function ($q) use ($categoriesIds) {
                    return $q->where(['Categories.id IN' => $categoriesIds]);
                })
                ->where(['Products.status' => 1]);

            $this->Categories->query()
                ->update()
                ->set(['products_total' => $products->count()])
                ->where(['id' => $category->id])
                ->execute();
        }

        $this->Flash->success(__('Contagem dos produtos atualizada.'));
        return $this->redirect(['controller' => 'categories', 'action' => 'index']);
    }

    public function saveOrder()
    {
        $products_categories = explode(",", $this->request->getData('products'));
        $data = [];
        foreach ($products_categories as $key => $products_category) {
            $data[] = [
                'id' => $products_category,
                'order_show' => $key + 1
            ];
        }
        $data = $this->Categories->ProductsCategories->newEntities($data);
        if ($this->Categories->ProductsCategories->saveMany($data)) {
            $status = true;
        } else {
            $status = false;
        }
        $this->set(compact('status'));
        $this->set('_serialize', 'status');
    }
}
