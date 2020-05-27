<?php

namespace Integrators\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Integrators\Model\Table\BlingCustomersTable;
use Integrators\Model\Table\BlingOrdersTable;
use Integrators\Model\Table\BlingProductsTable;
use Integrators\Model\Table\BlingProvidersTable;
use SimpleXMLElement;

/**
 * Bling component
 *
 * @property BlingProductsTable $BlingProducts
 * @property BlingProvidersTable $BlingProviders
 * @property BlingCustomersTable $BlingCustomers
 * @property BlingOrdersTable $BlingOrders
 */
class BlingComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $BlingProducts;
    public $BlingProviders;
    public $BlingCustomers;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $configs = $Stores->findConfig('bling');
        foreach ($configs as $key => $config) {
            $this->setConfig(str_replace('bling_', '', $key), $config);
        }

        $this->BlingProducts = TableRegistry::getTableLocator()->get('Integrators.BlingProducts', ['api_key' => $this->getConfig('api_key')]);
        $this->BlingProviders = TableRegistry::getTableLocator()->get('Integrators.BlingProviders', ['api_key' => $this->getConfig('api_key')]);
        $this->BlingCustomers = TableRegistry::getTableLocator()->get('Integrators.BlingCustomers', ['api_key' => $this->getConfig('api_key')]);
        $this->BlingOrders = TableRegistry::getTableLocator()->get('Integrators.BlingOrders', ['api_key' => $this->getConfig('api_key')]);
    }

    /**
     * @param $providers_id
     * @return array|mixed|object
     */
    public function synchronizeProvider($providers_id)
    {
        return $this->BlingProviders->postProvider($providers_id);
    }

    /**
     * @param $providers_id
     * @return array|bool|mixed|object
     */
    public function synchronizeProviderCrud($providers_id)
    {
        if ($this->getConfig('synchronize_providers')) {
            return $this->BlingProviders->postProvider($providers_id);
        }
        return false;
    }

    /**
     * @param $products_id
     * @return mixed
     */
    public function synchronizeProduct($products_id)
    {
        return $this->BlingProducts->postProduct($products_id);
    }

    /**
     * @param $products_id
     * @return array|bool|mixed|object
     */
    public function synchronizeProductCrud($products_id)
    {
        if ($this->getConfig('synchronize_products')) {
            return $this->BlingProducts->postProduct($products_id);
        }
        return false;
    }

    /**
     * @param $customers_id
     * @return array|mixed|object
     */
    public function synchronizeCustomer($customers_id)
    {
        return $this->BlingCustomers->postCustomer($customers_id);
    }

    /**
     * @param $customers_id
     * @return array|bool|mixed|object
     */
    public function synchronizeCustomerCrud($customers_id)
    {
        if ($this->getConfig('synchronize_customers')) {
            return $this->BlingCustomers->postCustomer($customers_id);
        }
        return false;
    }

    /**
     * @param $orders_id
     * @return mixed
     */
    public function synchronizeOrder($orders_id)
    {
        return $this->BlingOrders->postOrder($orders_id);
    }
}
