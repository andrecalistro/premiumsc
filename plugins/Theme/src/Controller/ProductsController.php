<?php

namespace Theme\Controller;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\View\CellTrait;
use Cake\View\View;

/**
 * Products Controller
 *
 * @property \Theme\Model\Table\ProductsTable $Products
 * @property \Theme\Model\Table\ShipmentsTable $Shipments
 */
class ProductsController extends AppController
{
    use CellTrait;
    public $Shipments;

    /**
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();

        $this->Shipments = TableRegistry::get('Shipments');
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => [
                'Positions',
                'Categories' => function ($q) {
                    return $q->select(['Categories.abbreviation', 'Categories.title', 'Categories.id'])->limit(1);
                },
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                },
                'ProductsAttributes' => function ($q) {
                    return $q->where(['value <>' => ''])
                        ->contain(['Attributes']);
                },
                'Filters' => function (Query $q) {
                    return $q->contain(['FiltersGroups']);
                },
                'ProductsChilds' => function ($q) {
                    return $q->contain(['ProductsImages' => function ($q) {
                        return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                    },
                        'Categories' => function ($q) {
                            return $q->select(['Categories.abbreviation']);
                        }])
                        ->order('rand()')
                        ->limit(7);
                },
                'ProductsTabs',
                'ProductsVariations' => function ($q) {
                    return $q->contain([
                        'Variations',
                        'VariationsGroups'
                    ]);
                }
            ]
        ]);

        $total_products_childs = count($product->products_childs);

        if ($total_products_childs < 4) {
            $query = $this->Products->find()
                ->contain([
                    'ProductsImages' => function ($q) {
                        return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                    },
                    'Categories' => function ($q) {
                        return $q->select(['Categories.abbreviation']);
                    }
                ])
                ->where(['Products.id <>' => $id])
                ->limit(4 - $total_products_childs)
                ->order('rand()');

            if (isset($product->categories[0]->id)) {
                $query->matching('Categories', function ($q) use ($product) {
                    return $q->where(['Categories.id' => $product->categories[0]->id]);
                });
            }

            $products = $query->toArray();

            $product->products_childs = array_merge($product->products_childs, $products);
        }

        //breadcumb
        $breadcrumbs = [];
        if ($product->categories) {
            foreach ($product->categories as $category) {
                $breadcrumbs[] = [
                    'link' => $category->full_link,
                    'name' => $category->title
                ];
            }
        }
        $breadcrumbs[] = [
            'link' => $product->full_link,
            'name' => $product->name
        ];

        $this->pageTitle = empty($product->seo_title) ? $product->name : $product->seo_title;
        $this->_bodyClass = 'produto-interna';
        $this->setOgImage($product->main_image);
        $this->set('_description', $product->seo_description);
        $this->set(compact('product', 'breadcrumbs'));
        $this->set('_serialize', ['product']);
    }

    /**
     * @param null $param
     * @return \Cake\Http\Response|null
     */
    public function search($param = null)
    {
        if ($this->request->is('post')) {
            $ProductsSearches = $this->loadModel(Configure::read("Theme") . '.ProductsSearches');
            $ProductsSearches->save(
                $ProductsSearches->newEntity([
                    'term' => $param,
                    'ip' => $this->request->clientIp(),
                    'customers_id' => $this->request->getSession()->read('Auth.User.rules_id') == 999 ? $this->request->getSession()->read('Auth.User.id') : ''
                ])
            );

            return $this->redirect(['controller' => 'products', 'action' => 'search', 'plugin' => 'theme', 'param' => $this->request->getData('p')]);
        }

        $paginator_url = [
            '_name' => 'search',
            'param' => $param
        ];
        $filters_query = [];

        $query = $this->Products->find()
            ->where([
                'OR' => [
                    'Products.name LIKE' => '%' . $param . '%',
                    'Products.description' => '%' . $param . '%',
                    'Products.tags' => '%' . $param . '%'
                ]
            ])
            ->contain([
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                },
                'ProductsConditions',
                'Filters' => function ($q) {
                    return $q->contain(['FiltersGroups']);
                }
            ]);

        $query_params = $this->request->getQueryParams();

        if ($query_params) {
            foreach ($query_params as $slug => $filter_query) {
                if (!in_array($slug, ['direction', 'sort', 'limit', 'page'])) {
                    $paginator_url['?'][$slug] = $filter_query;
                    $ids = explode(",", $filter_query);
                    foreach ($ids as $id) {
                        $filters_query[] = $id;
                    }
                }
            }
            if ($filters_query) {
                $query->matching('Filters', function ($q) use ($filters_query) {
                    return $q->where(['Filters.id IN' => $filters_query]);
                });
                $query->group(['Products.id']);
            }
        }

        if (!array_key_exists('direction', $query_params)) {
            $query->order(['Products.created' => 'DESC']);
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

        $this->_bodyClass = 'produtos style-2';
        $title = $this->pageTitle = "Resultados de busca para \"{$param}\"";
        $this->set(compact('products', 'title', 'filters', 'filters_query', 'sort_links', 'paginator_url', 'param'));
        $this->set('_serialize', ['products']);
    }

    /**
     *
     */
    public function getQuote()
    {
        $address['zipcode'] = $this->request->getData('zipcode');
        $product = $this->Products->get($this->request->getData('products_id'));
        $product->quantity = $this->request->getData('quantity');
        $price = empty($product->price_special) ? $product->price : $product->price_special;
        $product->total_price = $product->quantity * $price;

        $shipments = $this->Shipments->find('enables')->toArray();
        $quotes = [];

        if ($shipments) {
            foreach ($shipments as $shipment) {
                $shipment_code = Inflector::camelize($shipment->code);

                if (method_exists($this->$shipment_code, 'getQuote')) {
                    $quotes[] = $this->$shipment_code->getQuote($address, $product);
                }
            }
        }

        $content = '';
        $allShipments = [];

        foreach ($quotes as $quote) {
            if (!$quote['error']) {
                foreach ($quote['quote'] as $shipment) {
                    $allShipments[] = $shipment;
                }
            }
        }

        usort($allShipments, function ($a, $b) {
            return floatval($a['cost']) - floatval($b['cost']);
        });

        foreach ($allShipments as $shipment) {
            $content .= $this->cell(Configure::read('Theme') . ".Shipment::simulateQuote", [$shipment]);
        }

        if (empty($content)) {
            $content = '<p>Nenhuma opção de envio disponível para seu endereço.</p>';
        }

        $this->set(compact('content'));
    }

    /**
     *
     */
    public function all()
    {
        $this->pageTitle = 'Produtos';
        $this->_bodyClass = 'produtos';

        $categories = $this->Products->Categories->find()
            ->contain([
                'Products' => function (Query $q) {
                    return $q->contain([
                        'ProductsImages' => function (Query $q) {
                            return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                        }
                    ]);
                }
            ])
            ->toArray();

        $this->set(compact('categories'));
    }
}