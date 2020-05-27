<?php

namespace CheckoutV2\Model\Table;

use Cake\Collection\CollectionInterface;
use Cake\Core\Configure;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Carts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\BelongsTo $Products
 * @property BelongsTo $Variations
 *
 * @method \CheckoutV2\Model\Entity\Cart get($primaryKey, $options = [])
 * @method \CheckoutV2\Model\Entity\Cart newEntity($data = null, array $options = [])
 * @method \CheckoutV2\Model\Entity\Cart[] newEntities(array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Cart|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CheckoutV2\Model\Entity\Cart patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Cart[] patchEntities($entities, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Cart findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CartsTable extends AppTable
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

        $this->setTable('carts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'className' => 'CheckoutV2.Customers'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => Configure::read('Theme') . '.Products'
        ]);
        $this->belongsTo('Variations', [
            'foreignKey' => 'variations_id',
            'className' => 'CheckoutV2.Variations'
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
            ->allowEmpty('option');

        $validator
            ->decimal('unit_price')
            ->allowEmpty('unit_price');

        $validator
            ->decimal('total_price')
            ->allowEmpty('total_price');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted')
            ->allowEmpty('variations_id');

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
        //$rules->add($rules->existsIn(['customers_id'], 'Customers'));
        $rules->add($rules->existsIn(['products_id'], 'Products'));

        return $rules;
    }

    /**
     * @param Query $query
     * @param array $options
     * @return mixed
     */
    public function findSubTotal(Query $query, array $options)
    {
        return $query->select(['subtotal' => $query->func()->sum('total_price')])
            ->where(['session_id' => $options['session_id']])
            ->formatResults(function (CollectionInterface $results) {
                return $results->map(function ($row) {
                    $row['subtotal_format'] = "R$ " . number_format($row['subtotal'], 2, ",", ".");
                    return $row;
                });
            })
            ->first();
    }

    /**
     * @param Query $query
     * @param array $options
     * @return array
     */
    public function findProducts(Query $query, array $options)
    {
        $conditions[] = ['session_id' => $options['session_id']];
        if (isset($options['shipping_control'])) {
            $conditions[] = ['Products.shipping_control' => 1];
        }
        return $query->contain([
            'Products' => function ($q) {
                return $q->contain([
                    'ProductsImages',
                    'ProductsVariations'
                ]);
            },
            'Variations' => function ($q) {
                return $q->contain(['VariationsGroups']);
            }
        ])
            ->formatResults(function (CollectionInterface $results) {
                $items = [];
                if ($results) {
                    foreach ($results as $key => $result) {
                        $items[$key] = $result->product;
                        $items[$key]['variation'] = $result->variation;
                        $items[$key]['variations_sku'] = $result->variations_sku;
                        $items[$key]['quantity'] = $result->quantity;
                        $items[$key]['unit_price_format'] = $result->unit_price_format;
                        $items[$key]['total_price_format'] = $result->total_price_format;
                        $items[$key]['unit_price'] = $result->unit_price;
                        $items[$key]['total_price'] = $result->total_price;
                        $items[$key]['carts_id'] = $result->id;
                        $items[$key]['available_stock'] = $result->product->stock;

                        if ($result->variation) {
                            $items[$key]['variation_group_text'] = $result->variation->variations_group->name;
                            $items[$key]['variation_text'] = $result->variation->name;
                            if (isset(Hash::extract($result->product->products_variations, '{n}[variations_id=' . $result->variations_id . '].stock')[0])) {
                                $items[$key]['available_stock'] = Hash::extract($result->product->products_variations, '{n}[variations_id=' . $result->variations_id . '].stock')[0];
                            }
                        }
                    }
                }
                return $items;
            })
            ->where($conditions)
            ->toArray();
    }
}
