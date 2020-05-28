<?php

namespace Theme\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property string $description
 * @property string $seo_description
 * @property string $seo_title
 * @property string $seo_url
 * @property string $image
 * @property int $parent_id
 * @property int $products_id
 * @property int $products_total
 * @property string $slug
 * @property string $abbreviation
 * @property int $order_show
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \Theme\Model\Entity\ParentCategory $parent_category
 * @property \Theme\Model\Entity\ChildCategory[] $child_categories
 * @property \Theme\Model\Entity\Product[] $products
 */
class Category extends Entity
{

    protected $_virtual = [
        'image_link',
        'thumb_image_link',
        'full_link',
        'link'
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
            $path = WWW_ROOT . "img" . DS . "files" . DS . "Categories" . DS . "{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "Categories" . DS . "{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return Router::url(DS . "img" . DS . "no-image.png", true);
    }

    protected function _getThumbImageLink()
    {
        if (!empty($this->_properties['image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "Categories" . DS . "thumbnail-{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "Categories" . DS . "thumbnail-{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return Router::url(DS . "img" . DS . "thumb-no-image.png", true);
    }

    /**
     * return link with base url to category
     *
     * @return string
     */
    protected function _getFullLink()
    {
        if (isset($this->_properties['seo_url']) && !empty($this->_properties['seo_url'])) {
            $seo_url = $this->_properties['seo_url'];
        } else {
            if (!isset($this->_properties['title'])) {
                return null;
            }
            $seo_url = Text::slug(strtolower($this->_properties['title']));
        }
        return Router::url("departamento/{$seo_url}/{$this->_properties['id']}", true);
    }

    /**
     * return link without base url to category
     *
     * @return string
     */
    protected function _getLink()
    {
        if (isset($this->_properties['seo_url']) && !empty($this->_properties['seo_url'])) {
            $seo_url = $this->_properties['seo_url'];
        } else {
            if (!isset($this->_properties['title'])) {
                return null;
            }
            $seo_url = Text::slug(strtolower($this->_properties['title']));
        }
        return Router::url("departamento/{$seo_url}/{$this->_properties['id']}");
    }
}
