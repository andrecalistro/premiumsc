<?php

namespace Admin\Model\Table;

use ArrayObject;
use Cake\Event\Event;
use Cake\Validation\Validator;

/**
 * Banners Model
 *
 * @property \Cake\ORM\Association\HasMany $BannersImages
 *
 * @method \Admin\Model\Entity\Banner get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Banner newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Banner[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Banner|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Banner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Banner[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Banner findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BannersTable extends AppTable
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

        $this->setTable('banners');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('BannersImages', [
            'foreignKey' => 'banners_id',
            'className' => 'Admin.BannersImages'
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
            ->notEmpty('name', __("Por favor, preencha a posição."));

        $validator
            ->allowEmpty('slug');

        $validator
            ->allowEmpty('description');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
