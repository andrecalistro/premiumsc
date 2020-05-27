<?php

namespace CheckoutV2\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use CheckoutV2\Controller\Component\WishListComponent;
use CheckoutV2\Model\Table\PaymentsTable;

/**
 * Class AppController
 * @package Checkout\Controller
 *
 * @property WishListComponent $WishList
 */
class AppController extends Controller
{
    /** @var string */
    public $pageTitle;
    public $_steps = [
        'identification' => '',
        'shipping_payment' => '',
        'done' => ''
    ];
    public $paginate = [
        'maxLimit' => 9
    ];

    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->request->getSession()->start();

        $this->loadComponent('CheckoutV2.WishList');

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'authenticate' => [
                'CheckoutV2.Custom' => [
                    'fields' => [
                        'username' => 'login',
                        'password' => 'password'
                    ],
                    'columns' => ['email', 'document_clean'],
                    'userModel' => 'CheckoutV2.Customers'
                ]
            ],
            'authError' => __('Você não tem permissão para acessar essa página'),
            'flash' => ['element' => 'error'],
            'loginRedirect' => [
                'controller' => 'Customers',
                'action' => 'orders'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Customers',
                'action' => 'register'
            ],
            'loginAction' => [
                'controller' => 'Customers',
                'action' => 'register'
            ],
            'logoutRedirect' => [
                'controller' => 'Customers',
                'action' => 'register'
            ]
        ]);

        $this->loadComponent('CheckoutV2.Cart', [
            'session_id' => $this->request->getSession()->id()
        ]);

//        $this->loadComponent('CheckoutV2.Correios', [
//            'session_id' => $this->request->getSession()->id()
//        ]);
//
//        $this->loadComponent('CheckoutV2.Rodonaves', [
//            'session_id' => $this->request->getSession()->id()
//        ]);
//
//        $this->loadComponent('CheckoutV2.Cart', [
//            'session_id' => $this->request->getSession()->id()
//        ]);

        /**
         * @var \Theme\Model\Table\StoresTable $Stores
         */
        $Stores = TableRegistry::getTableLocator()->get(Configure::read('Theme') . '.Stores');
        $this->store = $Stores->getConfig();
        $this->request->getSession()->write('Store', $this->store);
        $this->set("_store", $this->store);
        $this->set("_description", $this->store->seo_description);
        $this->set("_base_url", Router::url("/", true));
        $this->setOgImage($this->store->logo_link);
        $this->set('_theme', Configure::read('Theme'));

        /** @var PaymentsTable $Payments */
        $Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');
        $this->payment_config = $Payments->findConfig('payment');
        $this->set("_payment_config", $this->payment_config);
    }

    /**
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public function isAuthorized($user)
    {
        if ($user['rules_id'] == 999) {
            $this->WishList->addProductsSession($user);
            return true;
        }
        return false;
    }

    /**
     *
     */
    public function getCartProducts()
    {
        $Carts = TableRegistry::getTableLocator()->get('CheckoutV2.Carts');

        $products = $Carts->find('Products', ['session_id' => $this->request->getSession()->id()]);
        $total_products = count($products);

        $this->set("_cart_products", $products);

        if ($total_products > 0) {
            if ($total_products == 1) {
                $this->set('_cart_text', $total_products . ' item');
            } else {
                $this->set('_cart_text', $total_products . ' itens');
            }
        } else {
            $this->set('_cart_text', 'vazio');
        }

        $this->set("_cart_subtotal", $Carts->find('subTotal', ['session_id' => $this->request->getSession()->id()]));
    }

    /**
     * @param $image
     *
     * set og tag image and details
     */
    public function setOgImage($image)
    {
        $data = [
            '_og_image' => '',
            '_og_type' => '',
            '_og_width' => '',
            '_og_height' => ''
        ];


        if (is_file($image)) {
            $info = getimagesize($image);
            if ($info) {
                $data['_og_image'] = $image;
                $data['_og_type'] = $info['mime'];
                $data['_og_width'] = $info[0];
                $data['_og_height'] = $info[1];
            }
        }

        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @param Event $event
     * @return \Cake\Http\Response|null
     */
    public function beforeRender(Event $event)
    {
        $this->viewBuilder()->setTheme(Configure::read('Theme'));
        $this->viewBuilder()->setLayout('store');
        $this->set('_pageTitle', $this->pageTitle);
        return parent::beforeRender($event);
    }

    /**
     * @param $pages_id
     */
    public function getTermsPage($pages_id)
    {
        $Pages = TableRegistry::get(Configure::read('Theme') . '.Pages');
        $page = $Pages->get($pages_id);

        if ($page) {
            $this->set('_link_page_terms', Router::url('/pagina/' . $page->slug, true));
        } else {
            $this->set('_link_page_terms', '#');
        }
    }

    /**
     * @param Event $event
     * @return \Cake\Http\Response|null
     */
    public function beforeFilter(Event $event)
    {
        if ($this->Auth->user('rules_id') == 999) {
            $this->set('_auth', $this->Auth->user());
        } else {
            $this->set('_auth', false);
        }

        return parent::beforeFilter($event);
    }
}