<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;

/**
 * ProductsStatus Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $purchase
 * @property int $view
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 */
class ProductsStatus extends Entity
{
    public $_virtual = [
        'purchase_name',
        'view_name'
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
     * @param $title
     * @return mixed
     */
    protected function _setTitle($title)
    {
        $this->set('slug', strtolower(Text::slug($title)));
        return $title;
    }

    /**
     * @return string
     */
    protected function _getPurchaseName()
    {
        $this->_properties['purchase'] == 1 ? $name = 'Sim' : $name = 'Não';
        return $name;
    }

    /**
     * @return string
     */
    protected function _getViewName()
    {
        $this->_properties['view'] == 1 ? $name = 'Sim' : $name = 'Não';
        return $name;
    }
}
