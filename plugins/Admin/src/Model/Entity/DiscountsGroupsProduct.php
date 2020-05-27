<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * DiscountsGroupsProduct Entity
 *
 * @property int $id
 * @property int $product_id
 * @property int $discounts_groups_id
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property \Admin\Model\Entity\DiscountsGroup $discounts_group
 * @property \Admin\Model\Entity\Product $product
 */
class DiscountsGroupsProduct extends Entity
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
        'products_id' => true,
        'discounts_groups_id' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'product' => true,
        'discounts_group' => true
    ];
}
