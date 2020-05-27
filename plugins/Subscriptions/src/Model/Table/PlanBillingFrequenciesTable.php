<?php
namespace Subscriptions\Model\Table;

use Admin\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * PlanBillingFrequencies Model
 *
 * @method \Subscriptions\Model\Entity\PlanBillingFrequency get($primaryKey, $options = [])
 * @method \Subscriptions\Model\Entity\PlanBillingFrequency newEntity($data = null, array $options = [])
 * @method \Subscriptions\Model\Entity\PlanBillingFrequency[] newEntities(array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\PlanBillingFrequency|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\PlanBillingFrequency|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\PlanBillingFrequency patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\PlanBillingFrequency[] patchEntities($entities, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\PlanBillingFrequency findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PlanBillingFrequenciesTable extends AppTable
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

        $this->setTable('plan_billing_frequencies');
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
            ->integer('days')
            ->requirePresence('days', 'create')
            ->notEmpty('days');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
