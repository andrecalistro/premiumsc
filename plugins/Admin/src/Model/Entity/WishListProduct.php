<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * WishListProduct Entity
 *
 * @property int $id
 * @property int|null $customers_id
 * @property int $products_id
 * @property int $wish_lists_id
 * @property int|null $orders_id
 * @property int|null $wish_list_product_statuses_id
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property \Admin\Model\Entity\Customer $customer
 * @property \Admin\Model\Entity\Product $product
 * @property \Admin\Model\Entity\WishList $wish_list
 * @property \Admin\Model\Entity\Order $order
 * @property \Admin\Model\Entity\WishListProductStatus $wish_list_product_status
 */
class WishListProduct extends Entity
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
        'products_id' => true,
        'wish_lists_id' => true,
        'orders_id' => true,
        'wish_list_product_statuses_id' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'customer' => true,
        'product' => true,
        'wish_list' => true,
        'order' => true,
        'wish_list_product_status' => true
    ];

    protected $_virtual = [
        'label'
    ];

    /**
     * @return string
     */
    protected function _getLabel()
    {
        if (empty($this->_properties)) {
            return null;
        }

        switch ($this->_properties['wish_list_product_statuses_id']) {
            case 2:
                return '<span class="badge badge-primary">Aguardando pagamento</span>';

            case 3:
                return '<span class="badge badge-success">Comprado</span>';

            default:
                return '<span class="badge badge-secondary">Não comprado</span>';
        }
    }
}
