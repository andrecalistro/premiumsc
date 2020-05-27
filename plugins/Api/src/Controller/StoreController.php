<?php

namespace Api\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Class CartsController
 * @package Api\Controller
 *
 * @property \Theme\Model\Table\StoresTable $Stores
 */
class StoreController extends AppController
{
    public $Stores;

    /**
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->Stores = TableRegistry::getTableLocator()->get(Configure::read("Theme") . '.Stores');
    }

    /**
     *
     */
    public function index()
    {
        $cart_link = Router::url('/carrinho', true);
        $search_link = Router::url('/busca', true);

        $result = $this->Stores->findConfig('store');

        $store = [
            'cart_link' => $cart_link,
            'search_link' => $search_link,
            'home_link' => Router::url('/', true),
            'facebook' => $result->facebook,
            'instagram' => $result->instagram,
            'twitter' => $result->twitter,
            'logo' => Router::url('/img/Stores/' . $result->logo, true)
        ];

        $this->set([
            'store' => $store,
            '_serialize' => ['store']
        ]);
    }
}