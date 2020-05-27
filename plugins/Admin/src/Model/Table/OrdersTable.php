<?php

namespace Admin\Model\Table;

use Admin\Model\Entity\Order;
use Admin\Model\OrderTrait;
use ArrayObject;
use Cake\Controller\Component;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Http\Session;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\BelongsTo $CustomersAddresses
 * @property \Cake\ORM\Association\BelongsTo $OrdersStatuses
 * @property \Cake\ORM\Association\BelongsToMany $Products
 * @property \Cake\ORM\Association\HasMany $OrdersProducts
 * @property \Cake\ORM\Association\HasMany $OrdersHistories
 * @property \Cake\ORM\Association\BelongsTo $PaymentsMethods
 * @property HasMany $BlingOrders
 *
 * @method \Admin\Model\Entity\Order get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Order|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Order findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends AppTable
{
    use OrderTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'className' => 'Admin.Customers'
        ]);
        $this->belongsTo('CustomersAddresses', [
            'foreignKey' => 'customers_addresses_id',
            'className' => 'Admin.CustomersAddresses'
        ]);
        $this->belongsTo('OrdersStatuses', [
            'foreignKey' => 'orders_statuses_id',
            'className' => 'Admin.OrdersStatuses'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'orders_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'orders_products',
            'className' => 'Admin.Products'
        ]);
        $this->hasMany('OrdersProducts', [
            'foreignKey' => 'orders_id',
            'className' => 'Admin.OrdersProducts'
        ]);
        $this->belongsTo('PaymentsMethods', [
            'foreignKey' => 'payment_method',
            'className' => 'Admin.PaymentsMethods',
            'bindingKey' => 'slug'
        ]);
        $this->hasMany('OrdersHistories', [
            'foreignKey' => 'orders_id',
            'className' => 'Admin.OrdersHistories'
        ]);

        $this->hasMany('BlingOrders', [
            'foreignKey' => 'orders_id',
            'className' => 'Integrators.BlingOrders'
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
            ->allowEmpty('zipcode');

        $validator
            ->allowEmpty('address');

        $validator
            ->allowEmpty('number');

        $validator
            ->allowEmpty('complement');

        $validator
            ->allowEmpty('neighborhood');

        $validator
            ->allowEmpty('city');

        $validator
            ->allowEmpty('state');

        $validator
            ->decimal('subtotal')
            ->allowEmpty('subtotal');

        $validator
            ->decimal('shipping_total')
            ->allowEmpty('shipping_total');

        $validator
            ->decimal('total')
            ->allowEmpty('total');

        $validator
            ->allowEmpty('payment_method');

        $validator
            ->allowEmpty('payment_url');

        $validator
            ->allowEmpty('ip');

        $validator
            ->allowEmpty('shipping_code');

        $validator
            ->allowEmpty('shipping_text');

        $validator
            ->integer('shipping_deadline')
            ->allowEmpty('shipping_deadline');

        $validator
            ->allowEmpty('shipping_image');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted')
            ->allowEmpty('tracking')
            ->date('shipping_sent_date')
            ->allowEmpty('shipping_sent_date');

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
        $rules->add($rules->existsIn(['customers_addresses_id'], 'CustomersAddresses'));
//        $rules->add($rules->existsIn(['orders_statuses_id'], 'OrdersStatuses'));

        return $rules;
    }

    /**
     * @param int $status
     * @param int $days
     * @param null $date
     * @return array
     */
    public function OrdersPerDay($status = 2, $days = 6, $date = null)
    {
        $days_translate = [
            'tuesday' => 'Terça-feira',
            'wednesday' => 'Quarta-feira',
            'thursday' => 'Quinta-feira',
            'friday' => 'Sexta-feira',
            'saturday' => 'Sábado',
            'sunday' => 'Domingo',
            'monday' => 'Segunda'
        ];

        if (!$date) {
            $date = new Time('last saturday', 'America/Sao_Paulo');
        }

        $orders = $this->find()
            ->where([
                'Orders.created BETWEEN :start_date AND :end_date',
                'Orders.orders_statuses_id <> ' => 6,
                'Orders.orders_statuses_id >= ' => $status
            ])
            ->bind(':end_date', $date->format('Y-m-d 23:59:59'))
            ->bind(':start_date', $date->subDays($days)->format('Y-m-d 00:00:00'))
            ->select([
                'total_count' => 'count(Orders.id)',
                'Orders.created',
                'day_week' => 'DATE_FORMAT(Orders.created, \'%d\')',
                'Orders.total',
                'Orders.orders_statuses_id'
            ])
            ->group(['DAY(Orders.created)'])->toArray();
        $per_day = [];
        $orders_count_total = 0;
        $orders_total = 0;
        $orders_sends = 0;
        $orders_days_text = [];

        for ($i = 0; $i <= $days; $i++) {
            $order = Hash::extract($orders, '{n}[day_week=' . $date->addDays($i == 0 ? $i : 1)->format('d') . ']');
            $per_day[$date->format("Y-m-d")] = isset($order[0]->total_count) ? $order[0]->total_count : 0;
            $orders_days_text[] = $days_translate[strtolower($date->format('l'))];
            $orders_count_total += isset($order[0]->total_count) ? $order[0]->total_count : 0;
            $orders_total += isset($order[0]->total) ? $order[0]->total : 0;
            $orders_sends += isset($order[0]->orders_statuses_id) && $order[0]->orders_statuses_id >= 4 ? $order[0]->total_count : 0;
        }

        return [
            'orders' => $per_day,
            'end' => $date->format("d/m/Y"),
            'start' => $date->subDays($days)->format('d/m/Y'),
            'count_total' => $orders_count_total,
            'total' => 'R$ ' . number_format($orders_total, 2, ",", "."),
            'orders_sends' => $orders_sends,
            'orders_days_text' => $orders_days_text
        ];
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $changedFields = $entity->extractOriginalChanged($entity->visibleProperties());

        if (isset($changedFields['orders_statuses_id'])) {
            $session = new Session();
            $store = $session->read('Store');

            $this->updateOrderStatuses($entity->id, $entity->orders_statuses_id, $store);
        }

        $Bling = TableRegistry::getTableLocator()->get('Admin.Stores');
        $config = $Bling->findConfig('bling');
        if (isset($config->status) && ($config->status) && ($config->synchronize_orders) && !empty($config->api_key) && $entity->orders_statuses_id == $config->synchronize_orders_statuses_id) {
            $this->BlingOrders->postOrder($entity->id);
        }
    }

    /**
     * @param $orders_id
     * @param $orders_statuses_id
     * @param null $comment
     * @param bool $notify
     * @return bool
     */
    public function addHistory($orders_id, $orders_statuses_id, $comment = null, $notify = false)
    {
        $order = $this->get($orders_id);
        $order = $this->patchEntity($order, ['orders_statuses_id' => $orders_statuses_id]);
        if ($this->save($order)) {
            $history = $this->OrdersHistories->newEntity([
                'orders_id' => $orders_id,
                'orders_statuses_id' => $orders_statuses_id,
                'comment' => $comment,
                'notify_customer' => $notify
            ]);
            if ($this->OrdersHistories->save($history)) {
                return true;
            }
        }
        return false;
    }
}
