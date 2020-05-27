<?php

namespace CheckoutV2\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * CustomersAddresses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \CheckoutV2\Model\Entity\CustomersAddress get($primaryKey, $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersAddress newEntity($data = null, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersAddress[] newEntities(array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersAddress|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersAddress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersAddress[] patchEntities($entities, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersAddress findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomersAddressesTable extends AppTable
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

        $this->setTable('customers_addresses');
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
			->notEmpty('address', __("Por favor, preencha o seu endereço."));

        $validator
			->notEmpty('zipcode', __("Por favor, preencha o seu CEP."));

        $validator
			->notEmpty('number', __("Por favor, preencha o seu número."));

        $validator
            ->allowEmpty('complement');

        $validator
			->notEmpty('neighborhood', __("Por favor, preencha o seu bairro."));

        $validator
			->notEmpty('city', __("Por favor, preencha a sua cidade."));

        $validator
			->notEmpty('state', __("Por favor, preencha o seu estado."));

        $validator
            ->allowEmpty('description');

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

    /**
     * @param $customers_id
     * @return array|bool
     */
    public function haveAddress($customers_id)
    {
        $addresses = $this->find()
            ->where(['customers_id' => $customers_id])
            ->toArray();

        if ($addresses)
            return $addresses;
        else
            return false;
    }
}
