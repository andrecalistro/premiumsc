<?php

namespace Admin\Model\Table;

use Cake\Validation\Validator;

/**
 * OrdersStatuses Model
 *
 * @method \Admin\Model\Entity\OrdersStatus get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\OrdersStatus newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\OrdersStatus[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\OrdersStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\OrdersStatus findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersStatusesTable extends AppTable
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

        $this->setTable('orders_statuses');
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
            ->dateTime('deleted')
            ->allowEmpty('deleted')
            ->allowEmpty('background_color')
            ->allowEmpty('font_color');

        return $validator;
    }
}
