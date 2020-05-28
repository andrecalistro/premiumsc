<?php

namespace Theme\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 *
 */
class AppController extends \CheckoutV2\Controller\AppController
{
    public $pageTitle;
    public $store;
    public $payment_config;
    public $_bodyClass;

    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->_bodyClass = '';
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        $this->viewBuilder()->setTheme(Configure::read('Theme'));
        $this->viewBuilder()->setLayout('store');

        $this->set('_pageTitle', $this->pageTitle);

        $Categories = TableRegistry::get(Configure::read('Theme') . '.Categories');
        $categories = $Categories->find()
            ->where([
                'Categories.status' => 1,
                'Categories.show_launch_menu' => 0,
                'OR' => [
                    'Categories.parent_id' => 0,
                    'Categories.parent_id IS NULL'
                ]
            ])
            ->order(['Categories.order_show' => 'ASC', 'Categories.title' => 'ASC'])
            ->toArray();

		$menu_categories = $Categories->find()
			->where(['Categories.status' => 1, 'Categories.show_launch_menu' => 1, 'Categories.parent_id IS NULL'])
			->order(['Categories.order_show' => 'ASC', 'Categories.title' => 'ASC'])
			->toArray();

        $this->set("_categories", $categories);
		$this->set("_menu_categories", $menu_categories);

        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->getType(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

        if (!in_array($this->response->getType(), ['application/json', 'application/xml'])) {
            $this->viewBuilder()->setClassName(Configure::read('Theme') . '.Custom');
        }

        $this->getCartProducts();

        $this->set('_bodyClass', $this->_bodyClass);
    }

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
