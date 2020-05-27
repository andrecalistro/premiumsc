<?php
namespace CheckoutV2\Model\Table;

use Cake\Validation\Validator;

/**
 * VariationsGroups Model
 *
 * @method \CheckoutV2\Model\Entity\VariationsGroup get($primaryKey, $options = [])
 * @method \CheckoutV2\Model\Entity\VariationsGroup newEntity($data = null, array $options = [])
 * @method \CheckoutV2\Model\Entity\VariationsGroup[] newEntities(array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\VariationsGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CheckoutV2\Model\Entity\VariationsGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\VariationsGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\VariationsGroup findOrCreate($search, callable $callback = null, $options = [])
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
            ->allowEmpty('name');

        $validator
            ->allowEmpty('slug');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}