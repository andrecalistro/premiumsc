<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdersHistory Entity
 *
 * @property int $id
 * @property int $orders_id
 * @property int $orders_statuses_id
 * @property bool $notify_customer
 * @property string $comment
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Order $order
 * @property \Admin\Model\Entity\OrdersStatus $orders_status
 */
class OrdersHistory extends Entity
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
