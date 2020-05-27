<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaqQuestions Model
 *
 * @property \Admin\Model\Table\FaqCategoriesTable|\Cake\ORM\Association\BelongsTo $FaqCategories
 *
 * @method \Admin\Model\Entity\FaqQuestion get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\FaqQuestion newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\FaqQuestion[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\FaqQuestion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\FaqQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\FaqQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\FaqQuestion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FaqQuestionsTable extends AppTable
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

        $this->setTable('faq_questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('FaqCategories', [
            'foreignKey' => 'faq_categories_id',
            'joinType' => 'INNER',
            'className' => 'Admin.FaqCategories'
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
            ->allowEmpty('question');

        $validator
            ->allowEmpty('answer');

        $validator
            ->integer('position')
            ->allowEmpty('position');

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
        $rules->add($rules->existsIn(['faq_categories_id'], 'FaqCategories'));

        return $rules;
    }
}
