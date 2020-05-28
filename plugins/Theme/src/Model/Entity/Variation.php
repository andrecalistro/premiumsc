<?php
namespace Theme\Model\Entity;

use Cake\ORM\Entity;

/**
 * Variation Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $variations_groups_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Theme\Model\Entity\VariationsGroup $variations_group
 * @property \Theme\Model\Entity\Product[] $products
 */
class Variation extends Entity
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
