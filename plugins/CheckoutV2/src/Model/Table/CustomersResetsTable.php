<?php

namespace CheckoutV2\Model\Table;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Validation\Validator;

/**
 * CustomersResets Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \CheckoutV2\Model\Entity\CustomersReset get($primaryKey, $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersReset newEntity($data = null, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersReset[] newEntities(array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersReset|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersReset patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersReset[] patchEntities($entities, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\CustomersReset findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomersResetsTable extends AppTable
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

        $this->setTable('customers_resets');
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
     * @param $customer
     * @param $store
     * @return \CheckoutV2\Model\Entity\CustomersReset|bool
     */
    public function sendLostPasswordEmail($customer, $store)
    {
        $token = Security::hash($customer->id . $customer->email . Time::now('America/Sao_Paulo'), 'sha256');

        $mail = new Email();
        $mail->setTransport('nerdweb')
            ->setEmailFormat('html')
            ->setTemplate(Configure::read('Theme') . '.customer-lost-password')
            ->setFrom($store->email_contact, $store->name)
            ->setTo($customer->email, $customer->name)
            ->setSubject(__('Redefinir sua senha'))
            ->setViewVars([
                'name' => $customer->name,
                'token' => Router::url(['controller' => 'customers', 'action' => 'reset-password', $token], true)
            ]);

        if ($mail->send()) {
            $reset = $this->newEntity(['customers_id' => $customer->id, 'token' => $token]);
            return $this->save($reset);
        }

        return false;
    }
}
