<?php

namespace Theme\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * Filter Entity
 *
 * @property int $id
 * @property int $filters_groups_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $seo_description
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Theme\Model\Entity\FiltersGroup $filters_group
 * @property \Theme\Model\Entity\Product[] $products
 */
class Filter extends Entity
{
    protected $_virtual = ['link'];
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

    protected function _getLink()
    {
        return Router::url('filtro/' . $this->_properties['slug'] . '/' . $this->_properties['id'], true);
    }
}
