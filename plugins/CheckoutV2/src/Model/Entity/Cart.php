<?php

namespace CheckoutV2\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cart Entity
 *
 * @property int $id
 * @property string $session_id
 * @property int $customers_id
 * @property int $products_id
 * @property int $quantity
 * @property string $option
 * @property float $unit_price
 * @property float $total_price
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \Theme\Model\Entity\Customer $customer
 * @property \Theme\Model\Entity\Product $product
 */
class Cart extends Entity
{
    public $_virtual = [
        'unit_price_format', 'total_price_format'
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
    protected function _getUnitPriceFormat()
    {
        if (isset($this->_properties['unit_price']) && !empty($this->_properties['unit_price'])) {
            return "R$ " . number_format($this->_properties['unit_price'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getTotalPriceFormat()
    {
        if (isset($this->_properties['total_price']) && !empty($this->_properties['total_price'])) {
            return "R$ " . number_format($this->_properties['total_price'], 2, ",", ".");
        }
        return null;
    }
}
