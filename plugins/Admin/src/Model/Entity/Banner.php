<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;

/**
 * Banner Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $image_width
 * @property int $image_height
 * @property int $background_width
 * @property int $background_height
 * @property int $image_mobile_width
 * @property int $image_mobile_height
 * @property int $background_mobile_width
 * @property int $background_mobile_height
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 */

class Banner extends Entity
{
    public $_virtual = [
        'dimensions'
    ];
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

    protected function _setName($name)
    {
        $this->set('slug', strtolower(Text::slug($name)));
        return $name;
    }

    protected function _getDimensions()
    {
        $dimensions = [];
        if (isset($this->_properties['image_width']) && isset($this->_properties['image_height'])) {
            $dimensions['image'] = $this->_properties['image_width'] . 'px x ' . $this->_properties['image_height'] . 'px';
        }
        if (isset($this->_properties['background_width']) && isset($this->_properties['background_height'])) {
            $dimensions['background'] = $this->_properties['background_width'] . 'px x ' . $this->_properties['background_height'] . 'px';
        }
        if (isset($this->_properties['image_mobile_width']) && isset($this->_properties['image_mobile_height'])) {
            $dimensions['image_mobile'] = $this->_properties['image_mobile_width'] . 'px x ' . $this->_properties['image_mobile_height'] . 'px';
        }
        if (isset($this->_properties['background_mobile_width']) && isset($this->_properties['background_mobile_height'])) {
            $dimensions['background_mobile'] = $this->_properties['background_mobile_width'] . 'px x ' . $this->_properties['background_mobile_height'] . 'px';
        }
        return $dimensions;
    }
}
