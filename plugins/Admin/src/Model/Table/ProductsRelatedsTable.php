<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductsRelateds Model
 *
 * @property \Admin\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \Admin\Model\Table\ChildsTable|\Cake\ORM\Association\BelongsTo $Childs
 *
 * @method \Admin\Model\Entity\ProductsRelated get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\ProductsRelated newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\ProductsRelated[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsRelated|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\ProductsRelated patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsRelated[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsRelated findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsRelatedsTable extends AppTable
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

        $this->setTable('products_relateds');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.Products'
        ]);
        $this->belongsTo('Childs', [
            'foreignKey' => 'childs_id',
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
        $rules->add($rules->existsIn(['childs_id'], 'Childs'));

        return $rules;
    }
}
