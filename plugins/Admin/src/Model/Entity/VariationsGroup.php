<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;

/**
 * VariationsGroup Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $auxiliary_field_type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 */
class VariationsGroup extends Entity
{
    public $_virtual = ['auxiliary_field_type_formatted'];
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
     * @return mixed|null
     */
    protected function _getAuxiliaryFieldTypeFormatted()
    {
        if (isset($this->_properties['auxiliary_field_type']) && !empty($this->_properties['auxiliary_field_type'])) {
            $types = ['text' => 'Texto', 'image' => 'Upload de imagem'];
            return $types[$this->_properties['auxiliary_field_type']];
        }
        return null;
    }
}