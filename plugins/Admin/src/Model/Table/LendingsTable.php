<?php

namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lendings Model
 *
 * @property \Admin\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Admin\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsToMany $Products
 *
 * @method \Admin\Model\Entity\Lending get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Lending newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Lending[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Lending|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Lending patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Lending[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Lending findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LendingsTable extends AppTable
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

        $this->setTable('lendings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'className' => 'Admin.Users'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'lendings_id',
            'targetForeignKey' => 'products_id',
            'joinTable' => 'lendings_products',
            'className' => 'Admin.Products'
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
            ->notEmpty('customer_name', __('Por favor, preencha o nome.'));

        $validator
            ->notEmpty('customer_email', __('Por favor, preencha o e-mail.'))
            ->email('customer_email', false, __('Por favor, insira um e-mail válido.'));

        $validator
            ->notEmpty('customer_document', __('Por favor, preencha o CPF.'));

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->integer('send_status')
            ->allowEmpty('send_status');

        $validator
            ->date('send_date')
            ->allowEmpty('send_date');

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
        $rules->add($rules->existsIn(['users_id'], 'Users'));

        return $rules;
    }

    public function updateProducts($id, $productsIds) {
		$lending = $this->get($id, [
			'contain' => ['LendingsProducts']
		]);

		$data = [];

		foreach ($lending->lendings_products as $product) {
			if (in_array($product->products_id, $productsIds)) {
				$data['lendings_products'][] = [
					'id' => $product->id,
					'status' => 1
				];

				unset($productsIds[array_search($product->products_id, $productsIds)]);
			}
		}

		foreach ($productsIds as $product) {
			$data['lendings_products'][] = [
				'products_id' => $product,
				'status' => 1
			];
		}

		$lending = $this->patchEntity($lending, $data, [
			'associated' => ['LendingsProducts']
		]);

		return $this->save($lending);
	}
}
