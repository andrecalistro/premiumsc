<?php
namespace Admin\Model\Table;

use Cake\Validation\Validator;

/**
 * WishListStatuses Model
 *
 * @method \Admin\Model\Entity\WishListStatus get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\WishListStatus newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\WishListStatus[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\WishListStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\WishListStatus|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\WishListStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\WishListStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\WishListStatus findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WishListStatusesTable extends AppTable
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

        $this->setTable('wish_list_statuses');
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
