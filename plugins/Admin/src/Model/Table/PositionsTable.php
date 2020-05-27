<?php
namespace Admin\Model\Table;

use Cake\Validation\Validator;

/**
 * Positions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $PositionsPages
 * @property \Cake\ORM\Association\BelongsToMany $Products
 * @property \Cake\ORM\Association\HasMany $ProductsPositions
 *
 * @method \Admin\Model\Entity\Position get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Position newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Position[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Position|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Position patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Position[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Position findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PositionsTable extends AppTable
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

        $this->setTable('positions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PositionsPages',[
            'className' => 'Admin.PositionsPages',
            'foreignKey' => 'positions_pages_id'
        ]);

        $this->belongsToMany('Products', [
            'foreignKey' => 'positions_id',
            'targetForeignKey' => 'products_id',
            'joinTable' => 'products_positions',
            'className' => 'Admin.Products'
        ]);

        $this->hasMany('ProductsPositions', [
            'foreignKey' => 'positions_id',
            'className' => 'Admin.ProductsPositions'
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
            ->notEmpty('name', __("Por favor, preencha o nome."));

        $validator
            ->allowEmpty('slug');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
