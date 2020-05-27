<?php

namespace Admin\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * RulesMenus Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Rules
 * @property \Cake\ORM\Association\BelongsTo $Menuses
 *
 * @method \Admin\Model\Entity\RulesMenu get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\RulesMenu newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\RulesMenu[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\RulesMenu|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\RulesMenu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\RulesMenu[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\RulesMenu findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RulesMenusTable extends AppTable
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

        $this->setTable('rules_menus');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Rules', [
            'foreignKey' => 'rules_id',
            'className' => 'Admin.Rules'
        ]);
        $this->belongsTo('Menus', [
            'foreignKey' => 'menus_id',
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
        $rules->add($rules->existsIn(['rules_id'], 'Rules'));
        $rules->add($rules->existsIn(['menus_id'], 'Menus'));

        return $rules;
    }
}
