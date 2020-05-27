<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DiscountsGroupsProducts Model
 *
 * @property \Admin\Model\Table\DiscountsGroupsTable|\Cake\ORM\Association\BelongsTo $DiscountsGroups
 * @property \Admin\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \Admin\Model\Entity\DiscountsGroupsProduct get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsProduct newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsProduct[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsProduct|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsProduct|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsProduct[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroupsProduct findOrCreate($search, callable $callback = null, $options = [])
 */
class DiscountsGroupsProductsTable extends AppTable
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

        $this->setTable('discount_group_products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('DiscountsGroups', [
            'foreignKey' => 'discounts_groups_id',
            'joinType' => 'INNER',
            'className' => 'Admin.DiscountsGroups'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Products'
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
        $rules->add($rules->existsIn(['discounts_groups_id'], 'DiscountsGroups'));
        $rules->add($rules->existsIn(['product_id'], 'Products'));

        return $rules;
    }
}
