<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailLogs Model
 *
 * @property \Admin\Model\Table\EmailQueuesTable|\Cake\ORM\Association\BelongsTo $EmailQueues
 * @property \Admin\Model\Table\EmailStatusesTable|\Cake\ORM\Association\BelongsTo $EmailStatuses
 *
 * @method \Admin\Model\Entity\EmailLog get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\EmailLog newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\EmailLog[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\EmailLog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\EmailLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\EmailLog[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\EmailLog findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailLogsTable extends AppTable
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

        $this->setTable('email_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('EmailQueues', [
            'foreignKey' => 'email_queues_id',
            'className' => 'Admin.EmailQueues'
        ]);
        $this->belongsTo('EmailStatuses', [
            'foreignKey' => 'email_statuses_id',
            'className' => 'Admin.EmailStatuses'
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
            ->dateTime('sent_date')
            ->allowEmpty('sent_date');

        $validator
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['email_queues_id'], 'EmailQueues'));
        $rules->add($rules->existsIn(['email_statuses_id'], 'EmailStatuses'));

        return $rules;
    }
}
