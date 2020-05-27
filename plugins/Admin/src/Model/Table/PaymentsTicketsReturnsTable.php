<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PaymentsTicketsReturns Model
 *
 * @method \Admin\Model\Entity\PaymentsTicketsReturn get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\PaymentsTicketsReturn newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\PaymentsTicketsReturn[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\PaymentsTicketsReturn|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\PaymentsTicketsReturn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\PaymentsTicketsReturn[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\PaymentsTicketsReturn findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentsTicketsReturnsTable extends AppTable
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

        $this->setTable('payments_tickets_returns');
        $this->setDisplayField('id');
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
            ->allowEmpty('file_name');

        $validator
            ->integer('quantity_tickets')
            ->allowEmpty('quantity_tickets');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
