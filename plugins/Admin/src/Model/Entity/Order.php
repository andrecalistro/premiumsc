<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $customers_id
 * @property int $customers_addresses_id
 * @property int $orders_statuses_id
 * @property string $zipcode
 * @property string $address
 * @property string $number
 * @property string $complement
 * @property string $neighborhood
 * @property string $city
 * @property string $state
 * @property float $subtotal
 * @property float $shipping_total
 * @property float $total
 * @property string $payment_method
 * @property string $payment_id
 * @property string $payment_url
 * @property string $ip
 * @property string $shipping_code
 * @property string $shipping_text
 * @property int $shipping_deadline
 * @property string $shipping_image
 * @property \Cake\I18n\Date $shipping_sent_date
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Customer $customer
 * @property \Admin\Model\Entity\CustomersAddress $customers_address
 * @property \Admin\Model\Entity\OrdersStatus $orders_status
 * @property \Admin\Model\Entity\Payment $payment
 * @property \Admin\Model\Entity\Product[] $products
 */
class Order extends Entity
{
    protected $_virtual = [
        'subtotal_format',
        'shipping_total_format',
        'total_format',
        'bling_status',
        'discount_format'
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
    protected function _getSubtotalFormat()
    {
        if (isset($this->_properties['subtotal']) && !empty($this->_properties['subtotal'])) {
            return "R$ " . number_format($this->_properties['subtotal'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getShippingTotalFormat()
    {
        if (isset($this->_properties['shipping_total']) && !empty($this->_properties['shipping_total'])) {
            return "R$ " . number_format($this->_properties['shipping_total'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getTotalFormat()
    {
        if (isset($this->_properties['total']) && !empty($this->_properties['total'])) {
            return "R$ " . number_format($this->_properties['total'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return null
     */
    protected function _getBlingStatus()
    {
        if (isset($this->_properties['bling_orders'][0]['status']) && !empty($this->_properties['bling_orders'][0]['status'])) {
            return $this->_properties['bling_orders'][0]['status'];
        }
        return 'Não sincronizado';
    }

    /**
     * @return null|string
     */
    protected function _getDiscountFormat()
    {
        if (isset($this->_properties['discount']) && !empty($this->_properties['discount'])) {
            return "- R$ " . number_format($this->_properties['discount'], 2, ",", ".");
        }
        return null;
    }
}
