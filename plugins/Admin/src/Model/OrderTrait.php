<?php

namespace Admin\Model;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Trait OrderTrait
 * @package Admin\Model
 */
trait OrderTrait
{
    public function updateOrderStatuses($orders_id, $orders_statuses_id, $store)
    {
        if (isset($store->orders_statuses_config->$orders_statuses_id)) {
            $Products = TableRegistry::getTableLocator()->get('Admin.Products');
            $Products->updateStatusAndStock($orders_id, $store->orders_statuses_config->$orders_statuses_id->products_statuses_id, $store->orders_statuses_config->$orders_statuses_id->control_stock);
        }
    }
}