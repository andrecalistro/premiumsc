<?php

namespace Admin\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Integrators\Model\Table\BlingCustomersTable;

/**
 * Customers Model
 *
 * @property BlingCustomersTable $BlingCustomers
 * @property BelongsTo $CustomersTypes
 *
 * @method \Admin\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Customer newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Customer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Customer[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Customer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomersTable extends AppTable
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

        $this->setTable('customers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CustomersAddresses', [
            'foreignKey' => 'customers_id',
            'className' => 'Admin.CustomersAddresses'
        ]);

        $this->hasMany('Orders', [
            'foreignKey' => 'customers_id',
            'className' => 'Admin.Orders'
        ]);

        $this->hasMany('BlingCustomers', [
            'foreignKey' => 'customers_id',
            'className' => 'Integrators.BlingCustomers'
        ]);

        $this->belongsTo('CustomersTypes', [
            'foreignKey' => 'customers_types_id',
            'className' => 'Admin.CustomersTypes'
        ]);

        $this->belongsToMany('DiscountsGroups', [
            'foreignKey' => 'customers_id',
            'targetForeignKey' => 'discounts_groups_id',
            'joinTable' => 'discount_group_customers',
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
            ->allowEmpty('name');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->allowEmpty('password');

        $validator
            ->notEmpty('document', __('Por favor, preencha o CPF.'));

        $validator
            ->dateTime('last_visit')
            ->allowEmpty('last_visit');

        $validator
            ->dateTime('last_buy')
            ->allowEmpty('last_buy');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->allowEmpty('telephone');

        $validator
            ->allowEmpty('cellphone')
            ->allowEmpty('birth_date')
            ->allowEmpty('gender')
            ->date(
                'birth_date',
                ['dmy'],
                __('Por favor, insira uma data de nascimento válida')
            );


        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * @param Validator $validator
     * @return Validator
     */
    public function validationCompanyPeople(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('document');

        $validator
            ->notEmpty('company_document', __("Por favor, preencha seu CNPJ."))
            ->minLength('company_document', 14, __('CNPJ inválido.'));

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
        $rules->add($rules->isUnique(['email'], 'Já existe um client cadastrado com esse e-mail'));

        return $rules;
    }

    /**
     * @param int $days
     * @param null $date
     * @return int|null
     */
    public function newCustomers($days = 6, $date = null)
    {
        if (!$date) {
            $date = new Time('last saturday', 'America/Sao_Paulo');
        }

        $customers = $this->find()
            ->where([
                'Customers.created BETWEEN :start_date AND :end_date'
            ])
            ->bind(':end_date', $date->format('Y-m-d 23:59:59'))
            ->bind(':start_date', $date->subDays($days)->format('Y-m-d 00:00:00'))
            ->count();

        return $customers;
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $Bling = TableRegistry::getTableLocator()->get('Admin.Stores');
        $config = $Bling->findConfig('bling');
        if (isset($config->status) && ($config->status) && ($config->synchronize_customers) && !empty($config->api_key)) {
            $this->BlingCustomers->postCustomer($entity->id);
        }
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!$entity->password) {
            unset($entity->password);
        }
    }
}
