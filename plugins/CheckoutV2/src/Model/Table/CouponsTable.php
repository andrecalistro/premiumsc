<?php

namespace CheckoutV2\Model\Table;

use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Checkout\Model\Entity\Coupon;
use Checkout\Model\Entity\Customer;

/**
 * Coupons Model
 *
 * @method \CheckoutV2\Model\Entity\Coupon get($primaryKey, $options = [])
 * @method \CheckoutV2\Model\Entity\Coupon newEntity($data = null, array $options = [])
 * @method \CheckoutV2\Model\Entity\Coupon[] newEntities(array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Coupon|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \CheckoutV2\Model\Entity\Coupon patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Coupon[] patchEntities($entities, array $data, array $options = [])
 * @method \CheckoutV2\Model\Entity\Coupon findOrCreate($search, callable $callback = null, $options = [])
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
            ->requirePresence('free_shipping', 'create')
            ->notEmpty('free_shipping');

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
            ->requirePresence('only_individual_use', 'create')
            ->notEmpty('only_individual_use');

        $validator
            ->boolean('exclude_promotional_items')
            ->requirePresence('exclude_promotional_items', 'create')
            ->notEmpty('exclude_promotional_items');

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
            ->allowEmpty('used_limit');

        $validator
            ->integer('customer_use_limit')
            ->allowEmpty('customer_use_limit');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    public function findCode(Query $query, array $options)
    {
        return $query->where(['code' => $options['code']]);
    }

    /**
     * @param $coupon
     * @param $subtotal
     * @param $total
     * @param $quoteprice
     * @param $products
     * @param null $customer
     * @param null $categories
     * @return array
     * @throws \Exception
     */
    public function calcDiscount(
        $coupon,
        $subtotal,
        $total,
        $quoteprice,
        $products,
        $customer = null,
        $categories = null
    ) {
        if (!empty($coupon->release_date) && ($coupon->release_date->getTimestamp() >= Time::now('America/Sao_Paulo')->getTimestamp())) {
            throw new \Exception('O cupom só poderá ser usado a partir de ' . $coupon->release_date->format('d/m/Y H:i'), 401);
        }

        if (!empty($coupon->expiration_date) && ($coupon->expiration_date->getTimestamp() <= Time::now('America/Sao_Paulo')->getTimestamp())) {
            throw new \Exception('O cupom expirou', 401);
        }

        if (!empty($coupon->min_value) && ($coupon->min_value > $subtotal->subtotal)) {
            throw new \Exception('O valor da sua compra deve ser de no mínimo R$ ' . number_format($coupon->min_value, 2, ",", ".") . ' para utilizar esse cupom', 401);
        }

        if (!empty($coupon->max_value) && ($coupon->max_value < $subtotal->subtotal)) {
            throw new \Exception('O valor da sua compra deve ser de no máximo R$ ' . number_format($coupon->max_value, 2, ",", ".") . ' para utilizar esse cupom', 401);
        }

        if (!empty($coupon->restricted_emails_list)) {
            if (isset($customer->email) && !empty($customer->email) && !preg_match($customer->email, $coupon->restricted_emails_list)) {
                throw new \Exception('O cupom não foi destinado ao email ' . $customer->email, 401);
            }
        }

        if (!empty($coupon->use_limit) && $coupon->used_limit >= $coupon->use_limit) {
            throw new \Exception('Esse cupom já excedeu o limite de uso', 401);
        }

        switch ($coupon->type) {
            case 'percentage':
                $discount = $subtotal['subtotal'] * ($coupon->value / 100);
                $subtotal = $subtotal['subtotal'] - $discount;
                break;
//            case 'cart':
            case 'free_shipping':
                $discount = $quoteprice['quote_price'];
                $subtotal = $subtotal['subtotal'] - $quoteprice['quote_price'];
                break;
            default:
                $discount = $coupon->value;
                $subtotal = $subtotal['subtotal'] - $discount;
                break;
        }

        if ($subtotal < 0) {
            $subtotal = 0;
        }

        return [
            'subtotal' => $subtotal,
            'total' => $total,
            'discount' => $discount,
            'code' => $coupon->code,
            'id' => $coupon->id
        ];
    }
}
