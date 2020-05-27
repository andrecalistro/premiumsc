<?php
namespace Subscriptions\Model\Entity;

use Cake\ORM\Entity;

/**
 * SubscriptionShipment Entity
 *
 * @property int $id
 * @property int $subscriptions_id
 * @property string $shipping_method
 * @property int $status_id
 * @property string|null $status_text
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property \Subscriptions\Model\Entity\Subscription $subscription
 * @property \Subscriptions\Model\Entity\SubscriptionShippingStatus $subscription_shipping_status
 */
class SubscriptionShipment extends Entity
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
        'shipping_method' => true,
        'status_id' => true,
        'status_text' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'subscription' => true,
        'subscription_shipping_status' => true
    ];
}
