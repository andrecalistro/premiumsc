<?php

namespace Admin\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class AppController extends Controller
{
    public $_rules_id;
    public $_menus;
    public $store;


    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email']
                ]
            ],
            'authError' => __('Você não tem permissão para acessar essa página'),
            'flash' => ['element' => 'error'],
            'loginRedirect' => [
                'controller' => 'Stores',
                'action' => 'dashboard',
                'plugin' => 'admin'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => 'admin'
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => 'admin'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => 'admin'
            ]
        ]);

        $this->set("_base_url", Router::url("/admin/", true));

        /**
         * @var \App\Model\Table\StoresTable $Stores
         */
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $this->store = $Stores->getConfig();
        $this->request->getSession()->write('Store', $this->store);
        $this->set('_store_name', empty($this->store->name) ? 'Premium Shirts Club' : $this->store->name);
        $this->set('_store_icon', $this->store->thumb_icon_link);
    }

    /**
     * @param Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        $this->viewBuilder()->setTheme('Admin');

        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->getType(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

        if (!in_array($this->response->getType(), ['application/json', 'application/xml'])) {
            $this->viewBuilder()->setClassName('Admin.App');
        }

        $this->set('_class_path', str_replace('/', '-', $this->request->getPath()));

        if (preg_match('/andre/', $this->request->getServerParams()['SERVER_NAME'])) {
            $this->set('_ambient', 'test');
        }else{
            $this->set('_ambient', 'production');
        }
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['login', 'logout']);
        return parent::beforeFilter($event);
    }

    /**
     * @param $user
     * @return bool
     */
    public function isAuthorized($user)
    {
        if (in_array($user['rules_id'], [1, 2])) {
            $this->findMenusUser($user['rules_id']);
            return true;
        }
        return false;
    }

    /**
     * @param $rules_id
     */
    public function findMenusUser($rules_id)
    {
        $Rules = TableRegistry::getTableLocator()->get('Admin.Rules');

        $this->_rules_id = 1;

        $menus = $Rules->find('all')
            ->contain(['Menus' => function ($q) {
                return $q->find('threaded')->order(['Menus.position' => 'ASC'])->where(['Menus.status' => 1]);
            }])
            ->where(['Rules.id' => $rules_id])
            ->first();
        $this->set(['_menus' => $menus->menus]);
    }
}