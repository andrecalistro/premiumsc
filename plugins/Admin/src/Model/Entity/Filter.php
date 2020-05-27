<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;

/**
 * Filter Entity
 *
 * @property int $id
 * @property int $filters_groups_id
 * @property string $name
 * @property string $description
 * @property string $seo_description
 * @property string $slug
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\FiltersGroup $filters_group
 */
class Filter extends Entity
{
    protected $_virtual = ['list_name'];
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

    /**
     * @param $name
     * @return mixed
     */
    protected function _setName($name)
    {
        $this->set('slug', strtolower(Text::slug($name)));
        return $name;
    }

    /**
     * @return null|string
     */
    protected function _getListName()
    {
        if (isset($this->_properties['filters_group'])) {
            return $this->_properties['filters_group']->name . ' > ' . $this->_properties['name'];
        }
        return null;
    }
}
