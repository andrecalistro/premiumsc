<?php

namespace Admin\Model\Table;

use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * PaymentsTickets Model
 *
 * @property \Admin\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property PaymentsTicketsSendsTable|HasMany $PaymentsSends
 *
 * @method \Admin\Model\Entity\PaymentsTicket get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\PaymentsTicket newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\PaymentsTicket[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\PaymentsTicket|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\PaymentsTicket patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\PaymentsTicket[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\PaymentsTicket findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentsTicketsTable extends AppTable
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

        $this->setTable('payments_tickets');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'orders_id',
            'className' => 'Admin.Orders'
        ]);

        $this->hasMany('PaymentsTicketsReturns', [
            'foreignKey' => 'payments_tickets_returns_id',
            'className' => 'Admin.PaymentsTicketsReturns'
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
            ->allowEmpty('payment_code');

        $validator
            ->integer('ticket_code')
            ->allowEmpty('ticket_code');

        $validator
            ->integer('payments_tickets_returns_id')
            ->allowEmpty('payments_tickets_returns_id');

        $validator
            ->dateTime('due')
            ->allowEmpty('due');

        $validator
            ->dateTime('payment_date')
            ->allowEmpty('payment_date');

        $validator
            ->decimal('amount')
            ->allowEmpty('amount');

        $validator
            ->decimal('amount_price')
            ->allowEmpty('amount_price');

        $validator
            ->allowEmpty('return_file');

        $validator
            ->allowEmpty('ticket_file');

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

        return $rules;
    }

    /**
     * @param $data
     * @return int
     */
    public function saveTicket($data)
    {
        $ticket = $this->find()
            ->where([
                'ticket_code' => $data['ticket_code']
            ])
            ->first();

        if (!$ticket) {
            $ticket = $this->newEntity($data);
        } else {
            $ticket = $this->patchEntity($ticket, $data);
        }

        $this->save($ticket);
        return $ticket->id;
    }
}
