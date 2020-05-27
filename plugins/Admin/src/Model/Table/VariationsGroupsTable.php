<?php

namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VariationsGroups Model
 *
 * @property ProductsTable $Products
 * @property VariationsTable $Variations
 *
 * @method \Admin\Model\Entity\VariationsGroup get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\VariationsGroup newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\VariationsGroup[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\VariationsGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\VariationsGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\VariationsGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\VariationsGroup findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VariationsGroupsTable extends AppTable
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

        $this->setTable('variations_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Products', [
            'foreignKey' => 'variations_groups_id',
            'targetForeignKey' => 'products_id',
            'joinTable' => 'products_variations',
            'className' => 'Admin.Products',
            'cascadeCallbacks' => true
        ]);

        $this->hasMany('Variations', [
            'foreignKey' => 'variations_groups_id',
            'className' => 'Admin.Variations',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);

        $this->addBehavior('Timestamp');
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
            ->notEmpty('name', __('Por favor, preencha o nome.'));

        $validator
            ->allowEmpty('slug')
            ->notEmpty('auxiliary_field_type', __('Por favor, selecione o tipo do campo auxiliar'));

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
