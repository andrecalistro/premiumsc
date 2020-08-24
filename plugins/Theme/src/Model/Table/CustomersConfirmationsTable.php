<?php

namespace Theme\Model\Table;

use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\ORM\RulesChecker;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Validation\Validator;

/**
 * CustomersConfirmations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \Theme\Model\Entity\CustomersConfirmation get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\CustomersConfirmation newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\CustomersConfirmation[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\CustomersConfirmation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\CustomersConfirmation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\CustomersConfirmation[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\CustomersConfirmation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomersConfirmationsTable extends AppTable
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

        $this->setTable('customers_confirmations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'className' => Configure::read('Theme') . '.Customers'
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
     * @return \App\Model\Entity\CustomersConfirmation|bool
     */
    public function sendConfirmationEmail($customer, $store)
    {
        $token = Security::hash($customer->id . $customer->email, 'sha256');

        $mail = new Email();
        $mail->setTransport('premiumsc')
            ->setEmailFormat('html')
            ->setTemplate(Configure::read('Theme') . '.customer-confirmation')
            ->setFrom($store->email_contact, $store->name)
            ->setTo($customer->email, $customer->name)
            ->setSubject(__('Confirme seu cadastro'))
            ->setViewVars([
                'name' => $customer->name,
                'token' => Router::url(['controller' => 'customers', 'action' => 'confirm', $token], true)
            ]);

        if ($mail->send()) {
            $confirmation = $this->newEntity(['customers_id' => $customer->id, 'token' => $token]);
            return $this->save($confirmation);
        }

        return false;
    }
}
