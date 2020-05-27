<?php
namespace CheckoutV2\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coupon Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $code
 * @property string $type
 * @property float $value
 * @property bool $free_shipping
 * @property \Cake\I18n\FrozenTime $release_date
 * @property \Cake\I18n\FrozenTime $expiration_date
 * @property float $min_value
 * @property float $max_value
 * @property bool $only_individual_use
 * @property bool $exclude_promotional_items
 * @property string $products_ids
 * @property string $excluded_products_ids
 * @property string $categories_ids
 * @property string $excluded_categories_ids
 * @property string $restricted_emails_list
 * @property int $use_limit
 * @property int $used_limit
 * @property int $customer_use_limit
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 */
class Coupon extends Entity
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
