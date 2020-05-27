<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Utility\Hash;
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
 * @property int $show_featured_menu
 * @property \Cake\I18n\Time $release_date
 * @property \Cake\I18n\Time $expiration_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \Admin\Model\Entity\ParentCategory $parent_category
 * @property \Admin\Model\Entity\ChildCategory[] $child_categories
 * @property \Admin\Model\Entity\Product[] $products
 */
class Category extends Entity
{

    protected $_virtual = [
        'image_link',
        'thumb_image_link',
        'list_title',
        'list_categories_child',
        'formatted_deadlines',
        'link',
        'full_link'
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
        return false;
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
        return false;
    }

    /**
     * @param $title
     * @return mixed
     */
    protected function _setTitle($title)
    {
        $this->set('slug', strtolower(Text::slug($title)));
        return $title;
    }

    /**
     * @return null|string
     */
    protected function _getListTitle()
    {
        if (!isset($this->_properties['title'])) {
            return null;
        }
        if (isset($this->_properties['parent_category'])) {
            return $this->_properties['parent_category']->title . ' > ' . $this->_properties['title'];
        }
        return $this->_properties['title'];
    }

    /**
     * @return null
     */
    protected function _getListCategoriesChild()
    {
        if (isset($this->_properties['child_categories']) && !empty($this->_properties['child_categories'])) {
            return Hash::extract($this->_properties['child_categories'], '{n}.id');
        }
        return null;
    }

    public function _getFormattedDeadlines()
    {
        $release_date = $expiration_date = '';

        if (!empty($this->_properties['release_date'])) {
            $release_date = $this->_properties['release_date']->format('d/m/Y H:i');
        }
        if (!empty($this->_properties['expiration_date'])) {
            $expiration_date = $this->_properties['expiration_date']->format('d/m/Y H:i');
        }

        return [
            'release_date' => $release_date,
            'expiration_date' => $expiration_date
        ];
    }

    /**
     * return link without base url to category
     *
     * @return string
     */
    protected function _getLink()
    {
        if (isset($this->_properties['id'])) {
            if (isset($this->_properties['seo_url']) && !empty($this->_properties['seo_url'])) {
                $seo_url = $this->_properties['seo_url'];
            } else {
                $seo_url = Text::slug(strtolower($this->_properties['title']));
            }
            return Router::url("departamento/{$seo_url}/{$this->_properties['id']}");
        }
        return null;
    }

    /**
     * return link with base url to category
     *
     * @return string
     */
    protected function _getFullLink()
    {
        if (isset($this->_properties['id'])) {
            if (isset($this->_properties['seo_url']) && !empty($this->_properties['seo_url'])) {
                $seo_url = $this->_properties['seo_url'];
            } else {
                $seo_url = Text::slug(strtolower($this->_properties['title']));
            }
            return Router::url("departamento/{$seo_url}/{$this->_properties['id']}", true);
        }
        return null;
    }
}
