<?php

namespace Theme\Model\Table;

use Cake\Auth\Storage\SessionStorage;
use Cake\Core\Configure;
use Cake\I18n\Number;
use Cake\Network\Session;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Positions
 * @property \Cake\ORM\Association\BelongsToMany $Categories
 * @property \Cake\ORM\Association\BelongsToMany $Filters
 * @property \Cake\ORM\Association\HasMany $ProductsImages
 * @property \App\Model\Entity\Store $store
 * @property \Cake\ORM\Association\HasMany $ProductsTabs
 * @property \Cake\ORM\Association\BelongsTo $ProductsConditions
 * @property \Cake\ORM\Association\HasOne $ProductsSales
 * @property HasMany $ProductsVariations
 *
 * @method \Theme\Model\Entity\Product get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\Product findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends AppTable
{
    public $store;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Positions', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'positions_id',
            'joinTable' => 'products_positions',
            'className' => Configure::read('Theme') . '.Positions'
        ]);
        $this->belongsToMany('Categories', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'categories_id',
            'joinTable' => 'products_categories',
            'className' => Configure::read('Theme') . '.Categories'
        ]);
        $this->hasMany('ProductsImages', [
            'foreignKey' => 'products_id',
            'className' => Configure::read('Theme') . '.ProductsImages'
        ]);
        $this->belongsToMany('Attributes', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'attributes_id',
            'joinTable' => 'products_attributes',
            'className' => 'Admin.Attributes'
        ]);
        $this->hasMany('ProductsAttributes', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.ProductsAttributes'
        ]);

        $this->belongsToMany('ProductsChilds', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'childs_id',
            'joinTable' => 'products_relateds',
            'className' => Configure::read('Theme') . '.Products'
        ]);

        $this->belongsTo('Featured', [
            'foreignKey' => 'products_id',
            'className' => Configure::read('Theme') . '.Products'
        ]);

        $this->belongsToMany('Filters', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'filters_id',
            'joinTable' => 'products_filters',
            'className' => Configure::read('Theme') . '.Filters'
        ]);

        $this->belongsTo('ProductsConditions', [
            'foreignKey' => 'products_conditions_id',
            'className' => 'Admin.ProductsConditions'
        ]);

        $this->hasMany('ProductsTabs', [
            'foreignKey' => 'products_id',
            'className' => Configure::read('Theme') . '.ProductsTabs'
        ]);

        $this->belongsTo('ProductsStatuses', [
            'foreignKey' => 'status',
            'className' => Configure::read('Theme') . '.ProductsStatuses'
        ]);

        $this->hasMany('ProductsSales', [
            'foreignKey' => 'products_id',
            'className' => Configure::read('Theme') . '.ProductsSales'
        ]);

        $this->hasMany('ProductsVariations', [
            'foreignKey' => 'products_id',
            'className' => Configure::read('Theme') . '.ProductsVariations'
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
            ->allowEmpty('tags');

        $validator
            ->integer('stock')
            ->allowEmpty('stock');

        $validator
            ->decimal('price')
            ->allowEmpty('price');

        $validator
            ->decimal('price_special')
            ->allowEmpty('price_special');

        $validator
            ->integer('stock_control')
            ->allowEmpty('stock_control');

        $validator
            ->integer('show_price')
            ->allowEmpty('show_price');

        $validator
            ->allowEmpty('description');

        $validator
            ->decimal('weight')
            ->allowEmpty('weight');

        $validator
            ->decimal('length')
            ->allowEmpty('length');

        $validator
            ->decimal('width')
            ->allowEmpty('width');

        $validator
            ->decimal('height')
            ->allowEmpty('height');

        $validator
            ->integer('shipping_free')
            ->allowEmpty('shipping_free');

        $validator
            ->allowEmpty('seo_title');

        $validator
            ->allowEmpty('seo_description');

        $validator
            ->allowEmpty('seo_url');

        $validator
            ->integer('main')
            ->allowEmpty('main');

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
        $rules->add($rules->existsIn(['positions_id'], 'Positions'));

        return $rules;
    }

    public function findBestSellers(Query $query, array $options)
    {
//		$limit = $options['limit'];
//		dd($options);

        return $query
            ->contain([
                'ProductsImages',
                'ProductsSales',
                'Filters' => function ($q) {
                    return $q->contain('FiltersGroups');
                }
            ])
            ->innerJoinWith('ProductsSales')
            ->order(['ProductsSales.count' => 'DESC'])
            ->limit(4)
            ->toArray();
    }
}
