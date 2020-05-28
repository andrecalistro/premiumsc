<?php

namespace Theme\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdersProductsVariations Model
 *
 * @property \Theme\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property |\Cake\ORM\Association\BelongsTo $OrdersProducts
 * @property \Theme\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \Theme\Model\Table\VariationsTable|\Cake\ORM\Association\BelongsTo $Variations
 *
 * @method \Theme\Model\Entity\OrdersProductsVariation get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\OrdersProductsVariation newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\OrdersProductsVariation[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\OrdersProductsVariation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\OrdersProductsVariation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\OrdersProductsVariation[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\OrdersProductsVariation findOrCreate($search, callable $callback = null, $options = [])
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
            'className' => Configure::read('Theme') . '.Orders'
        ]);
        $this->belongsTo('OrdersProducts', [
            'foreignKey' => 'orders_products_id',
            'className' => Configure::read('Theme') . '.OrdersProducts'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => Configure::read('Theme') . '.Products'
        ]);
        $this->belongsTo('Variations', [
            'foreignKey' => 'variations_id',
            'className' => Configure::read('Theme') . '.Variations'
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
