<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DiscountsGroupsCustomers Model
 *
 * @property \Admin\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \Admin\Model\Table\DiscountsGroupsTable|\Cake\ORM\Association\BelongsTo $DiscountsGroups
 *
 * @method \Admin\Model\Entity\DiscountsGroupsCustomer get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsCustomer newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsCustomer[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsCustomer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsCustomer|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsCustomer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsCustomer[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsCustomer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DiscountsGroupsCustomersTable extends AppTable
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

        $this->setTable('discount_group_customers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Customers'
        ]);
        $this->belongsTo('DiscountsGroups', [
            'foreignKey' => 'discounts_groups_id',
            'joinType' => 'INNER',
            'className' => 'Admin.DiscountsGroups'
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
            ->date('period')
            ->allowEmpty('period');

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
        $rules->add($rules->existsIn(['discounts_groups_id'], 'DiscountsGroups'));

        return $rules;
    }
}
