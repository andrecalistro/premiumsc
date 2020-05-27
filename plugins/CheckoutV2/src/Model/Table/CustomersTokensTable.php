<?php
namespace CheckoutV2\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomersTokens Model
 *
 * @property \CheckoutV2\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \CheckoutV2\Model\Entity\CustomersToken get($primaryKey, $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersToken newEntity($data = null, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersToken[] newEntities(array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersToken|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersToken patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersToken[] patchEntities($entities, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersToken findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomersTokensTable extends AppTable
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

        $this->setTable('customers_tokens');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'className' => 'CheckoutV2.Customers'
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
            ->allowEmpty('token');

        $validator
            ->dateTime('validate')
            ->allowEmpty('validate');

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

        return $rules;
    }
}
