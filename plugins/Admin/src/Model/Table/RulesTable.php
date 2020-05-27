<?php

namespace Admin\Model\Table;

use Cake\Validation\Validator;

/**
 * Rules Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Menus
 *
 * @method \Admin\Model\Entity\Rule get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Rule newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Rule[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Rule|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Rule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Rule[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Rule findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RulesTable extends AppTable
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

        $this->setTable('rules');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Menus', [
            'foreignKey' => 'rules_id',
            'targetForeignKey' => 'menus_id',
            'joinTable' => 'rules_menus',
            'className' => 'Admin.Menus'
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
            ->dateTime('modifed')
            ->allowEmpty('modifed');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
