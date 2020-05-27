<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailQueues Model
 *
 * @property \Admin\Model\Table\EmailStatusesTable|\Cake\ORM\Association\BelongsTo $EmailStatuses
 * @property \Admin\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \Admin\Model\Entity\EmailQueue get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\EmailQueue newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\EmailQueue[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\EmailQueue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\EmailQueue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\EmailQueue[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\EmailQueue findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailQueuesTable extends AppTable
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

        $this->setTable('email_queues');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('EmailStatuses', [
            'foreignKey' => 'email_statuses_id',
            'className' => 'Admin.EmailStatuses'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'className' => 'Admin.Customers'
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
            ->allowEmpty('ip');

        $validator
            ->allowEmpty('from_name');

        $validator
            ->allowEmpty('from_email');

		$validator
			->allowEmpty('reply_name');

		$validator
			->allowEmpty('reply_email');

        $validator
            ->allowEmpty('subject');

        $validator
            ->allowEmpty('content');

        $validator
            ->allowEmpty('to_name');

        $validator
            ->allowEmpty('to_email');

        $validator
            ->allowEmpty('send_status');

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
        $rules->add($rules->existsIn(['email_statuses_id'], 'EmailStatuses'));
        $rules->add($rules->existsIn(['customers_id'], 'Customers'));

        return $rules;
    }
}
