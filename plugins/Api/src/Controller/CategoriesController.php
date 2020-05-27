<?php

namespace Api\Controller;

use Admin\Model\Table\CategoriesTable;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Class CategoriesController
 * @package Api\Controller
 *
 * @property CategoriesTable $Categories
 */
class CategoriesController extends AppController
{
    public $Categories;

    public function initialize()
    {
        parent::initialize();
        $this->Categories = TableRegistry::getTableLocator()->get(Configure::read('Theme') . '.Categories');
    }

    /**
     *
     */
    public function index()
    {
        $conditions = ['Categories.status' => 1];

        if ($this->request->getQuery('launch') !== null) {
            $conditions[] = ['Categories.show_launch_menu' => $this->request->getQuery('launch')];
        }

        $categories = $this->Categories->find()
            ->where($conditions)
            ->contain([
                'ParentCategories',
                'Products' => function ($q) {
                    return $q->contain([
                        'ProductsImages' => function ($q) {
                            return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                        }
                    ]);
                }
            ])
            ->order(['Categories.order_show' => 'ASC', 'Categories.title' => 'ASC']);

        if ($this->request->getQuery('limit') !== null) {
            $categories->limit($this->request->getQuery('limit'));
        }

        $categories = $categories->toArray();

        $this->set(compact('categories'));
        $this->set('_serialize', ['categories']);
    }

    public function view($categories_id)
    {
        $category = $this->Categories->find()
            ->where(['Categories.id' => $categories_id])
            ->contain([
                'ParentCategories',
                'Products' => function ($q) {
                    return $q->contain([
                        'ProductsImages' => function ($q) {
                            return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                        }
                    ]);
                }
            ])
            ->toArray();

        $this->set(compact('category'));
        $this->set('_serialize', ['category']);
    }
}