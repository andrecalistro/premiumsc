<?php
namespace Theme\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FiltersGroups Model
 *
 * @method \Theme\Model\Entity\FiltersGroup get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\FiltersGroup newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\FiltersGroup[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\FiltersGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\FiltersGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\FiltersGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\FiltersGroup findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FiltersGroupsTable extends AppTable
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

        $this->setTable('filters_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Filters', [
            'foreignKey' => 'filters_groups_id',
            'className' => Configure::read('Theme') . '.Filters'
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
}
