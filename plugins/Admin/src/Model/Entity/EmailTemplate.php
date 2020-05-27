<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * EmailTemplate Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $subject
 * @property string $from_name
 * @property string $from_email
 * @property string $reply_name
 * @property string $reply_email
 * @property string $header
 * @property string $footer
 * @property string $tags
 * @property string $content
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 */
class EmailTemplate extends Entity
{
    protected $_virtual = [
        'header_link',
        'header_thumb_link',
        'footer_link',
        'footer_thumb_link',
        'who_receives_name'
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
     * @return bool|string
     */
    protected function _getHeaderLink()
    {
        if (!empty($this->_properties['header'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "EmailTemplates" . DS . "{$this->_properties['header']}";
            $url = DS . "img" . DS . "files" . DS . "EmailTemplates" . DS . "{$this->_properties['header']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    protected function _getHeaderThumbLink()
    {
        if (!empty($this->_properties['header'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "EmailTemplates" . DS . "thumbnail-{$this->_properties['header']}";
            $url = DS . "img" . DS . "files" . DS . "EmailTemplates" . DS . "thumbnail-{$this->_properties['header']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    protected function _getFooterLink()
    {
        if (!empty($this->_properties['footer'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "EmailTemplates" . DS . "{$this->_properties['footer']}";
            $url = DS . "img" . DS . "files" . DS . "EmailTemplates" . DS . "{$this->_properties['footer']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    protected function _getFooterThumbLink()
    {
        if (!empty($this->_properties['footer'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "EmailTemplates" . DS . "thumbnail-{$this->_properties['footer']}";
            $url = DS . "img" . DS . "files" . DS . "EmailTemplates" . DS . "thumbnail-{$this->_properties['footer']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return false;
    }

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
     * @return string
     */
    protected function _getWhoReceivesName()
    {
        return $this->_properties['who_receives'] == 'customer' ? 'Cliente' : 'Loja';
    }
}
