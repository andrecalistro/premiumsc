<?php

namespace Theme\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Categories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentCategories
 * @property \Cake\ORM\Association\HasMany $ChildCategories
 * @property \Cake\ORM\Association\BelongsToMany $Products
 *
 * @method \Theme\Model\Entity\Category get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CategoriesTable extends AppTable
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

        $this->setTable('categories');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentCategories', [
            'className' => Configure::read('Theme') . '.Categories',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildCategories', [
            'className' => Configure::read('Theme') . '.Categories',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'categories_id',
            'targetForeignKey' => 'products_id',
            'joinTable' => 'products_categories',
            'className' => Configure::read('Theme') . '.Products'
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
            ->allowEmpty('title');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->allowEmpty('description');

        $validator
            ->allowEmpty('seo_description');

        $validator
            ->allowEmpty('seo_title');

        $validator
            ->allowEmpty('seo_url');

        $validator
            ->allowEmpty('image');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentCategories'));

        return $rules;
    }
}
