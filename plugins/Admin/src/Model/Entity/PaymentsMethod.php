<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * PaymentsMethod Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $image
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 */
class PaymentsMethod extends Entity
{
    protected $_virtual = [
        'image_link'
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
        $path = WWW_ROOT . "img" . DS . "payments" . DS . "icon-{$this->_properties['slug']}.svg";
        $url = DS . "img" . DS . "payments" . DS . "icon-{$this->_properties['slug']}.svg";
        if (is_file($path) && file_exists($path)) {
            return Router::url($url, true);
        }
        return null;
    }
}
