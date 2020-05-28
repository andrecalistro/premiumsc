<?php
namespace Theme\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductsTabs Model
 *
 * @property \Theme\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \Theme\Model\Entity\ProductsTab get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\ProductsTab newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\ProductsTab[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsTab|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\ProductsTab patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsTab[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsTab findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTabsTable extends AppTable
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

        $this->setTable('products_tabs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => Configure::read('Theme') . '.Products'
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
            ->integer('order_show')
            ->allowEmpty('order_show');

        $validator
            ->allowEmpty('content');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->allowEmpty('slug');

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

        return $rules;
    }
}
