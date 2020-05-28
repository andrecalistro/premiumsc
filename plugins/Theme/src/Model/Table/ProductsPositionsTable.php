<?php
namespace Theme\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductsPositions Model
 *
 * @property \Theme\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \Admin\Model\Table\PositionsTable|\Cake\ORM\Association\BelongsTo $Positions
 *
 * @method \Admin\Model\Entity\ProductsPosition get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\ProductsPosition newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\ProductsPosition[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsPosition|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\ProductsPosition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsPosition[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsPosition findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsPositionsTable extends AppTable
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

        $this->setTable('products_positions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => 'Theme.Products'
        ]);
        $this->belongsTo('Positions', [
            'foreignKey' => 'positions_id',
            'className' => 'Admin.Positions'
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
        $rules->add($rules->existsIn(['positions_id'], 'Positions'));

        return $rules;
    }
}
