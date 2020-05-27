<?php

namespace CheckoutV2\Model\Entity;

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
 * @property float $total_without_discount
 * @property float $discount
 * @property float $discount_percent
 * @property string $payment_method
 * @property string $payment_id
 * @property string $payment_url
 * @property string $ip
 * @property string $shipping_code
 * @property string $shipping_text
 * @property int $shipping_deadline
 * @property string $shipping_image
 * @property string $tracking
 * @property int $orders_types_id
 * @property int $coupons_id
 * @property float $coupon_discount
 * @property string $notes
 * @property int $shipping_required
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \Checkout\Model\Entity\Customer $customer
 * @property \Checkout\Model\Entity\CustomersAddress $customers_address
 * @property \Admin\Model\Entity\OrdersStatus $orders_status
 * @property \Theme\Model\Entity\Product[] $products
 */
class Order extends Entity
{
    protected $_virtual = [
        'subtotal_format',
        'shipping_total_format',
        'total_format',
        'shipment_deadline_text',
        'discount_format',
        'payment_method_text',
        'installments_text',
        'coupon_discount_formatted'.
        'total_installment_format'
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
        if (isset($this->_properties['shipping_total'])) {
            if ($this->_properties['shipping_total'] == 0) {
                return "Grátis";
            }
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
     * @return null|string
     */
    protected function _getShipmentDeadlineText()
    {
        if (isset($this->_properties['shipping_deadline']) && !empty($this->_properties['shipping_deadline'])) {
            return $this->created->addDays($this->_properties['shipping_deadline'])->format('d/m/Y');
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getDiscountFormat()
    {
        if (isset($this->_properties['discount']) && $this->_properties['discount'] > 0) {
            return 'R$ ' . number_format($this->_properties['discount'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return string
     */
    protected function _getPaymentMethodText()
    {
        $text = '';

        if (isset($this->_properties['payment_method']) && !empty($this->_properties['payment_method'])) {
            switch ($this->_properties['payment_method']) {
                case 'ticket':
                    $text = 'Boleto';
                    break;
                case 'credit-card':
                    $text = 'Cartão de Crédito';
                    break;
                case 'debit-card':
                    $text = 'Cartão de Débito';
                    break;
                default:
                    $text = isset($this->_properties['payments_method']['name']) ? $this->_properties['payments_method']['name'] : '';
                    break;
            }
        }

        return $text;
    }

    /**
     * @return string
     */
    protected function _getInstallmentsText()
    {
        if (isset($this->_properties['payment_installment']) && isset($this->_properties['payment_installment_value']) && !empty($this->_properties['payment_installment']) && !empty($this->_properties['payment_installment_value'])) {
            $total_temp = $this->_properties['payment_installment'] * $this->_properties['payment_installment_value'];
            return $this->_properties['payment_installment'] . 'x de R$ ' . number_format($this->_properties['payment_installment_value'], 2, ',', '.') . ' ' . ($total_temp > $this->_properties['total'] ? 'com juros' : 'sem juros');
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getTotalInstallmentFormat()
    {
        if (isset($this->_properties['payment_installment']) && isset($this->_properties['payment_installment_value']) && !empty($this->_properties['payment_installment']) && !empty($this->_properties['payment_installment_value'])) {
            return 'R$ ' . number_format(($this->_properties['payment_installment'] * $this->_properties['payment_installment_value']), 2, ',', '.');
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getCouponDiscountFormatted()
    {
        if (isset($this->_properties['coupon_discount']) && $this->_properties['coupon_discount'] > 0) {
            return 'R$ ' . number_format($this->_properties['coupon_discount'], 2, ",", ".");
        }
        return null;
    }
}
