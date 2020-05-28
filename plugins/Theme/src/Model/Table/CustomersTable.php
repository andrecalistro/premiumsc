<?php

namespace Theme\Model\Table;

use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Network\Session;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @property \Cake\ORM\Association\HasMany $CustomersConfirmations
 * @property \Cake\ORM\Association\HasMany $CustomersResets
 * @property \Cake\ORM\Association\HasMany $CustomersAddresses
 * @property \Cake\ORM\Association\HasMany $Orders
 *
 * @method \Theme\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\Customer newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\Customer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\Customer[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\Customer findOrCreate($search, callable $callback = null, $options = [])
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

        $this->hasMany('CustomersConfirmations', [
            'foreignKey' => 'customers_id',
            'className' => Configure::read('Theme') . '.CustomersConfirmations'
        ]);

        $this->hasMany('CustomersResets', [
            'foreignKey' => 'customers_id',
            'className' => Configure::read('Theme') . '.CustomersResets'
        ]);

        $this->hasMany('CustomersAddresses', [
            'foreignKey' => 'customers_id',
            'className' => Configure::read('Theme') . '.CustomersAddresses'
        ]);

        $this->hasMany('Orders', [
            'foreignKey' => 'customers_id',
            'className' => Configure::read('Theme') . '.Orders'
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
            ->notEmpty('name', __('Por favor, preencha seu nome.'))
			->add('name', 'is_complete_name', [
				'rule' => function ($value, $context) {
					if (strpos(trim($value), ' ') === false) {
						return false;
					}
					return true;
				},
				'message' => 'Preencha seu nome completo.'
			]);

        $validator
            ->email('email', false, __('Por favor, insira um e-mail válido.'))
            ->notEmpty('email', __('Por favor, preencha seu e-mail.'));

        $validator
            ->notEmpty('password', 'Por favor, preencha sua senha.')
            ->minLength('password', 6, __("Sua senha deve conter no mínimo 6 caracteres."))
            ->sameAs('password', 'password_confirm', __('As senhas não são iguais.'));

        $validator
            ->notEmpty('document', __("Por favor, preencha seu cpf."))
            ->minLength('document', 11, __('CPF inválido.'));

        $validator
			->notEmpty('birth_date', __("Por favor, preencha sua data de nascimento."));

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
            ->allowEmpty('gender');

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
        $rules->add($rules->isUnique(['email'], __('Já existe um cadastro com esse e-mail.')));
        $rules->add($rules->isUnique(['document'], __('Já existe um cadastro com esse CPF.')));
        return $rules;
    }

    /**
     * @param $event
     * @param $entity
     * @param $options
     */
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->document) {
            $entity->document_clean = preg_replace('/[^0-9]/', '', $entity->document);
        }
    }
}
