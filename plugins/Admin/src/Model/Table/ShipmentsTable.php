<?php

namespace Admin\Model\Table;

use Admin\Model\ConfigTrait;
use Cake\Validation\Validator;

/**
 * Shipments Model
 *
 * @method \Admin\Model\Entity\Shipment get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Shipment newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Shipment[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Shipment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Shipment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Shipment[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Shipment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShipmentsTable extends AppTable
{
    use ConfigTrait;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('shipments');
        $this->setDisplayField('id');
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
            ->allowEmpty('code');

        $validator
            ->allowEmpty('key');

        $validator
            ->allowEmpty('value');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
