<?php
namespace Theme\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductsSales Model
 *
 * @property \Theme\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \Theme\Model\Entity\ProductsSale get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\ProductsSale newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\ProductsSale[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsSale|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\ProductsSale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsSale[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsSale findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsSalesTable extends AppTable
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

        $this->setTable('products_sales');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => 'Theme.Products'
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
            ->integer('count')
            ->allowEmpty('count');

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
