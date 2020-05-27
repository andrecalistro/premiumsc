<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * StoresMenusItem Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $menu_type
 * @property string $url
 * @property string $target
 * @property string $icon_class
 * @property string $icon_image
 * @property int $parent_id
 * @property int $status
 * @property int $position
 * @property int $stores_menus_groups_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\ParentStoresMenusItem $parent_stores_menus_item
 * @property \Admin\Model\Entity\StoresMenusGroup $stores_menus_group
 * @property \Admin\Model\Entity\ChildStoresMenusItem[] $child_stores_menus_items
 */
class StoresMenusItem extends Entity
{

	protected $_virtual = [
		'icon_image_link',
		'thumb_icon_image_link'
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


	protected function _getIconImageLink()
	{
		if (!empty($this->_properties['image'])) {
			$path = WWW_ROOT . "img" . DS . "files" . DS . "StoresMenusItems" . DS . "{$this->_properties['icon_image']}";
			$url = DS . "img" . DS . "files" . DS . "StoresMenusItems" . DS . "{$this->_properties['icon_image']}";

			if (is_file($path) && file_exists($path)) {
				return Router::url($url, true);
			}
		}

		return false;
	}

	protected function _getThumbIconImageLink()
	{
		if (!empty($this->_properties['image'])) {
			$path = WWW_ROOT . "img" . DS . "files" . DS . "StoresMenusItems" . DS . "thumbnail-{$this->_properties['icon_image']}";
			$url = DS . "img" . DS . "files" . DS . "StoresMenusItems" . DS . "thumbnail-{$this->_properties['icon_image']}";

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
}
