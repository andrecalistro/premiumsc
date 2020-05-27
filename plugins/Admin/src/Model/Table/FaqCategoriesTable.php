<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FaqCategories Model
 *
 * @property \Cake\ORM\Association\HasMany $FaqQuestions
 *
 * @method \Admin\Model\Entity\FaqCategory get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\FaqCategory newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\FaqCategory[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\FaqCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\FaqCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\FaqCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\FaqCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FaqCategoriesTable extends AppTable
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

        $this->setTable('faq_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

		$this->hasMany('FaqQuestions', [
			'foreignKey' => 'faq_categories_id',
			'className' => 'Admin.FaqQuestions'
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
            ->allowEmpty('name');

        $validator
            ->allowEmpty('slug');

		$validator
			->allowEmpty('pages');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
