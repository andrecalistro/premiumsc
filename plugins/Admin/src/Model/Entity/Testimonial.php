<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * Testimonial Entity
 *
 * @property int $id
 * @property string $name
 * @property string $company
 * @property string $message
 * @property string $avatar
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 */
class Testimonial extends Entity
{
    protected $_virtual = [
        'avatar_link',
        'thumb_avatar_link'
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
    protected function _getAvatarLink()
    {
        if (!empty($this->_properties['avatar'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "Testimonials" . DS . "{$this->_properties['avatar']}";
            $url = DS . "img" . DS . "files" . DS . "Testimonials" . DS . "{$this->_properties['avatar']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getThumbAvatarLink()
    {
        if (!empty($this->_properties['avatar'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "Testimonials" . DS . "thumbnail-{$this->_properties['avatar']}";
            $url = DS . "img" . DS . "files" . DS . "Testimonials" . DS . "thumbnail-{$this->_properties['avatar']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }
}
