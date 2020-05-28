<?php
namespace Theme\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * BannersImage Entity
 *
 * @property int $id
 * @property int $banners_id
 * @property string $background
 * @property string $image
 * @property string $image_mobile
 * @property string $path
 * @property string $title
 * @property int $status
 * @property \Cake\I18n\FrozenDate $validate
 * @property int $always
 * @property int $sunday
 * @property int $monday
 * @property int $tuesday
 * @property int $wednesday
 * @property int $thursday
 * @property int $friday
 * @property int $saturday
 * @property string $url
 * @property string $target
 * @property string $image_link
 * @property string $image_mobile_link
 * @property array $dimensions_image
 * @property array $dimensions_image_mobile
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Theme\Model\Entity\Banner $banner
 */
class BannersImage extends Entity
{
    protected $_virtual = [
        'background_link',
        'thumb_background_link',
        'image_link',
        'thumb_image_link',
        'background_mobile_link',
        'thumb_background_mobile_link',
        'image_mobile',
        'thumb_image_mobile_link',
        'image_mobile_link',
        'dimensions_image',
        'dimensions_image_mobile'
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
     * @return null|string
     */
    protected function _getBackgroundLink()
    {
        if (!empty($this->_properties['background'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['background']}";
            $url = DS . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['background']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getThumbBackgroundLink()
    {
        if (!empty($this->_properties['background'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "BannersImages" . DS . "thumbnail-{$this->_properties['background']}";
            $url = DS . "img" . DS . "files" . DS . "BannersImages" . DS . "thumbnail-{$this->_properties['background']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getBackgroundMobileLink()
    {
        if (!empty($this->_properties['background_mobile'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['background_mobile']}";
            $url = DS . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['background_mobile']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getThumbBackgroundMobileLink()
    {
        if (!empty($this->_properties['background_mobile'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "BannersImages" . DS . "thumbnail-{$this->_properties['background_mobile']}";
            $url = DS . "img" . DS . "files" . DS . "BannersImages" . DS . "thumbnail-{$this->_properties['background_mobile']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getImageLink()
    {
        if (!empty($this->_properties['image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['image']}";
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
            $path = WWW_ROOT . "img" . DS . "files" . DS . "BannersImages" . DS . "thumbnail-{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "BannersImages" . DS . "thumbnail-{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getImageMobileLink()
    {
        if (!empty($this->_properties['image_mobile'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['image_mobile']}";
            $url = DS . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['image_mobile']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getThumbImageMobileLink()
    {
        if (!empty($this->_properties['image_mobile'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "BannersImages" . DS . "thumbnail-{$this->_properties['image_mobile']}";
            $url = DS . "img" . DS . "files" . DS . "BannersImages" . DS . "thumbnail-{$this->_properties['image_mobile']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return array|bool|null
     */
    protected function _getDimensionsImage()
    {
        if (!empty($this->_properties['image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return getimagesize($path);
            }
        }
        return null;
    }

    /**
     * @return array|bool|null
     */
    protected function _getDimensionsImageMobile()
    {
        if (!empty($this->_properties['image_mobile'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['image_mobile']}";
            $url = DS . "img" . DS . "files" . DS . "BannersImages" . DS . "{$this->_properties['image_mobile']}";
            if (is_file($path) && file_exists($path)) {
                return getimagesize($path);
            }
        }
        return null;
    }
}
