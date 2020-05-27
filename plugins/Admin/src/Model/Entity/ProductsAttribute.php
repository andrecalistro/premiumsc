<?php

namespace Admin\Model\Entity;

use Cake\Filesystem\File;
use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * ProductsAttribute Entity
 *
 * @property int $id
 * @property int $attributes_id
 * @property int $products_id
 * @property string $value
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Attribute $attribute
 * @property \Admin\Model\Entity\Product $product
 */
class ProductsAttribute extends Entity
{
    public $_virtual = ['value_link'];
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
     * @return string
     */
    public function _getValueLink()
    {
        $file = new File(WWW_ROOT . 'img/files/ProductsAttributes/' . $this->_properties['value']);
        if ($file->exists()) {
            return Router::url('/img/files/ProductsAttributes/' . $this->_properties['value'], true);
        }
        return null;
    }
}
