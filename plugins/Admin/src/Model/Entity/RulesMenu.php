<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * RulesMenu Entity
 *
 * @property int $id
 * @property int $rules_id
 * @property int $menus_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \Admin\Model\Entity\Rule $rule
 * @property \Admin\Model\Entity\Menus $menus
 */
class RulesMenu extends Entity
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
}
