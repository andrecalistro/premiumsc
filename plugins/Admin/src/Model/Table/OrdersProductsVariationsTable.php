<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdersProductsVariations Model
 *
 * @property \Admin\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \Admin\Model\Table\OrdersProductsTable|\Cake\ORM\Association\BelongsTo $OrdersProducts
 * @property \Admin\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \Admin\Model\Table\VariationsTable|\Cake\ORM\Association\BelongsTo $Variations
 *
 * @method \Admin\Model\Entity\OrdersProductsVariation get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\OrdersProductsVariation newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\OrdersProductsVariation[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersProductsVariation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\OrdersProductsVariation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersProductsVariation[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersProductsVariation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersProductsVariationsTable extends AppTable
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

        $this->setTable('orders_products_variations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'orders_id',
            'className' => 'Admin.Orders'
        ]);
        $this->belongsTo('OrdersProducts', [
            'foreignKey' => 'orders_products_id',
            'className' => 'Admin.OrdersProducts'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.Products'
        ]);
        $this->belongsTo('Variations', [
            'foreignKey' => 'variations_id',
            'className' => 'Admin.Variations'
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
            ->integer('quantity')
            ->allowEmpty('quantity');

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
        $rules->add($rules->existsIn(['orders_products_id'], 'OrdersProducts'));
        $rules->add($rules->existsIn(['products_id'], 'Products'));
        $rules->add($rules->existsIn(['variations_id'], 'Variations'));

        return $rules;
    }
}
