<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailLog Entity
 *
 * @property int $id
 * @property string $email_queues_id
 * @property int $email_statuses_id
 * @property \Cake\I18n\FrozenTime $sent_date
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\EmailQueue $email_queue
 * @property \Admin\Model\Entity\EmailStatus $email_status
 */
class EmailLog extends Entity
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
