<?php

namespace CheckoutV2\Model\Table;

use Admin\Model\ConfigTrait;
use Cake\ORM\Query;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Shipments Model
 *
 * @method \CheckoutV2\Model\Entity\Shipment get($primaryKey, $options = [])
 * @method \CheckoutV2\Model\Entity\Shipment newEntity($data = null, array $options = [])
 * @method \CheckoutV2\Model\Entity\Shipment[] newEntities(array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Shipment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CheckoutV2\Model\Entity\Shipment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Shipment[] patchEntities($entities, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Shipment findOrCreate($search, callable $callback = null, $options = [])
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
            ->allowEmpty('keyword');

        $validator
            ->allowEmpty('value');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * @param Query $query
     * @param array $options
     * @return $this
     */
    public function findEnables(Query $query, array $options)
    {
        return $query->where([
            'keyword LIKE' => '%_status',
            'value' => 1
        ])
            ->select(['code']);
    }

    /**
     * @param $products
     * @return int|mixed
     */
    public function getProductsAdditionalDays($products)
    {
        if (!$products) {
            return 0;
        }
        $days = max(Hash::extract($products, '{n}.additional_delivery_time'));
        return $days === null ? 0 : $days;
    }
}
