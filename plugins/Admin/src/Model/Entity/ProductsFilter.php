<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductsFilter Entity
 *
 * @property int $id
 * @property int $products_id
 * @property int $filters_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Product $product
 * @property \Admin\Model\Entity\Filter $filter
 */
class ProductsFilter extends Entity
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
