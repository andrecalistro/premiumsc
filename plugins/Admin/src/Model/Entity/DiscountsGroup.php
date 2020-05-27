<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * DiscountsGroup Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property int $free_shipping
 * @property float $discount
 * @property int $status
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property \Admin\Model\Entity\DiscountsGroupsCustomer $discounts_groups_customer
 * @property \Admin\Model\Entity\Customer[] $customers
 */
class DiscountsGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, 33333333333333333this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'description' => true,
        'type' => true,
        'free_shipping' => true,
        'discount' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'discounts_groups_customer' => true,
        'customers' => true
    ];
}
