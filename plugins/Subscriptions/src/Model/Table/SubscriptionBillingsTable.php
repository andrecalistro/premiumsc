<?php
namespace Subscriptions\Model\Table;

use Admin\Model\Table\AppTable;
use Cake\I18n\Date;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Subscriptions\Model\Entity\SubscriptionBilling;

/**
 * SubscriptionBillings Model
 *
 * @property \Subscriptions\Model\Table\SubscriptionsTable|\Cake\ORM\Association\BelongsTo $Subscriptions
 * @property \Subscriptions\Model\Table\SubscriptionBillingStatusTable|\Cake\ORM\Association\BelongsTo $SubscriptionBillingStatus
 *
 * @method \Subscriptions\Model\Entity\SubscriptionBilling get($primaryKey, $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBilling newEntity($data = null, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBilling[] newEntities(array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBilling|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBilling|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBilling patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBilling[] patchEntities($entities, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBilling findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubscriptionBillingsTable extends AppTable
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

        $this->setTable('subscription_billings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Subscriptions', [
            'foreignKey' => 'subscriptions_id',
            'joinType' => 'INNER',
            'className' => 'Subscriptions.Subscriptions'
        ]);
        $this->belongsTo('SubscriptionBillingStatus', [
            'foreignKey' => 'status_id',
            'className' => 'Subscriptions.SubscriptionBillingStatus'
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
            ->scalar('payment_component')
            ->maxLength('payment_component', 255)
            ->requirePresence('payment_component', 'create')
            ->notEmpty('payment_component');

        $validator
            ->scalar('payment_method')
            ->maxLength('payment_method', 255)
            ->requirePresence('payment_method', 'create')
            ->notEmpty('payment_method');

        $validator
            ->scalar('status_text')
            ->maxLength('status_text', 255)
            ->allowEmpty('status_text')
            ->allowEmpty('payment_code')
            ->allowEmpty('date_process');

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
        $rules->add($rules->existsIn(['status_id'], 'SubscriptionBillingStatus'));

        return $rules;
    }

    /**
     * @param SubscriptionBilling $billing
     * @return SubscriptionBilling
     */
    public function createNextPayment(SubscriptionBilling $billing)
    {
        $next = $this->newEntity();
        $next->subscriptions_id = $billing->subscriptions_id;
        $next->payment_method = $billing->subscription->payment_method;
        $next->status_id = 1;
        $next->payment_component = $billing->subscription->payment_component;
        $next->payment_code = null;
        $next->date_process = (new Date())->addDays((int)$billing->subscription->frequency_billing_days);
        $this->save($next);
        return $next;
    }
}
