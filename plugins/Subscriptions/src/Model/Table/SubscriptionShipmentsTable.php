<?php
namespace Subscriptions\Model\Table;

use Admin\Model\Table\AppTable;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Subscriptions\Model\Entity\Subscription;

/**
 * SubscriptionShipments Model
 *
 * @property \Subscriptions\Model\Table\SubscriptionsTable|\Cake\ORM\Association\BelongsTo $Subscriptions
 * @property \Subscriptions\Model\Table\SubscriptionShippingStatusTable|\Cake\ORM\Association\BelongsTo $SubscriptionShippingStatus
 *
 * @method \Subscriptions\Model\Entity\SubscriptionShipment get($primaryKey, $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionShipment newEntity($data = null, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionShipment[] newEntities(array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionShipment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionShipment|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionShipment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionShipment[] patchEntities($entities, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionShipment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubscriptionShipmentsTable extends AppTable
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

        $this->setTable('subscription_shipments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Subscriptions', [
            'foreignKey' => 'subscriptions_id',
            'joinType' => 'INNER',
            'className' => 'Subscriptions.Subscriptions'
        ]);
        $this->belongsTo('SubscriptionShippingStatus', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER',
            'className' => 'Subscriptions.SubscriptionShippingStatus'
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
            ->scalar('shipping_method')
            ->maxLength('shipping_method', 255)
            ->requirePresence('shipping_method', 'create')
            ->notEmpty('shipping_method');

        $validator
            ->scalar('status_text')
            ->maxLength('status_text', 255)
            ->allowEmpty('status_text');

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
        $rules->add($rules->existsIn(['subscriptions_id'], 'Subscriptions'));
        $rules->add($rules->existsIn(['status_id'], 'SubscriptionShippingStatus'));

        return $rules;
    }

    /**
     * @param Subscription $subscription
     * @return \Subscriptions\Model\Entity\SubscriptionShipment
     */
    public function createNextShipment(Subscription $subscription)
    {
        $shipment = $this->newEntity();
        $shipment->subscriptions_id = $subscription->id;
        $shipment->status_id = 1;
        $shipment->shipping_method = \GuzzleHttp\json_encode($subscription->shipping_method);
        $$his->save($shipment);
        return $shipment;
    }
}
