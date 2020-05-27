<?php
namespace Subscriptions\Model\Entity;

use Cake\ORM\Entity;

/**
 * SubscriptionBilling Entity
 *
 * @property int $id
 * @property int $subscriptions_id
 * @property string $payment_method
 * @property int|null $status_id
 * @property string|null $status_text
 * @property string|null $payment_code
 * @property string|null $payment_component
 * @property \Cake\I18n\Date|null $date_process
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property \Subscriptions\Model\Entity\Subscription $subscription
 * @property \Subscriptions\Model\Entity\SubscriptionBillingStatus $subscription_billing_status
 */
class SubscriptionBilling extends Entity
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
        'subscriptions_id' => true,
        'payment_method' => true,
        'status_id' => true,
        'status_text' => true,
        'payment_component' => true,
        'payment_code' => true,
        'date_process' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'subscription' => true,
        'subscription_billing_status' => true
    ];
}
