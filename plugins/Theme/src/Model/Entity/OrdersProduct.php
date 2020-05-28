<?php

namespace Theme\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdersProduct Entity
 *
 * @property int $id
 * @property int $orders_id
 * @property int $products_id
 * @property string $name
 * @property int $products_options_id
 * @property string $image_thumb
 * @property string $image
 * @property int $quantity
 * @property float $price_special
 * @property float $price
 * @property float $price_total
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \Theme\Model\Entity\Order $order
 * @property \Theme\Model\Entity\Product $product
 * @property \Theme\Model\Entity\ProductsOption $products_option
 */
class OrdersProduct extends Entity
{
    protected $_virtual = [
        'price_format',
        'price_total_format',
        'price_special_format'
    ];
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

    /**
     * @return null|string
     */
    protected function _getPriceFormat()
    {
        if (isset($this->_properties['price']) && !empty($this->_properties['price'])) {
            return "R$ " . number_format($this->_properties['price'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getPriceTotalFormat()
    {
        if (isset($this->_properties['price_total']) && !empty($this->_properties['price_total'])) {
            return "R$ " . number_format($this->_properties['price_total'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getPriceSpecialFormat()
    {
        if (isset($this->_properties['price_special']) && !empty($this->_properties['price_special'])) {
            return "R$ " . number_format($this->_properties['price_special'], 2, ",", ".");
        }
        return null;
    }
}
