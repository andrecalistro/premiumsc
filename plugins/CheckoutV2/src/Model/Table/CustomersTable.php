<?php

namespace CheckoutV2\Model\Table;

use ArrayObject;
use Cake\Controller\Component\AuthComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Http\Client;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\Http\Session;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Validation\Validator;
use Integrators\Controller\Component\NerdpressComponent;

/**
 * Customers Model
 *
 * @property \Cake\ORM\Association\HasMany $CustomersConfirmations
 * @property \Cake\ORM\Association\HasMany $CustomersResets
 * @property \Cake\ORM\Association\HasMany $CustomersAddresses
 * @property \Cake\ORM\Association\HasMany $Orders
 * @property HasMany $CustomersTokens
 * @property BelongsTo $CustomersTypes
 *
 * @method \CheckoutV2\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \CheckoutV2\Model\Entity\Customer newEntity($data = null, array $options = [])
 * @method \CheckoutV2\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Customer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CheckoutV2\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Customer[] patchEntities($entities, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Customer findOrCreate($search, callable $callback = null, $options = [])
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
            'className' => 'CheckoutV2.CustomersConfirmations'
        ]);

        $this->hasMany('CustomersResets', [
            'foreignKey' => 'customers_id',
            'className' => 'CheckoutV2.CustomersResets'
        ]);

        $this->hasMany('CustomersAddresses', [
            'foreignKey' => 'customers_id',
            'className' => 'CheckoutV2.CustomersAddresses'
        ]);

        $this->hasMany('Orders', [
            'foreignKey' => 'customers_id',
            'className' => 'CheckoutV2.Orders'
        ]);

        $this->hasMany('CustomersTokens', [
            'foreignKey' => 'customers_id',
            'className' => 'CheckoutV2.CustomersTokens'
        ]);

        $this->belongsTo('CustomersTypes', [
            'foreignKey' => 'customers_types_id',
            'className' => 'Admin.CustomersTypes'
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
            ->notEmpty('birth_date', __("Por favor, preencha sua data de nascimento."))
            ->date(
                'birth_date',
                ['dmy'],
                __('Por favor, insira uma data de nascimento válida.')
            );

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
            ->notEmpty('telephone', __('Por favor, preencha seu telefone.'));

        $validator
            ->allowEmpty('cellphone')
            ->allowEmpty('gender');

        $validator
            ->allowEmpty('company_name')
            ->allowEmpty('trading_name')
            ->allowEmpty('company_state');

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
            ->notEmpty('company_document', __("Por favor, preencha seu CNPJ."))
            ->minLength('company_document', 14, __('CNPJ inválido.'));

        $validator
            ->notEmpty('birth_date', __("Por favor, preencha sua data de nascimento."))
            ->date(
                'birth_date',
                ['dmy'],
                __('Por favor, insira uma data de nascimento válida.')
            )
            ->notEmpty('telephone', __('Por favor, preencha seu telefone.'));

        $validator
            ->notEmpty('company_name', __('Por favor, preencha a Razão social.'))
            ->allowEmpty('trading_name')
            ->notEmpty('company_state', __('Por favor, preencha a Inscrição estadual, mesmo que isento.'));

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
        $rules->add($rules->isUnique(['company_document'], __('Já existe um cadastro com esse CNPJ.')));
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

        if ($entity->company_document) {
            $entity->company_document_clean = preg_replace('/[^0-9]/', '', $entity->company_document);
        }
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $Garrula = TableRegistry::getTableLocator()->get('Admin.Stores');
        $garrula = $Garrula->findConfig('garrula');
        if (isset($garrula->nerdpress_synchronize_customers) && $garrula->nerdpress_synchronize_customers) {
            $customer = [
                'id' => $entity->id,
                'name' => $entity->name,
                'email' => $entity->email,
            ];
            $Nerdpress = new NerdpressComponent(new ComponentRegistry());
            $customer_nerdpress = $Nerdpress->call('customer/view/' . $entity->id);
            if ($customer_nerdpress['success']) {
                $result = $Nerdpress->call('customer/update', 'post', $customer);
            } else {
                $result = $Nerdpress->call('customer/create', 'post', $customer);
            }
        }
        $this->updateAuthAfterEditUser($entity);

        $EmailTemplates = TableRegistry::getTableLocator()->get('Admin.EmailTemplates');
        $EmailQueues = TableRegistry::getTableLocator()->get('Admin.EmailQueues');

        $template = $EmailTemplates->find()
            ->where(['slug' => 'novo-cadastro'])
            ->first();

        if ($template) {
            $store = $Garrula->findConfig('store');
            $html = $EmailTemplates->buildHtml($template, [
                'name' => $entity->name,
                'email' => $entity->email,
                'store_name' => $store->name,
                'store_cellphone' => $store->cellphone,
                'store_telephone' => $store->telephone,
                'store_email' => $store->email_contact,
                'store_account_link' => Router::url('/minha-conta/acesso-cadastro', true)
            ]);
            $email = $EmailQueues->newEntity([
                'from_name' => $template->from_name,
                'from_email' => $template->from_email,
                'subject' => $template->subject,
                'content' => $html,
                'to_name' => $entity->name,
                'to_email' => $entity->email,
                'email_statuses_id' => 1,
                'reply_name' => $template->reply_name,
                'reply_email' => $template->reply_email
            ]);
            $EmailQueues->save($email);
        }
    }

    /**
     * @param $customer
     * @return array|bool|EntityInterface|null|string
     * @throws \Exception
     */
    public function createToken($customer)
    {
        if (is_array($customer)) {
            $customers_id = $customer['id'];
        } else {
            $customers_id = $customer;
        }
        $token = $this->getValidToken($customers_id);
        if (!$token) {
            $token = $this->generateToken($customers_id);
        } else {
            $this->refreshToken($token);
        }
        if (isset($token->token)) {
            return $token->token;
        }
        return $token;
    }

    /**
     * @param $customers_id
     * @return bool|string
     * @throws \Exception
     */
    public function generateToken($customers_id)
    {
        $token = Security::hash(Time::now('America/Sao_Paulo'), 'sha1', true);
        $validate = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
        $customer_token = $this->CustomersTokens->newEntity([
            'customers_id' => $customers_id,
            'token' => $token,
            'validate' => $validate->add(new \DateInterval('P1D'))
        ]);
        if ($this->CustomersTokens->save($customer_token)) {
            return $customer_token;
        }
        return false;
    }

    /**
     * @param $customers_id
     * @return array|EntityInterface|null
     */
    public function getValidToken($customers_id)
    {
        return $this->CustomersTokens->find()
            ->select(['token'])
            ->where([
                'customers_id' => $customers_id,
                'validate >' => new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'))
            ])
            ->first();
    }

    /**
     * @param $token
     * @return bool|\CheckoutV2\Model\Entity\Customer
     */
    public function validateToken($token)
    {
        $validate = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
        $token = $this->CustomersTokens->find()
            ->where([
                'token' => $token,
                'validate >' => $validate
            ])
            ->first();

        if ($token) {
            return $this->get($token->customers_id);
        }
        return false;
    }

    /**
     * @param $token
     * @return array|bool
     * @throws \Exception
     */
    public function refreshToken($token)
    {
        $row = $this->CustomersTokens->find()
            ->where(['token' => $token])
            ->contain(['Customers'])
            ->first();
        if (!$row) {
            return false;
        }
        $validate = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
        $row = $this->CustomersTokens->patchEntity($row, ['validate' => $validate->add(new \DateInterval('P1D'))]);
        $this->CustomersTokens->save($row);
        return [
            'token' => $token,
            'customer' => $row->customer
        ];
    }

    /**
     * @param $customers_id
     * @return int
     */
    public function destroyToken($customers_id)
    {
        return $this->CustomersTokens->deleteAll(['customers_id' => $customers_id]);
    }

    /**
     * @param $data
     */
    public function updateAuthAfterEditUser($data)
    {
        $session = new Session();
        if ($data->id == $session->read('Auth.User.id')) {
            $session->write('Auth.User.name', $data->name);
            $session->write('Auth.User.email', $data->name);
            $session->write('Auth.User.document', $data->document);
            $session->write('Auth.User.document_clean', $data->document_clean);
            $session->write('Auth.User.telephone', $data->telephone);
            $session->write('Auth.User.birth_date', $data->birth_date);
            $session->write('Auth.User.force_update_data', $this->verifyRegister($data));
        }
    }

    /**
     * @param $user
     * @return bool
     */
    public function verifyRegister($user)
    {
        $response = false;
        if (!$user['document']) {
            $response = true;
        }
        if (!$user['telephone']) {
            $response = true;
        }
        if (!$user['birth_date']) {
            $response = true;
        }
        return $response;
    }
}
