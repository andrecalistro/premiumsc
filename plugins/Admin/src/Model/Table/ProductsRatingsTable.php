<?php

namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductsRatings Model
 *
 * @property \Admin\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \Admin\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \Admin\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \Admin\Model\Table\ProductsRatingsStatusesTable|\Cake\ORM\Association\BelongsTo $ProductsRatingsStatuses
 *
 * @method \Admin\Model\Entity\ProductsRating get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\ProductsRating newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\ProductsRating[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsRating|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\ProductsRating|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\ProductsRating patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsRating[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsRating findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsRatingsTable extends Table
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

        $this->setTable('products_ratings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Customers'
        ]);
        $this->belongsTo('Orders', [
            'foreignKey' => 'orders_id',
            'className' => 'Admin.Orders'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.Products'
        ]);
        $this->belongsTo('ProductsRatingsStatuses', [
            'foreignKey' => 'products_ratings_statuses_id',
            'joinType' => 'INNER',
            'className' => 'Admin.ProductsRatingsStatuses'
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
            ->integer('rating')
            ->requirePresence('rating', 'create')
            ->notEmpty('rating');

        $validator
            ->scalar('answer')
            ->allowEmpty('answer');

        $validator
            ->scalar('products_name')
            ->maxLength('products_name', 255)
            ->requirePresence('products_name', 'create')
            ->notEmpty('products_name');

        $validator
            ->scalar('products_image')
            ->maxLength('products_image', 255)
            ->requirePresence('products_image', 'create')
            ->notEmpty('products_image');

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
        $rules->add($rules->existsIn(['orders_id'], 'Orders'));
        $rules->add($rules->existsIn(['products_id'], 'Products'));
        $rules->add($rules->existsIn(['products_ratings_statuses_id'], 'ProductsRatingsStatuses'));

        return $rules;
    }

    /**
     * @param $orders_id
     * @param $customers_id
     * @return bool
     */
    public function checkAnswered($orders_id, $customers_id)
    {
        $answer = $this->find()
            ->where([
                'customers_id' => $customers_id,
                'orders_id' => $orders_id
            ])
            ->toArray();

        return \count($answer) > 0;
    }
}
