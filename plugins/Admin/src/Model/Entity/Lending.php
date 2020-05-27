<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lending Entity
 *
 * @property int $id
 * @property string $customer_name
 * @property string $customer_email
 * @property string $customer_document
 * @property int $status
 * @property int $send_status
 * @property \Cake\I18n\FrozenDate $send_date
 * @property int $users_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\User $user
 * @property \Admin\Model\Entity\Product[] $products
 */
class Lending extends Entity
{
    public $_virtual = [
        'status_text'
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

    protected function _getStatusText()
    {
        switch ($this->_properties['status']) {
            case 1:
                $status = '<span class="label label-success">Faturado</span>';
                break;
            case 2:
                $status = '<span class="label label-danger">Cancelado</span>';
                break;
            default:
                $status = '<span class="label label-warning">Pendente</span>';
                break;
        }
        return $status;
    }
}
