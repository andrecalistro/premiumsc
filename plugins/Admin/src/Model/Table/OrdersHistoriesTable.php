<?php

namespace Admin\Model\Table;

use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Validation\Validator;

/**
 * OrdersHistories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Orders
 * @property \Cake\ORM\Association\BelongsTo $OrdersStatuses
 *
 * @method \Admin\Model\Entity\OrdersHistory get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\OrdersHistory newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\OrdersHistory[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersHistory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\OrdersHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersHistory[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersHistory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersHistoriesTable extends AppTable
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

        $this->setTable('orders_histories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'orders_id',
            'className' => 'Admin.Orders'
        ]);
        $this->belongsTo('OrdersStatuses', [
            'foreignKey' => 'orders_statuses_id',
            'className' => 'Admin.OrdersStatuses'
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
            ->boolean('notify_customer')
            ->allowEmpty('notify_customer');

        $validator
            ->allowEmpty('comment');

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
        $rules->add($rules->existsIn(['orders_id'], 'Orders'));
        $rules->add($rules->existsIn(['orders_statuses_id'], 'OrdersStatuses'));

        return $rules;
    }

    /**
     * @param $event
     * @param $entity
     * @param $options
     */
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->notify_customer) {
            $Orders = TableRegistry::getTableLocator()->get('Admin.Orders');
            $order = $Orders->get($entity->orders_id, ['contain' => ['Customers']]);

            $EmailTemplates = TableRegistry::getTableLocator()->get('Admin.EmailTemplates');
            $EmailQueues = TableRegistry::getTableLocator()->get('Admin.EmailQueues');

            $template = $EmailTemplates->find()
                ->where(['slug' => 'alteracao-de-status'])
                ->first();

            $html = $EmailTemplates->buildHtml($template, [
                'orders_id' => $order->id,
                'status' => $this->OrdersStatuses->get($order->orders_statuses_id)->name,
                'order_url' => Router::url('/meu-pedido/' . $order->id, true)
            ]);

            $email = $EmailQueues->newEntity([
                'from_name' => $template->from_name,
                'from_email' => $template->from_email,
                'subject' => $template->subject,
                'content' => $html,
                'to_name' => $order->customer->name,
                'to_email' => $order->customer->email,
                'email_statuses_id' => 1,
                'reply_name' => $template->reply_name,
                'reply_email' => $template->reply_email
            ]);

            $EmailQueues->save($email);
        }
    }
}
