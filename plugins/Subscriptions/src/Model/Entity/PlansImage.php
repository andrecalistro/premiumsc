<?php
namespace Subscriptions\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * PlansImage Entity
 *
 * @property int $id
 * @property int|null $plans_id
 * @property string|null $image
 * @property int|null $main
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property \Subscriptions\Model\Entity\Plan $plan
 */
class PlansImage extends Entity
{

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
        'plans_id' => true,
        'image' => true,
        'main' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'plan' => true
    ];

    protected $_virtual = [
        'image_link',
        'thumb_image_link'
    ];

    protected function _getImageLink()
    {
        if (!empty($this->_properties['image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "PlansImages" . DS . "{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "PlansImages" . DS . "{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    protected function _getThumbImageLink()
    {
        if (!empty($this->_properties['image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "PlansImages" . DS . "thumbnail-{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "PlansImages" . DS . "thumbnail-{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }
}
