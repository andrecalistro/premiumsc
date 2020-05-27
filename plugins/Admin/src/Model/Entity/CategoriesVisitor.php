<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * CategoriesVisitor Entity
 *
 * @property int $id
 * @property int $categories_id
 * @property int $customers_id
 * @property string $ip
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Category $category
 * @property \Admin\Model\Entity\Customer $customer
 */
class CategoriesVisitor extends Entity
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
