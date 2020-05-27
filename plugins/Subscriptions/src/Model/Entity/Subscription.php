<?php

namespace Subscriptions\Model\Entity;

use Cake\ORM\Entity;
use Checkout\Model\Entity\Customer;
use Checkout\Model\Entity\CustomersAddress;

/**
 * Subscription Entity
 *
 * @property int $id
 * @property int $customers_id
 * @property int $customers_addresses_id
 * @property int $plans_id
 * @property string $plans_name
 * @property string $plans_image
 * @property string|null $plans_thumb_image
 * @property int $status
 * @property int $frequency_billing_days
 * @property string|null $frequency_billing_name
 * @property int $frequency_delivery_days
 * @property string|null $frequency_delivery_name
 * @property string|null $payment_component
 * @property string|null $payment_method
 * @property string|null $shipping_method
 * @property float|null $price
 * @property float|null $price_shipping
 * @property string|null $code
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property string $price_format
 * @property string $price_shipping_format
 * @property string $price_total_format
 *
 * @property Customer $customer
 * @property CustomersAddress $customers_address
 * @property \Subscriptions\Model\Entity\Plan $plan
 */
class Subscription extends Entity
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
        'customers_id' => true,
        'plans_id' => true,
        'plans_name' => true,
        'plans_image' => true,
        'plans_thumb_image' => true,
        'status' => true,
        'frequency_billing_days' => true,
        'frequency_billing_name' => true,
        'frequency_delivery_days' => true,
        'frequency_delivery_name' => true,
        'payment_component' => true,
        'payment_method' => true,
        'shipping_method' => true,
        'price' => true,
        'price_shipping' => true,
        'code' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'customer' => true,
        'plan' => true
    ];

    protected $_virtual = [
        'price_format',
        'price_shipping_format',
        'price_total_format'
    ];

    /**
     * @return string|null
     */
    protected function _getPriceFormat()
    {
        if (isset($this->_properties['price']) && !empty($this->_properties['price'])) {
            return "R$ " . number_format($this->_properties['price'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return string|null
     */
    protected function _getPriceShippingFormat()
    {
        if (isset($this->_properties['price_shipping']) && !empty($this->_properties['price_shipping'])) {
            return "R$ " . number_format($this->_properties['price_shipping'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return string|null
     */
    protected function _getPriceTotalFormat()
    {
        $total = 0;
        if (isset($this->_properties['price']) && !empty($this->_properties['price'])) {
            $total = $this->_properties['price'];
        }
        if (isset($this->_properties['price_shipping']) && !empty($this->_properties['price_shipping'])) {
            $total = $total + $this->_properties['price_shipping'];
        }
        if ($total) {
            return "R$ " . number_format($total, 2, ",", ".");
        }
        return null;
    }
}
