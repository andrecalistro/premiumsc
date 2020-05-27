<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;

/**
 * Attribute Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Product[] $products
 */
class Attribute extends Entity
{
    public $_virtual = ['type_format'];
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
     * @return null
     */
    protected function _getTypeFormat()
    {
        if (isset($this->_properties['type']) && !empty($this->_properties['type'])) {
            $types = ['file' => 'Arquivo', 'image' => 'Imagem', 'text' => 'Texto'];
            return $types[$this->_properties['type']];
        }
        return null;
    }
}
