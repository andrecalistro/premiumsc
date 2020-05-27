<?php
namespace Integrators\Model\Entity;

use Cake\ORM\Entity;

/**
 * BlingProvider Entity
 *
 * @property int $id
 * @property int $providers_id
 * @property string $status
 * @property int $bling_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Integrators\Model\Entity\Provider $provider
 * @property \Integrators\Model\Entity\Bling $bling
 */
class BlingProvider extends Entity
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
