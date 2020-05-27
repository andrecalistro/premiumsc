<?php
namespace Admin\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * WishLists Model
 *
 * @property \Admin\Model\Table\WishListStatusesTable|\Cake\ORM\Association\BelongsTo $WishListStatuses
 * @property \Admin\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \Admin\Model\Table\WishListProductsTable|\Cake\ORM\Association\HasMany $WishListProducts
 *
 * @method \Admin\Model\Entity\WishList get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\WishList newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\WishList[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\WishList|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\WishList|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\WishList patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\WishList[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\WishList findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WishListsTable extends AppTable
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

        $this->setTable('wish_lists');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('WishListStatuses', [
            'foreignKey' => 'wish_list_statuses_id',
            'className' => 'Admin.WishListStatuses'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Customers'
        ]);
        $this->hasMany('WishListProducts', [
            'foreignKey' => 'wish_lists_id',
            'className' => 'Admin.WishListProducts'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('description');

        $validator
            ->dateTime('validate')
            ->allowEmpty('validate');

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
        $rules->add($rules->existsIn(['wish_list_statuses_id'], 'WishListStatuses'));
        $rules->add($rules->existsIn(['customers_id'], 'Customers'));

        return $rules;
    }
}
