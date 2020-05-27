<?php

namespace CheckoutV2\View\Cell;

use Cake\Controller\Component\AuthComponent;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Class CustomerCell
 * @package Checkout\View\Cell
 */
class CheckoutCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    public function googleEcommerceTag($order, $store)
    {
        $gtag = null;
        if($store->google_analytics_ecommerce_status) {
            $gtag = "gtag('event', 'purchase',{\"transaction_id\":\"{$order->id}\",\"affiliation\":\"{$store->name}\",\"value\":{$order->total},\"currency\":\"BRL\",\"shipping\":{$order->shipping_total},\"items\":[";
            foreach($order->orders_products as $orders_product){
                $gtag .= "{
                \"id\":\"{$orders_product->products_id}\",\"name\":\"{$orders_product->name}\",\"category\":\"\",\"variant\":\"\",\"quantity\":{$orders_product->quantity},\"price\":\"{$orders_product->price}\"},";
            }
            $gtag .= "]});";
        }
        $this->set(compact('gtag'));
    }
}