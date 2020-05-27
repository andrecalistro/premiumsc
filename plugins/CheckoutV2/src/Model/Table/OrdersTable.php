<?php

namespace CheckoutV2\Model\Table;

use Admin\Model\OrderTrait;
use ArrayObject;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\Http\Session;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Validation\Validator;
use Checkout\Model\Entity\Order;
use Firebase\JWT\JWT;

/**
 * Orders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\BelongsTo $CustomersAddresses
 * @property \Cake\ORM\Association\BelongsTo $OrdersStatuses
 * @property \Cake\ORM\Association\BelongsToMany $Products
 * @property \Cake\ORM\Association\HasMany $OrdersHistories
 * @property BelongsTo $Coupons
 *
 * @method \CheckoutV2\Model\Entity\Order get($primaryKey, $options = [])
 * @method \CheckoutV2\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \CheckoutV2\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Order|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CheckoutV2\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Order findOrCreate($search, callable $callback = null, $options = [])
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
            'className' => 'CheckoutV2.Customers'
        ]);
        $this->belongsTo('CustomersAddresses', [
            'foreignKey' => 'customers_addresses_id',
            'className' => 'CheckoutV2.CustomersAddresses'
        ]);
        $this->belongsTo('OrdersStatuses', [
            'foreignKey' => 'orders_statuses_id',
            'className' => 'CheckoutV2.OrdersStatuses'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'orders_id',
            'targetForeignKey' => 'products_id',
            'joinTable' => 'orders_products',
            'className' => Configure::read('Theme') . '.Products'
        ]);
        $this->hasMany('OrdersProducts', [
            'foreignKey' => 'orders_id',
            'className' => 'CheckoutV2.OrdersProducts'
        ]);
        $this->hasMany('OrdersHistories', [
            'foreignKey' => 'orders_id',
            'className' => 'CheckoutV2.OrdersHistories'
        ]);
        $this->hasMany('OrdersProductsVariations', [
            'foreignKey' => 'orders_id',
            'className' => 'CheckoutV2.OrdersProductsVariations',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsTo('Coupons', [
            'foreignKey' => 'coupons_id',
            'classname' => 'CheckoutV2.Coupons'
        ]);
        $this->belongsTo('PaymentsMethods', [
            'foreignKey' => 'payment_method',
            'className' => 'Admin.PaymentsMethods',
            'bindingKey' => 'slug'
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
            ->allowEmpty('ip')
            ->allowEmpty('shipping_code')
            ->allowEmpty('shipping_text')
            ->allowEmpty('shipping_deadline')
            ->allowEmpty('shipping_image')
            ->allowEmpty('payment_id')
            ->allowEmpty('payment_url');

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
        $rules->add($rules->existsIn(['customers_addresses_id'], 'CustomersAddresses'));
        //$rules->add($rules->existsIn(['orders_statuses_id'], 'OrdersStatuses'));

        return $rules;
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
     * @param $period
     * @param $actual_statuses_id
     * @param $next_status_id
     * @return array
     */
    public function verifyStatus($period, $actual_statuses_id, $next_status_id)
    {
        $period_date = Date::now()->subDays($period);

        $orders = $this->find()
            ->where(['DATE(modified) <=' => $period_date->format("Y-m-d"), 'orders_statuses_id' => $actual_statuses_id])
            ->contain(['Products'])
            ->toArray();

        foreach ($orders as $order) {
            $order->orders_statuses_id = $next_status_id;
            if ($this->save($order)) {
                $history = $this->OrdersHistories->newEntity([
                    'orders_id' => $order->id,
                    'orders_statuses_id' => $next_status_id,
                    'comment' => 'O status do seu pedido foi alterado',
                    'notify_customer' => 1
                ]);
                $this->OrdersHistories->save($history);
            }
        }
        return $orders;
    }

    /**
     * @param Order $order
     * @return string
     * @throws \Exception
     */
    public function generateLink(Order $order)
    {
        $token = $this->getToken($order->id);

        return Router::url([
            'controller' => 'customers',
            'action' => 'validate-link-rating',
            $token,
            'plugin' => 'CheckoutV2'
        ], true);
    }

    /**
     * @param $orders_id
     * @return string
     * @throws \Exception
     */
    private function getToken($orders_id)
    {
        return JWT::encode([
            'orders_id' => $orders_id,
            'exp' => (new \DateTime())->add(new \DateInterval('P30D'))->getTimestamp()
        ], Security::getSalt());
    }
}
