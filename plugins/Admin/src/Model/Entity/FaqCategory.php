<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;

/**
 * FaqCategory Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $pages
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\FaqQuestion[] $faqQuestions
 */
class FaqCategory extends Entity
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
}
