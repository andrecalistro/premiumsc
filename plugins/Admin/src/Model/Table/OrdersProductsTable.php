<?php
namespace Admin\Model\Table;

use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdersProducts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Orders
 * @property \Cake\ORM\Association\BelongsTo $Products
 * @property \Cake\ORM\Association\BelongsTo $ProductsOptions
 * @property HasMany $OrdersProductsVariations
 *
 * @method \Admin\Model\Entity\OrdersProduct get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\OrdersProduct newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\OrdersProduct[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersProduct|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\OrdersProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersProduct[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersProduct findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersProductsTable extends AppTable
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

        $this->setTable('orders_products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'orders_id',
            'className' => 'Admin.Orders'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.Products'
        ]);
//        $this->belongsTo('ProductsOptions', [
//            'foreignKey' => 'products_options_id',
//            'className' => 'Admin.ProductsOptions'
//        ]);
        $this->hasMany('OrdersProductsVariations', [
            'foreignKey' => 'orders_products_id',
            'className' => 'Admin.OrdersProductsVariations'
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
            ->allowEmpty('name');

        $validator
            ->allowEmpty('image_thumb');

        $validator
            ->allowEmpty('image');

        $validator
            ->integer('quantity')
            ->allowEmpty('quantity');

        $validator
            ->decimal('price_special')
            ->allowEmpty('price_special');

        $validator
            ->decimal('price')
            ->allowEmpty('price');

        $validator
            ->decimal('price_total')
            ->allowEmpty('price_total');

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
        $rules->add($rules->existsIn(['products_id'], 'Products'));
//        $rules->add($rules->existsIn(['products_options_id'], 'ProductsOptions'));

        return $rules;
    }

    /**
     * @param int $limit
     * @return array
     */
    public function bestSellers($limit)
    {
        $data = $this->find()
            ->select([
                'total' => 'count(OrdersProducts.products_id)',
                'OrdersProducts.name'
            ])
            ->contain(['Products'])
            ->group(['OrdersProducts.name'])
            ->order(['total' => 'desc'])
            ->limit($limit)
            ->toArray();
                
        return $data;

    }
}
