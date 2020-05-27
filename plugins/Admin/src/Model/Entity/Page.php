<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * Page Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property string|resource $content
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 */
class Page extends Entity
{
    protected $_virtual = [
    	'status_name',
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
     * @return null|string
     */
    protected function _getStatusName()
    {
        if(empty($this->_properties)){
            return null;
        }
        if ($this->_properties['status']) {
            return __('Publicada');
        }
        return __('Não publicada');
    }

	/**
	 * return link with base url
	 *
	 * @return string
	 */
	protected function _getFullLink()
	{
        if(empty($this->_properties)){
            return null;
        }
		if (isset($this->_properties['seo_url']) && !empty($this->_properties['seo_url'])) {
			$seo_url = $this->_properties['seo_url'];
		} else {
			$seo_url = $this->_properties['slug'];
		}
		return Router::url("pagina/{$seo_url}", true);
	}
}
