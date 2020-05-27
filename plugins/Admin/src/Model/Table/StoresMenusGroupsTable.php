<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StoresMenusGroups Model
 *
 * @property \Admin\Model\Table\StoresMenusItemsTable|\Cake\ORM\Association\HasMany $StoresMenusItems
 *
 * @method \Admin\Model\Entity\StoresMenusGroup get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\StoresMenusGroup newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\StoresMenusGroup[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\StoresMenusGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\StoresMenusGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\StoresMenusGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\StoresMenusGroup findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StoresMenusGroupsTable extends AppTable
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

        $this->setTable('stores_menus_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

		$this->hasMany('StoresMenusItems', [
			'className' => 'Admin.StoresMenusItems',
			'foreignKey' => 'stores_menus_groups_id'
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
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
