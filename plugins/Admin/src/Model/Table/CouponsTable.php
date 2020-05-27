<?php
namespace Admin\Model\Table;

use ArrayObject;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Coupons Model
 *
 * @method \Admin\Model\Entity\Coupon get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Coupon newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Coupon[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Coupon|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Coupon patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Coupon[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Coupon findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CouponsTable extends AppTable
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

        $this->setTable('coupons');
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
            ->allowEmpty('description');

        $validator
            ->allowEmpty('code');

        $validator
            ->allowEmpty('type');

        $validator
            ->decimal('value')
            ->allowEmpty('value');

		$validator
			->boolean('free_shipping')
//			->requirePresence('free_shipping', 'create')
			->allowEmpty('free_shipping');

        $validator
            ->dateTime('release_date')
            ->allowEmpty('release_date');

        $validator
            ->dateTime('expiration_date')
            ->allowEmpty('expiration_date');

        $validator
            ->decimal('min_value')
            ->allowEmpty('min_value');

        $validator
            ->decimal('max_value')
            ->allowEmpty('max_value');

        $validator
            ->boolean('only_individual_use')
//            ->requirePresence('only_individual_use', 'create')
            ->allowEmpty('only_individual_use');

        $validator
            ->boolean('exclude_promotional_items')
//            ->requirePresence('exclude_promotional_items', 'create')
            ->allowEmpty('exclude_promotional_items');

        $validator
            ->allowEmpty('products_ids');

        $validator
            ->allowEmpty('excluded_products_ids');

        $validator
            ->allowEmpty('categories_ids');

        $validator
            ->allowEmpty('excluded_categories_ids');

        $validator
            ->allowEmpty('restricted_emails_list');

        $validator
            ->integer('use_limit')
            ->allowEmpty('use_limit');

        $validator
            ->integer('used_limit')
			->allowEmpty('use_limit');

        $validator
            ->integer('customer_use_limit')
            ->allowEmpty('customer_use_limit');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

	/**
	 * @param Event $event
	 * @param ArrayObject $data
	 * @param ArrayObject $options
	 */
	public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
	{
		// encode de campos json
		if(isset($data['products_ids']) && !empty($data['products_ids'])) {
			$data['products_ids'] = json_encode($data['products_ids']);
		}

		if(isset($data['excluded_products_ids']) && !empty($data['excluded_products_ids'])) {
			$data['excluded_products_ids'] = json_encode($data['excluded_products_ids']);
		}

		if(isset($data['categories_ids']) && !empty($data['categories_ids'])) {
			$data['categories_ids'] = json_encode($data['categories_ids']);
		}

		if(isset($data['excluded_categories_ids']) && !empty($data['excluded_categories_ids'])) {
			$data['excluded_categories_ids'] = json_encode($data['excluded_categories_ids']);
		}


		// formatação de valores numéricos
		if (isset($data['value'])) {
			$data['value'] = str_replace(',', '.', str_replace('.', '', $data['value']));
		}

		if (isset($data['min_value'])) {
			$data['min_value'] = str_replace(',', '.', str_replace('.', '', $data['min_value']));
		}

		if (isset($data['max_value'])) {
			$data['max_value'] = str_replace(',', '.', str_replace('.', '', $data['max_value']));
		}


		// formatação de datas
		if(isset($data['release_date']) && !empty($data['release_date'])) {
			$data['release_date'] = Time::createFromFormat('d/m/Y H:i', $data['release_date'], 'America/Sao_Paulo');
		}

		if(isset($data['expiration_date']) && !empty($data['expiration_date'])) {
			$data['expiration_date'] = Time::createFromFormat('d/m/Y H:i', $data['expiration_date'], 'America/Sao_Paulo');
		}
	}
}
