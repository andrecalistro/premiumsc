<?php

namespace Theme\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * ProductsImage Entity
 *
 * @property int $id
 * @property int $products_id
 * @property string $image
 * @property int $main
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \Theme\Model\Entity\Product $product
 */
class ProductsImage extends Entity
{
    protected $_virtual = [
        'image_link',
        'thumb_image_link'
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

    protected function _getImageLink()
    {
        if (!empty($this->_properties['image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "ProductsImages" . DS . "{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "ProductsImages" . DS . "{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return Router::url(DS . "img" . DS . "no-image.png", true);
    }

    protected function _getThumbImageLink()
    {
        if (!empty($this->_properties['image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "ProductsImages" . DS . "thumbnail-{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "ProductsImages" . DS . "thumbnail-{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return Router::url(DS . "img" . DS . "thumb-no-image.png", true);
    }
}
