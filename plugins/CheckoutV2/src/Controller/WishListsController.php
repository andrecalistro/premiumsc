<?php

namespace CheckoutV2\Controller;

use Admin\Model\Table\StoresTable;
use Admin\Model\Table\WishListsTable;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Checkout\Controller\Component\WishListComponent;

/**
 * Class WishListsController
 * @package Checkout\Controller
 *
 * @property WishListComponent $WishList
 */
class WishListsController extends AppController
{
    /** @var WishListsTable */
    public $WishLists;

    /** @var StoresTable */
    public $Stores;

    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->WishLists = TableRegistry::getTableLocator()->get('Admin.WishLists');
        $this->Stores = TableRegistry::getTableLocator()->get('Admin.Stores');

        $this->loadComponent('Checkout.WishList');

        $this->Auth->allow(['add', 'saveProductInSession', 'view']);
    }

    /**
     * @param null $productId
     * @return bool
     * @throws \Exception
     */
    public function isLogged($productId = null)
    {
        if (!$this->Auth->user('id')) {
            if ($productId) {
                $this->saveProductInSession($productId);
            }

            return false;
        }
        return true;
    }

    /**
     * Metodo consumido via ajax para adicionar um produto a lista de desejos
     * @return Response
     * @throws \Exception
     */
    public function add()
    {
        $productId = $this->request->getData('productId');
        if (!$this->isLogged($productId)) {
            $response = new Response([
                'status' => 401,
                'body' => json_encode([
                    'message' => 'Você precisa logar para acessar sua loja de desejo',
                    'redirect' => Router::url([
                        'controller' => 'customers',
                        'action' => 'register',
                        'plugin' => 'CheckoutV2'
                    ], ['fullBase' => true])
                ])
            ]);
            return $response;
        }

        $wishList = $this->WishList->getLastWishListActive($this->Auth->user('id'));

        if ($wishList) {
            $this->WishList->addProductWishList($wishList->id, $productId, $this->Auth->user('id'));
        } else {
            $this->WishList->createNewWishList($this->Auth->user('id'), $this->Auth->user('name'), $productId);
        }

        $response = new Response([
            'status' => 200,
            'body' => json_encode([
                'message' => 'Produto adicionado a sua lista de desejos',
                'redirect' => Router::url([
                    'controller' => 'wish-lists',
                    'action' => 'edit',
                    $wishList->id,
                    'plugin' => 'CheckoutV2'
                ], ['fullBase' => true])
            ])
        ]);
        return $response;
    }

    /**
     *
     */
    public function listWishLists()
    {
        $this->viewBuilder()->setTemplatePath('Customers/WishLists');
        $wishLists = $this->paginate($this->WishLists->find()
            ->where([
                'customers_id' => $this->Auth->user('id')
            ])
            ->contain([
                'WishListStatuses'
            ])
            ->order(['WishLists.created' => 'DESC']));

        $this->paginate = [
            'limit' => 20
        ];

        $this->pageTitle = 'Minhas listas de desejos';
        $this->set(compact('wishLists'));
        $this->set('_serialize', ['wishLists']);
    }

    /**
     * @param $wishListId
     * @return Response|null
     */
    public function edit($wishListId)
    {
        $this->viewBuilder()->setTemplatePath('Customers/WishLists');
        $wishList = $this->WishLists->get($wishListId);

        if (!$wishList) {
            $this->Flash->error('Lista de desejos não encontrada.');
            return $this->redirect(['controller' => 'wish-lists', 'action' => 'list-wish-lists', 'plugin' => 'CheckoutV2']);
        }

        $products = $this->paginate($this->WishLists->WishListProducts->find()
            ->where([
                'wish_lists_id' => $wishListId
            ])
            ->contain([
                'WishListProductStatuses',
                'Products' => function ($q) {
                    return $q->contain([
                        'ProductsImages' => function ($q) {
                            return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                        }
                    ]);
                }
            ]));

        $this->pageTitle = $wishList->name;
        $this->set(compact('products', 'wishList'));
        $this->set('_serialize', ['products', 'wishList']);
    }

    /**
     * @param $id
     * @return Response|null
     */
    public function delete($id)
    {
        $product = $this->WishLists->WishListProducts->get($id);

        if (!$product) {
            return $this->redirect($this->referer());
        }

        $this->WishLists->WishListProducts->delete($product);
        $this->Flash->success('Produto removido da lista de desejos');
        return $this->redirect($this->referer());
    }

    /**
     * @param $productId
     * @return mixed
     */
    public function saveProductInSession($productId)
    {
        $productWishListSession = 'wish-list';

        if (!$this->request->getSession()->check($productWishListSession)) {
            $products[] = $productId;
            $this->request->getSession()->write($productWishListSession, $products);
            return $productId;
        }

        $productsListSession = $this->request->getSession()->read($productWishListSession);
        array_push($productsListSession, $productId);
        $this->request->getSession()->write($productWishListSession, $productsListSession);

        return $productId;
    }

    /**
     * @param $slug
     * @param $wishListId
     * @return Response|null
     */
    public function view($slug, $wishListId)
    {
        $this->viewBuilder()->setTemplatePath('Customers/WishLists');
        $wishList = $this->WishLists->get($wishListId);

        if (!$wishList) {
            $this->Flash->error('Lista de desejos não encontrada.');
            return $this->redirect('/');
        }

        $products = $this->paginate($this->WishLists->WishListProducts->find()
            ->where([
                'wish_lists_id' => $wishListId
            ])
            ->contain([
                'WishListProductStatuses',
                'Products' => function ($q) {
                    return $q->contain([
                        'ProductsImages' => function ($q) {
                            return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                        }
                    ]);
                }
            ]));

        $this->pageTitle = $wishList->name;
        $this->description = $wishList->description;
        $this->set(compact('products'));
        $this->set('_serialize', ['products']);
    }

    /**
     * @return Response|null
     */
    public function save()
    {
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $data['customers_id'] = $this->Auth->user('id');
            $data['wish_list_statuses_id'] = 1;

            if ($data['id'] !== '') {
                $wishList = $this->WishLists->get($data['id']);
                $wishList = $this->WishLists->patchEntity($wishList, $data);
                $redirect = ['controller' => 'wish-lists', 'action' => 'edit', $data['id']];
                $message = 'Lista alterada';
            } else {
                $wishList = $this->WishLists->newEntity($data);
                $redirect = ['controller' => 'wish-lists', 'action' => 'list-wish-lists', 'plugin' => 'CheckoutV2'];
                $message = 'Lista adicionada';
            }

            if ($this->WishLists->save($wishList)) {
                $this->Flash->success($message);
                return $this->redirect($redirect);
            }

            $this->Flash->error('Ocorreu um erro ao salvar a lista. Por favor, tente novamente');
            return $this->redirect($redirect);
        }
        return $this->redirect('/');
    }

}