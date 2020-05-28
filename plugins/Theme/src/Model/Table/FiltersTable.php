<?php

namespace Theme\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Filters Model
 *
 * @property \Theme\Model\Table\FiltersGroupsTable|\Cake\ORM\Association\BelongsTo $FiltersGroups
 * @property \Theme\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsToMany $Products
 *
 * @method \Theme\Model\Entity\Filter get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\Filter newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\Filter[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\Filter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\Filter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\Filter[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\Filter findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FiltersTable extends AppTable
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

        $this->setTable('filters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('FiltersGroups', [
            'foreignKey' => 'filters_groups_id',
            'className' => Configure::read('Theme') . '.FiltersGroups'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'filters_id',
            'targetForeignKey' => 'products_id',
            'joinTable' => 'products_filters',
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
        $rules->add($rules->existsIn(['filters_groups_id'], 'FiltersGroups'));

        return $rules;
    }

    /**
     * @param array $categories
     * @return array
     */
    public function getFiltersByGroup($categories = [])
    {
        $filters = [];
        $conditions = '';

        if ($categories) {
            $conditions = sprintf('where pc.categories_id in (%s)', implode(',', $categories));
        }

        $query = sprintf('select f.id, f.name, f.slug, fg.name as name_group, fg.slug as slug_group from filters f
            inner join products_filters pf on f.id = pf.filters_id
            inner join products_categories pc on pc.products_id = pf.products_id
            inner join filters_groups fg on fg.id = f.filters_groups_id
            %s
            group by pf.filters_id
            order by fg.name asc, f.name asc', $conditions);

        $results = $this->getConnection()
            ->execute($query)
            ->fetchAll('assoc');

        if (!$results) {
            return $filters;
        }

        foreach ($results as $result) {
            $filters[$result['name_group']][] = [
                'id' => $result['id'],
                'name' => $result['name'],
                'slug' => $result['slug'],
                'slug_group' => $result['slug_group']
            ];
        }

        return $filters;
    }
}
