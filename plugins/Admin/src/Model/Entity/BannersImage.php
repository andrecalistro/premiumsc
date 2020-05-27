<?php

namespace Admin\Model\Entity;

use Cake\I18n\Date;
use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * BannersImage Entity
 *
 * @property int $id
 * @property int $banners_id
 * @property string $url
 * @property string $target
 * @property string $background
 * @property string $image
 * @property string $path
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
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Banner $banner
 */
class BannersImage extends Entity
{
    protected $_virtual = [
        'background_link',
        'thumb_background_link',
        'image_link',
        'thumb_image_link',
        'name_target',
        'name_status',
        'name_weekend_days',
        'name_always',
        'name_period',
        'background_mobile_link',
        'thumb_background_mobile_link',
        'image_mobile',
        'thumb_image_mobile_link'
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
     * @return string
     */
    protected function _getNameTarget()
    {
        if (!isset($this->_properties['target'])) {
            return null;
        }
        return $this->_properties['target'] == '_blank' ? 'Página em branco/nova página' : 'Mesma página';
    }

    /**
     * @return string
     */
    protected function _getNameStatus()
    {
        if (!isset($this->_properties['status'])) {
            return null;
        }
        return $this->_properties['status'] == 0 ? 'Não publicado' : 'Publicado';
    }

    /**
     * @return string
     */
    protected function _getNameAlways()
    {
        if (!isset($this->_properties['always'])) {
            return null;
        }
        return $this->_properties['always'] == 0 ? 'Não' : 'Sim';
    }

    /**
     * @return string
     */
    protected function _getNameWeekendDays()
    {
        $days = ['sunday' => 'Domingo', 'monday' => 'Segunda', 'tuesday' => 'Terça', 'wednesday' => 'Quarta', 'thursday' => 'Quinta', 'friday' => 'Sexta', 'saturday' => 'Sábado'];
        $weekend = [];
        foreach ($days as $key => $day) {
            if (!isset($this->_properties[$key])) {
                continue;
            }
            !$this->_properties[$key] ?: $weekend[] = $day;
        }
        return implode(', ', $weekend);
    }

    /**
     * @return string
     */
    protected function _getNamePeriod()
    {
        if (!isset($this->_properties['start_date']) || !isset($this->_properties['end_date'])) {
            return null;
        }
        if ($this->_properties['always']) {
            return '--';
        }
        if (!empty($this->_properties['start_date']) && !empty($this->_properties['end_date'])) {
            return $this->_properties['start_date']->format('d/m/Y') . ' até ' . $this->_properties['end_date']->format('d/m/Y');
        }
        return '--';
    }

    /**
     * @param $start_date
     * @return Date
     */
    protected function _setStartDate($start_date)
    {
        return Date::createFromFormat('d/m/Y', $start_date);
    }

    /**
     * @param $end_date
     * @return Date
     */
    protected function _setEndDate($end_date)
    {
        return Date::createFromFormat('d/m/Y', $end_date);
    }
}
