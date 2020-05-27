<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * Provider Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $image
 * @property int $status
 * @property string $email
 * @property string $telephone
 * @property string $bank
 * @property string $agency
 * @property string $account
 * @property string $document
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Product[] $products
 */
class Provider extends Entity
{
    public $_virtual = [
        'image_link',
        'thumb_image_link',
        'bling_status'
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
    protected function _getImageLink()
    {
        if (!empty($this->_properties['image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "Providers" . DS . "{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "Providers" . DS . "{$this->_properties['image']}";
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
            $path = WWW_ROOT . "img" . DS . "files" . DS . "Providers" . DS . "thumbnail-{$this->_properties['image']}";
            $url = DS . "img" . DS . "files" . DS . "Providers" . DS . "thumbnail-{$this->_properties['image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
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
     * @return null
     */
    protected function _getBlingStatus()
    {
        if (isset($this->_properties['bling_providers'][0]['status']) && !empty($this->_properties['bling_providers'][0]['status'])) {
            return $this->_properties['bling_providers'][0]['status'];
        }
        return 'Não sincronizado';
    }
}
