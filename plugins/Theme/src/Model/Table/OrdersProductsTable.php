<?php

namespace Theme\Model\Table;

use Cake\Core\Configure;
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
 * @method \Theme\Model\Entity\OrdersProduct get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\OrdersProduct newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\OrdersProduct[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\OrdersProduct|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\OrdersProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\OrdersProduct[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\OrdersProduct findOrCreate($search, callable $callback = null, $options = [])
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
            'className' => Configure::read('Theme') . '.Orders'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => Configure::read('Theme') . '.Products'
        ]);
        $this->hasMany('OrdersProductsVariations', [
            'foreignKey' => 'orders_products_id',
            'className' => Configure::read('Theme') . '.OrdersProductsVariations',
//            'dependent' => true,
//            'cascadeCallbacks' => true
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
            ->integer('quantity')
            ->allowEmpty('quantity');

        $validator
            ->decimal('price')
            ->allowEmpty('price');

        $validator
            ->decimal('price_total')
            ->allowEmpty('price_total')
            ->allowEmpty('image_thumb')
            ->allowEmpty('image')
            ->allowEmpty('price_special');

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
}
