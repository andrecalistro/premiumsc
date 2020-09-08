<?php

namespace Theme\Controller;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Theme\Model\Table\FiltersTable;

/**
 * Categories Controller
 *
 * @property \Theme\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();
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
            'contain' => ['ParentCategories', 'ChildCategories']
        ]);

        $categories[] = $id;

        if ($category->list_categories_child) {
            $categories = array_merge($categories, $category->list_categories_child);
        }

        $paginator_url = [
            'id' => $category->id,
            '_name' => 'category',
            'slug' => $category->slug,
        ];
        $filters_query = [];

        $conditions = [
            'OR' => [
                'Products.stock >' => 0,
                'Products.stock_control' => 0
            ]
        ];

        $query = $this->Categories->Products->find()
            ->contain([
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                },
                'ProductsConditions'
            ])
            ->matching('Categories', function ($q) use ($categories) {
                return $q->where(['Categories.id IN' => $categories]);
            });

        $query_params = $this->request->getQueryParams();
        if (isset($query_params['page'])) {
            unset($query_params['page']);
        }

        if ($query_params) {
            foreach ($query_params as $slug => $filter_query) {
                if (!in_array($slug, ['direction', 'sort', 'limit'])) {
                    $paginator_url['?'][$slug] = $filter_query;
                    $ids = explode(",", $filter_query);
                    foreach ($ids as $id) {
                        if (!in_array($id, $filters_query)) {
                            $filters_query[] = $id;
                        }
                    }
                }
            }
            if ($filters_query) {
                $query->innerJoin('products_filters', ['Products.id = products_filters.products_id']);
                $conditions[] = ['products_filters.filters_id IN ' => $filters_query];
                $query->having(['count(Products.id) >=' => count($filters_query)]);
                $query->group(['Products.id']);
            }
        }

        $query->where($conditions);

        if (!array_key_exists('direction', $query_params)) {
            $query->order(['Products.created' => 'DESC']);
        }

        $products = $this->paginate($query);

        /** @var FiltersTable $FiltersTable */
        $FiltersTable = TableRegistry::getTableLocator()->get(Configure::read('Theme') . '.Filters');
        $filters = $FiltersTable->getFiltersByGroup($categories);

        $sort_links = [
            [
                'key' => 'created',
                'title' => 'Novidades',
                'direction' => 'desc'
            ],
            [
                'key' => 'name',
                'title' => 'Nome A-Z',
                'direction' => 'asc'
            ],
            [
                'key' => 'name',
                'title' => 'Nome Z-A',
                'direction' => 'desc'
            ],
            [
                'key' => 'price',
                'title' => 'Preço menor',
                'direction' => 'asc'
            ],
            [
                'key' => 'price',
                'title' => 'Preço maior',
                'direction' => 'desc'
            ]
        ];

        $this->pageTitle = $category->title;
        $this->set(compact('category', 'products', 'filters', 'filters_query', 'paginator_url', 'sort_links'));
        $this->set('_serialize', ['category']);
    }

    public function productsNews()
    {
        $filters_query = [];

        $query = $this->Categories->Products->find()
            ->contain([
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                },
                'ProductsConditions',
                'Filters' => function ($q) {
                    return $q->contain(['FiltersGroups']);
                }
            ])
            ->order(['Products.created' => 'DESC'])
            ->limit(9);

        $query_params = $this->request->getQueryParams();
        if (isset($query_params['page'])) {
            unset($query_params['page']);
        }

        if ($query_params) {
            foreach ($query_params as $slug => $filter_query) {
                $paginator_url['?'][$slug] = $filter_query;
                $ids = explode(",", $filter_query);
                foreach ($ids as $id) {
                    $filters_query[] = $id;
                }
            }
            $query->matching('Filters', function ($q) use ($filters_query) {
                return $q->where(['Filters.id IN' => $filters_query]);
            });
            $query->group(['Products.id']);
        }

        $products = $this->paginate($query);

        $Filters = TableRegistry::get(Configure::read('Theme') . '.Filters');
        $filters = $Filters->FiltersGroups->find()
            ->contain([
                'Filters' => function ($q) {
                    return $q->orderAsc('Filters.name');
                }
            ])
            ->toArray();

        $this->pageTitle = 'Novidades';
        $this->set(compact('products', 'filters', 'filters_query'));
    }
}
