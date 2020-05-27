<?php
namespace Admin\Model\Table;

use Cake\Validation\Validator;

/**
 * StocksStatuses Model
 *
 * @method \Admin\Model\Entity\StocksStatus get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\StocksStatus newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\StocksStatus[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\StocksStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\StocksStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\StocksStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\StocksStatus findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StocksStatusesTable extends AppTable
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

        $this->setTable('stocks_statuses');
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
            ->notEmpty('name', __("Por favor, preencha o nome."));

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
