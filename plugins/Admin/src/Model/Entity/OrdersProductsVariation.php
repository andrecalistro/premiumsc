<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdersProductsVariation Entity
 *
 * @property int $id
 * @property int $orders_id
 * @property int $orders_products_id
 * @property int $products_id
 * @property int $variations_id
 * @property int $quantity
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Order $order
 * @property \Admin\Model\Entity\OrdersProduct $orders_product
 * @property \Admin\Model\Entity\Product $product
 * @property \Admin\Model\Entity\Variation $variation
 */
class OrdersProductsVariation extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
