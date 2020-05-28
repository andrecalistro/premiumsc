<?php

namespace Theme\Model\Table;

use Admin\Model\OrderTrait;
use ArrayObject;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Network\Session;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\BelongsTo $CustomersAddresses
 * @property \Cake\ORM\Association\BelongsTo $OrdersStatuses
 * @property \Cake\ORM\Association\BelongsToMany $Products
 * @property \Cake\ORM\Association\HasMany $OrdersHistories
 * @property HasMany $OrdersProductsVariations
 *
 * @method \Theme\Model\Entity\Order get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\Order|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\Order findOrCreate($search, callable $callback = null, $options = [])
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
            'className' => Configure::read('Theme') . '.Customers'
        ]);
        $this->belongsTo('CustomersAddresses', [
            'foreignKey' => 'customers_addresses_id',
            'className' => Configure::read('Theme') . '.CustomersAddresses'
        ]);
        $this->belongsTo('OrdersStatuses', [
            'foreignKey' => 'orders_statuses_id',
            'className' => Configure::read('Theme') . '.OrdersStatuses'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'orders_id',
            'targetForeignKey' => 'products_id',
            'joinTable' => 'orders_products',
            'className' => Configure::read('Theme') . '.Products'
        ]);
        $this->hasMany('OrdersProducts', [
            'foreignKey' => 'orders_id',
            'className' => Configure::read('Theme') . '.OrdersProducts'
        ]);
        $this->hasMany('OrdersHistories', [
            'foreignKey' => 'orders_id',
            'className' => Configure::read('Theme') . '.OrdersHistories'
        ]);
        $this->hasMany('OrdersProductsVariations', [
            'foreignKey' => 'orders_id',
            'className' => Configure::read('Theme') . '.OrdersProductsVariations',
            'dependent' => true,
            'cascadeCallbacks' => true
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

        $Bling = TableRegistry::get('Admin.Stores');
        $config = $Bling->findConfig('bling');
        if (($config->status) && ($config->synchronize_orders) && !empty($config->api_key) && $entity->orders_statuses_id == $config->synchronize_orders_statuses_id) {
            $this->BlingOrders->postOrder($entity->id);
        }
    }
}
