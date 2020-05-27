<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailQueue Entity
 *
 * @property int $id
 * @property string $ip
 * @property string $from_name
 * @property string $from_email
 * @property string $reply_name
 * @property string $reply_email
 * @property string $subject
 * @property string $content
 * @property string $to_name
 * @property string $to_email
 * @property int $email_statuses_id
 * @property string $send_status
 * @property int $customers_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\EmailStatus $email_status
 * @property \Admin\Model\Entity\Customer $customer
 */
class EmailQueue extends Entity
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
