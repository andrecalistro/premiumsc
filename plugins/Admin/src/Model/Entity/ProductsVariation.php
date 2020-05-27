<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * ProductsVariation Entity
 *
 * @property int $id
 * @property int $products_id
 * @property int $variations_id
 * @property int $variations_groups_id
 * @property int $required
 * @property int $stock
 * @property string $sku
 * @property string $image
 * @property string $auxiliary_field
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Product $product
 * @property \Admin\Model\Entity\Variation $variation
 * @property \Admin\Model\Entity\VariationsGroup $variations_group
 */
class ProductsVariation extends Entity
{
    protected $_virtual = [
        'image_link',
        'thumb_image_link',
        'auxiliary_field_link',
        'thumb_auxiliary_field_link'
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

    /**
     * @return null
     */
    protected function _getImageLink()
    {
        if (!empty($this->_properties['image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "ProductsVariations" . DS . "{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "ProductsVariations" . DS . "{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getThumbImageLink()
    {
        if (!empty($this->_properties['image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "ProductsVariations" . DS . "thumbnail-{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "ProductsVariations" . DS . "thumbnail-{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getAuxiliaryFieldLink()
    {
        if(isset($this->_properties['variations_group']->auxiliary_field_type) && !empty($this->_properties['variations_group']->auxiliary_field_type) && !empty($this->_properties['auxiliary_field'])){
            $path = WWW_ROOT . "img" . DS . "files" . DS . "ProductsVariations" . DS . "{$this->_properties['auxiliary_field']}";
            $url = DS . "img" . DS . "files" . DS . "ProductsVariations" . DS . "{$this->_properties['auxiliary_field']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getThumbAuxiliaryFieldLink()
    {
        if(isset($this->_properties['variations_group']->auxiliary_field_type) && !empty($this->_properties['variations_group']->auxiliary_field_type) && !empty($this->_properties['auxiliary_field'])){
            $path = WWW_ROOT . "img" . DS . "files" . DS . "ProductsVariations" . DS . "thumbnail-{$this->_properties['auxiliary_field']}";
            $url = DS . "img" . DS . "files" . DS . "ProductsVariations" . DS . "thumbnail-{$this->_properties['auxiliary_field']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }
}
