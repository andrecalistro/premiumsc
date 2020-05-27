<?php
namespace CheckoutV2\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Variations Model
 *
 * @property \CheckoutV2\Model\Table\VariationsGroupsTable|\Cake\ORM\Association\BelongsTo $VariationsGroups
 * @property \Theme\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsToMany $Products
 *
 * @method \CheckoutV2\Model\Entity\Variation get($primaryKey, $options = [])
 * @method \CheckoutV2\Model\Entity\Variation newEntity($data = null, array $options = [])
 * @method \CheckoutV2\Model\Entity\Variation[] newEntities(array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Variation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CheckoutV2\Model\Entity\Variation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Variation[] patchEntities($entities, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Variation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VariationsTable extends AppTable
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

        $this->setTable('variations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('VariationsGroups', [
            'foreignKey' => 'variations_groups_id',
            'className' => 'CheckoutV2.VariationsGroups'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'variation_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'products_variations',
            'className' => Configure::read("Theme") . '.Products'
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
        $rules->add($rules->existsIn(['variations_groups_id'], 'VariationsGroups'));

        return $rules;
    }
}