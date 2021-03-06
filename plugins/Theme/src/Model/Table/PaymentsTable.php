<?php

namespace Theme\Model\Table;

use Admin\Model\ConfigTrait;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payments Model
 *
 * @method \Theme\Model\Entity\Payment get($primaryKey, $options = [])
 * @method \Theme\Model\Entity\Payment newEntity($data = null, array $options = [])
 * @method \Theme\Model\Entity\Payment[] newEntities(array $data, array $options = [])
 * @method \Theme\Model\Entity\Payment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Theme\Model\Entity\Payment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Theme\Model\Entity\Payment[] patchEntities($entities, array $data, array $options = [])
 * @method \Theme\Model\Entity\Payment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentsTable extends AppTable
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

        $this->setTable('payments');
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
     * @param $payment_config
     * @param $price
     * @return array
     */
    public function installments($payment_config, $price)
    {
        $installments = [];
        $interest = str_replace(',', '.', $payment_config->interest) / 100;
        if ($price < $payment_config->installment_min) {
            $installments[1] = '1x de ' . 'R$ ' . number_format($price, 2, ",", ".") . ' sem juros';
        } else {
            for ($i = 1; $i <= $payment_config->installment; $i++) {
                if ($i <= $payment_config->installment_free) {
                    $price_without_installment = ($price / $i);
                    if ($price_without_installment >= $payment_config->installment_min) {
                        $installments[$i] = [
                            'formatted' => $i . 'x de ' . 'R$ ' . number_format($price_without_installment, 2, ",", ".") . ' sem juros',
                            'regular' => $price_without_installment
                        ];
                    }
                } else {
                    $price_with_installment = $price / ((1 - pow((1 - $interest), $i)) / $interest);
                    if ($price_with_installment >= $payment_config->installment_min) {
                        $installments[$i] = [
                            'formatted' => $i . 'x de ' . 'R$ ' . number_format($price_with_installment, 2, ",", ".") . ' com juros',
                            'regular' => $price_with_installment
                        ];
                    }
                }
            }
        }
        return $installments;
    }
}
