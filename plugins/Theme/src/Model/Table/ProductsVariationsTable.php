<?php
namespace Theme\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductsVariations Model
 *
 * @property \Theme\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \Theme\Model\Table\VariationsTable|\Cake\ORM\Association\BelongsTo $Variations
 * @property \Theme\Model\Table\VariationsGroupsTable|\Cake\ORM\Association\BelongsTo $VariationsGroups
 *
 * @method \Theme\Model\Entity\ProductsVariation get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\ProductsVariation newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\ProductsVariation[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsVariation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\ProductsVariation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsVariation[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\ProductsVariation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsVariationsTable extends AppTable
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

        $this->setTable('products_variations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => 'Theme.Products'
        ]);
        $this->belongsTo('Variations', [
            'foreignKey' => 'variations_id',
            'className' => 'Theme.Variations'
        ]);
        $this->belongsTo('VariationsGroups', [
            'foreignKey' => 'variations_groups_id',
            'className' => 'Theme.VariationsGroups'
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
            ->integer('required')
            ->allowEmpty('required');

        $validator
            ->integer('stock')
            ->allowEmpty('stock');

        $validator
            ->allowEmpty('image')
			->allowEmpty('auxiliary_field');

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
        $rules->add($rules->existsIn(['variations_id'], 'Variations'));
        $rules->add($rules->existsIn(['variations_groups_id'], 'VariationsGroups'));

        return $rules;
    }
}
