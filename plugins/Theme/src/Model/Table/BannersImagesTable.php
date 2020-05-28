<?php

namespace Theme\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BannersImages Model
 *
 * @property \Theme\Model\Table\BannersTable|\Cake\ORM\Association\BelongsTo $Banners
 *
 * @method \Theme\Model\Entity\BannersImage get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\BannersImage newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\BannersImage[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\BannersImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\BannersImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\BannersImage[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\BannersImage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BannersImagesTable extends AppTable
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

        $this->setTable('banners_images');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Banners', [
            'foreignKey' => 'banners_id',
            'className' => Configure::read('Theme') . '.Banners'
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
            ->allowEmpty('background');

        $validator
            ->allowEmpty('image');

        $validator
            ->allowEmpty('path');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->date('validate')
            ->allowEmpty('validate');

        $validator
            ->integer('always')
            ->allowEmpty('always');

        $validator
            ->integer('sunday')
            ->allowEmpty('sunday');

        $validator
            ->integer('monday')
            ->allowEmpty('monday');

        $validator
            ->integer('tuesday')
            ->allowEmpty('tuesday');

        $validator
            ->integer('wednesday')
            ->allowEmpty('wednesday');

        $validator
            ->integer('thursday')
            ->allowEmpty('thursday');

        $validator
            ->integer('friday')
            ->allowEmpty('friday');

        $validator
            ->integer('saturday')
            ->allowEmpty('saturday');

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
        $rules->add($rules->existsIn(['banners_id'], 'Banners'));

        return $rules;
    }
}
