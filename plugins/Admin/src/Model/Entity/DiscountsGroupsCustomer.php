<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * DiscountsGroupsCustomer Entity
 *
 * @property int $id
 * @property int $customers_id
 * @property int $discounts_groups_id
 * @property \Cake\I18n\Date $period
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property \Admin\Model\Entity\Customer $customer
 * @property \Admin\Model\Entity\DiscountsGroup $discounts_group
 */
class DiscountsGroupsCustomer extends Entity
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
        'discounts_groups_id' => true,
        'period' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'customer' => true,
        'discounts_group' => true
    ];
}
