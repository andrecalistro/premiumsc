<?php
/**
 * @var \App\View\AppView $this
 */
$gtag = null;
if($store->google_analytics_ecommerce_status) {
    $gtag = "gtag('event', 'purchase',{\"transaction_id\":\"{$order->id}\",\"affiliation\":\"{$store->name}\",\"value\":{$order->total},\"currency\":\"BRL\",\"shipping\":{$order->shipping_total},\"items\":[";
    foreach($order->orders_products as $orders_product){
        $gtag .= "{
                \"id\":\"{$orders_product->products_id}\",\"name\":\"{$orders_product->name}\",\"category\":\"\",\"variant\":\"\",\"quantity\":{$orders_product->quantity},\"price\":\"{$orders_product->price}\"},";
    }
    $gtag .= "]});";
}
if ($gtag) {
    dd($gtag);
    echo $this->Html->scriptBlock($gtag, ['block' => 'scriptBottom']);
}