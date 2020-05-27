<?php

namespace Admin\Model\Table;

use Cake\Log\Log;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use ErrorException;

/**
 * CategoriesVisitors Model
 *
 * @property \Admin\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \Admin\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \Admin\Model\Entity\CategoriesVisitor get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\CategoriesVisitor newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\CategoriesVisitor[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\CategoriesVisitor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\CategoriesVisitor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\CategoriesVisitor[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\CategoriesVisitor findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CategoriesVisitorsTable extends AppTable
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

        $this->setTable('categories_visitors');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'foreignKey' => 'categories_id',
            'className' => 'Admin.Categories'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'className' => 'Admin.Customers'
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
            ->allowEmpty('ip');

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
        $rules->add($rules->existsIn(['categories_id'], 'Categories'));
//        $rules->add($rules->existsIn(['customers_id'], 'Customers'));

        return $rules;
    }

    /**
     * @return bool
     */
    public function registerVisitor()
    {
        if (Router::getRequest()->getQuery('page') !== null) {
            return false;
        }

        $data = [
            'customers_id' => Router::getRequest()->getSession()->read('Auth.User.id'),
            'ip' => Router::getRequest()->clientIp(),
            'categories_id' => Router::getRequest()->getParam('id')
        ];

        try {
            $this->save($this->newEntity($data));
            return true;
        } catch (ErrorException $e) {
            Log::write('error', "Erro ao salvar visita da categoria " . Router::getRequest()->getParam('id'));
            return false;
        }
    }

    /**
     * @param int $limit
     * @return array
     */
    public function topVisitors($limit = 6)
    {
        $data = $this->find()
            ->select([
                'total' => 'count(CategoriesVisitors.id)',
                'CategoriesVisitors.categories_id',
                'Categories.title'
            ])
            ->contain(['Categories'])
            ->group(['CategoriesVisitors.categories_id'])
            ->order(['total' => 'desc'])
            ->limit($limit)
            ->toArray();

        $data = Hash::extract($data, '{n}.category.title');
        return $data;
    }
}
