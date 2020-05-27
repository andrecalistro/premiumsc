<?php

namespace CheckoutV2\View\Cell;

use Admin\Model\Table\StoresTable;
use Cake\Controller\Component\AuthComponent;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Class CustomerCell
 * @package Checkout\View\Cell
 */
class CustomerCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    public function forceUpdateData()
    {
        if (!$this->request->getSession()->read('Auth.User.force_update_data')) {
            return false;
        }
        $genders = ['Feminino' => 'Feminino', 'Masculino' => 'Masculino'];
        $Customer = TableRegistry::getTableLocator()->get('CheckoutV2.Customers');
        $customer = $Customer->get($this->request->getSession()->read('Auth.User.id'));
        $this->set(compact('customer', 'genders'));
    }

    /**
     *
     */
    public function menu()
    {
        /** @var StoresTable $Stores */
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');

        $subscriptiosStatus = $Stores->getByKeyword('subscriptions_status');

        $wishListStatus = $Stores->getByKeyword('wish_list_status');

        $this->set(compact('wishListStatus', 'subscriptiosStatus'));
        $this->set('_serialize', ['wishListStatus']);
    }
}