<?php
namespace Subscriptions\Model\Table;

use Admin\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * PlanDeliveryFrequencies Model
 *
 * @method \Subscriptions\Model\Entity\PlanDeliveryFrequency get($primaryKey, $options = [])
 * @method \Subscriptions\Model\Entity\PlanDeliveryFrequency newEntity($data = null, array $options = [])
 * @method \Subscriptions\Model\Entity\PlanDeliveryFrequency[] newEntities(array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\PlanDeliveryFrequency|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\PlanDeliveryFrequency|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\PlanDeliveryFrequency patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\PlanDeliveryFrequency[] patchEntities($entities, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\PlanDeliveryFrequency findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PlanDeliveryFrequenciesTable extends AppTable
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

        $this->setTable('plan_delivery_frequencies');
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
