<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductsPosition Entity
 *
 * @property int $id
 * @property int $products_id
 * @property int $positions_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Product $product
 * @property \Admin\Model\Entity\Position $position
 */
class ProductsPosition extends Entity
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
