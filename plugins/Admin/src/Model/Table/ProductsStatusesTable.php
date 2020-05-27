<?php
namespace Admin\Model\Table;

use Cake\Validation\Validator;

/**
 * ProductsStatuses Model
 *
 * @method \Admin\Model\Entity\ProductsStatus get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\ProductsStatus newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\ProductsStatus[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\ProductsStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsStatus findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsStatusesTable extends AppTable
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

        $this->setTable('products_statuses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

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
            ->allowEmpty('slug');

        $validator
            ->integer('purchase')
            ->allowEmpty('purchase');

        $validator
            ->integer('view')
            ->allowEmpty('view');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
