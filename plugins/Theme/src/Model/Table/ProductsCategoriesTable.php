<?php

namespace Theme\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * ProductsCategories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Products
 * @property \Cake\ORM\Association\BelongsTo $Categories
 *
 * @method \Theme\Model\Entity\ProductsCategory get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\ProductsCategory newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\ProductsCategory[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\ProductsCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsCategoriesTable extends AppTable
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

        $this->setTable('products_categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => Configure::read('Theme') . '.Products'
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'categories_id',
            'className' => Configure::read('Theme') . '.Categories'
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
        $rules->add($rules->existsIn(['products_id'], 'Products'));
        $rules->add($rules->existsIn(['categories_id'], 'Categories'));

        return $rules;
    }
}
