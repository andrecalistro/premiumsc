<?php
namespace Subscriptions\Model\Table;

use Admin\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * SubscriptionBillingStatus Model
 *
 * @method \Subscriptions\Model\Entity\SubscriptionBillingStatus get($primaryKey, $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBillingStatus newEntity($data = null, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBillingStatus[] newEntities(array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBillingStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBillingStatus|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBillingStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBillingStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\SubscriptionBillingStatus findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubscriptionBillingStatusTable extends AppTable
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

        $this->setTable('subscription_billing_status');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
