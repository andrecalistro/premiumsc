<?php

namespace Admin\Model;

use Admin\Model\Entity\Product;

/**
 * Trait ProductTrait
 * @package Admin\Model
 *
 * @var Product $this
 */
trait ProductTrait
{
    public function updateStatusAndStock($orders_id, $products_statuses_id, $stock_control = 'neutral')
    {
        $orders_products = $this->OrdersProducts->find()
            ->contain([
                'Products',
                'OrdersProductsVariations'
            ])
            ->where(['OrdersProducts.orders_id' => $orders_id])
            ->toArray();

        foreach ($orders_products as $orders_product) {
            if ($orders_product->product->stock_control) {
                if ($orders_product->orders_products_variations) {
                    foreach ($orders_product->orders_products_variations as $orders_products_variation) {
                        $variation = $this->ProductsVariations->find()
                            ->where([
                                'ProductsVariations.products_id' => $orders_products_variation->products_id,
                                'ProductsVariations.variations_id' => $orders_products_variation->variations_id
                            ])
                            ->first();

                        if ($variation) {
                            if ($stock_control == 'up') {
                                $variation->stock = $variation->stock + $orders_product->quantity;
                            }
                            if ($stock_control == 'down') {
                                $variation->stock = $variation->stock - $orders_product->quantity;
                            }

                            $this->ProductsVariations->save($variation);
                        }
                        $product = $this->get($orders_product->product->id);
                        if ($stock_control == 'up') {
                            $product->stock = $product->stock + $orders_product->quantity;
                        }
                        if ($stock_control == 'down') {
                            $product->stock = $product->stock - $orders_product->quantity;
                        }

                        if ($product->stock > 0) {
                            $product->status = 1;
                        } else {
                            $product->status = $products_statuses_id;
                        }

                        $this->save($product);
                    }
                } else {
                    $product = $orders_product->product;
                    if ($stock_control == 'up') {
                        $product->stock = $product->stock + $orders_product->quantity;
                    }
                    if ($stock_control == 'down') {
                        $product->stock = $product->stock - $orders_product->quantity;
                    }

                    if ($product->stock > 0) {
                        $product->status = 1;
                    } else {
                        $product->status = $products_statuses_id;
                    }

                    $this->save($product);
                }
            }
        }
        return true;
    }
}