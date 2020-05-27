<?php
namespace Admin\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * WishListProducts Model
 *
 * @property \Admin\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \Admin\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \Admin\Model\Table\WishListsTable|\Cake\ORM\Association\BelongsTo $WishLists
 * @property \Admin\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \Admin\Model\Table\WishListProductStatusesTable|\Cake\ORM\Association\BelongsTo $WishListProductStatuses
 *
 * @method \Admin\Model\Entity\WishListProduct get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\WishListProduct newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\WishListProduct[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\WishListProduct|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\WishListProduct|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\WishListProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\WishListProduct[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\WishListProduct findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WishListProductsTable extends AppTable
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

        $this->setTable('wish_list_products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'className' => 'Admin.Customers'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'joinType' => 'INNER',
            'className' => 'Theme.Products'
        ]);
        $this->belongsTo('WishLists', [
            'foreignKey' => 'wish_lists_id',
            'joinType' => 'INNER',
            'className' => 'Admin.WishLists'
        ]);
        $this->belongsTo('Orders', [
            'foreignKey' => 'orders_id',
            'className' => 'Admin.Orders'
        ]);
        $this->belongsTo('WishListProductStatuses', [
            'foreignKey' => 'wish_list_product_statuses_id',
            'className' => 'Admin.WishListProductStatuses'
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
        $rules->add($rules->existsIn(['products_id'], 'Products'));
        $rules->add($rules->existsIn(['wish_lists_id'], 'WishLists'));
        $rules->add($rules->existsIn(['orders_id'], 'Orders'));
        $rules->add($rules->existsIn(['wish_list_product_statuses_id'], 'WishListProductStatuses'));

        return $rules;
    }
}
