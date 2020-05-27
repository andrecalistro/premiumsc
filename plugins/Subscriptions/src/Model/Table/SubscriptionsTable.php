<?php
namespace Subscriptions\Model\Table;

use Admin\Model\Table\AppTable;
use Admin\Model\Table\CustomersTable;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Subscriptions\Model\Entity\Subscription;

/**
 * Subscriptions Model
 *
 * @property CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \Subscriptions\Model\Table\PlansTable|\Cake\ORM\Association\BelongsTo $Plans
 * @property HasMany|SubscriptionBillingsTable $SubscriptionBillings
 * @property HasMany|SubscriptionShipmentsTable $SubscriptionShipments
 *
 * @method \Subscriptions\Model\Entity\Subscription get($primaryKey, $options = [])
 * @method \Subscriptions\Model\Entity\Subscription newEntity($data = null, array $options = [])
 * @method \Subscriptions\Model\Entity\Subscription[] newEntities(array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\Subscription|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\Subscription|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\Subscription patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\Subscription[] patchEntities($entities, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\Subscription findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubscriptionsTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('subscriptions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'joinType' => 'INNER',
            'className' => 'Checkout.Customers'
        ]);
        $this->belongsTo('CustomersAddresses', [
            'foreignKey' => 'customers_addresses_id',
            'joinType' => 'INNER',
            'className' => 'Checkout.CustomersAddresses'
        ]);
        $this->belongsTo('Plans', [
            'foreignKey' => 'plans_id',
            'joinType' => 'INNER',
            'className' => 'Subscriptions.Plans'
        ]);
        $this->hasMany('SubscriptionBillings', [
            'foreignKey' => 'subscriptions_id',
            'className' => 'Subscriptions.SubscriptionBillings'
        ]);
        $this->hasMany('SubscriptionShipments', [
            'foreignKey' => 'subscriptions_id',
            'className' => 'Subscriptions.SubscriptionShipments'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('plans_name')
            ->maxLength('plans_name', 255)
            ->requirePresence('plans_name', 'create')
            ->notEmpty('plans_name');

        $validator
            ->scalar('plans_image')
            ->maxLength('plans_image', 255)
            ->allowEmpty('plans_image');

        $validator
            ->scalar('plans_thumb_image')
            ->maxLength('plans_thumb_image', 255)
            ->allowEmpty('plans_thumb_image');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->integer('frequency_billing_days')
            ->requirePresence('frequency_billing_days', 'create')
            ->notEmpty('frequency_billing_days');

        $validator
            ->allowEmpty('frequency_billing_name')
            ->allowEmpty('frequency_delivery_name')
            ->allowEmpty('payment_component')
            ->allowEmpty('payment_method')
            ->allowEmpty('shipping_method');

        $validator
            ->integer('frequency_delivery_days')
            ->requirePresence('frequency_delivery_days', 'create')
            ->notEmpty('frequency_delivery_days');

        $validator
            ->decimal('price')
            ->allowEmpty('price');

        $validator
            ->decimal('price_shipping')
            ->allowEmpty('price_shipping');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['customers_id'], 'Customers'));
        $rules->add($rules->existsIn(['customers_addresses_id'], 'CustomersAddresses'));
        $rules->add($rules->existsIn(['plans_id'], 'Plans'));

        return $rules;
    }

    /**
     * @param $subscriptionId
     * @param array $conditionSubscriptionBilling
     * @return Subscription
     */
    public function getSubscription($subscriptionId, $conditionSubscriptionBilling = [])
    {
        return $this->get($subscriptionId, [
            'contain' => [
                'Plans' => function(Query $q) {
                    return $q->contain([
                        'PlanBillingFrequencies',
                        'PlanDeliveryFrequencies',
                        'PlansImages'
                    ]);
                },
                'Customers',
                'CustomersAddresses',
                'SubscriptionBillings' => function(Query $q) use ($conditionSubscriptionBilling) {
                    return $q->contain([
                        'SubscriptionBillingStatus',
                    ])
                        ->where($conditionSubscriptionBilling)
                        ->orderAsc('SubscriptionBillings.id');
                },
                'SubscriptionShipments' =>  function(Query $q) {
                    return $q->contain([
                        'SubscriptionShippingStatus',
                    ])
                        ->orderAsc('SubscriptionShipments.id');
                }
            ]
        ]);
    }

    public function setPriceShipment(Subscription $subscription, $addresses_id, array $data)
    {
        $subscription = $this->patchEntity($subscription, [
            'price_shipment' => $data['shipping_total'],
            'customers_addresses_id' => (int)$addresses_id
        ]);

        if($this->save($subscription))
            return true;

        return false;
    }
}
