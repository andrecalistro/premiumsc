<?php

namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * ProductsSearches Model
 *
 * @property \Admin\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \Admin\Model\Entity\ProductsSearch get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\ProductsSearch newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\ProductsSearch[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsSearch|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\ProductsSearch patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsSearch[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsSearch findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsSearchesTable extends AppTable
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

        $this->setTable('products_searches');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'className' => 'Admin.Customers'
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
            ->allowEmpty('term');

        $validator
            ->allowEmpty('ip');

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
//        $rules->add($rules->existsIn(['customers_id'], 'Customers'));

        return $rules;
    }

    /**
     * @param int $limit
     * @return array
     */
    public function topSearches($limit = 6)
    {
        $searches = $this->find()
            ->select([
                'total' => 'count(ProductsSearches.id)',
                'ProductsSearches.term'
            ])
            ->group(['ProductsSearches.term'])
            ->order(['total' => 'desc'])
            ->limit($limit)
            ->toArray();

        $searches = Hash::extract($searches, '{n}.term');

        return $searches;
    }
}
