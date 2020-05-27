<?php

namespace Integrators\Model\Table;

use Admin\Model\Table\AppTable;
use Cake\I18n\Time;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Integrators\Model\BlingTrait;

/**
 * BlingCustomers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \Integrators\Model\Entity\BlingCustomer get($primaryKey, $options = [])
 * @method \Integrators\Model\Entity\BlingCustomer newEntity($data = null, array $options = [])
 * @method \Integrators\Model\Entity\BlingCustomer[] newEntities(array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingCustomer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Integrators\Model\Entity\BlingCustomer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingCustomer[] patchEntities($entities, array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingCustomer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BlingCustomersTable extends AppTable
{
    use BlingTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        if (isset($config['api_key'])) {
            $this->apiKey = $config['api_key'];
        } else {
            $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
            $config = $Stores->findConfig('bling');
            $this->apiKey = isset($config->api_key) ? $config->api_key : null;
        }

        $this->setTable('bling_customers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customers_id',
            'className' => 'Admin.Customers'
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
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['customers_id'], 'Customers'));

        return $rules;
    }

    /**
     * @param $customers_id
     * @return array|object
     */
    public function getCustomer($customers_id)
    {
        $customer = $this->Customers->get($customers_id);

        if (empty($customer->document_clean)) {
            return (object)['status' => false];
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $this->url . 'contato/' . $customer->document_clean . '/json?apikey=' . $this->apiKey);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $this->formatResponse($response);
    }

    /**
     * @param $customers_id
     * @return array|mixed|object
     */
    public function postCustomer($customers_id)
    {
        $customer = $this->Customers->get($customers_id, [
            'contain' => [
                'CustomersAddresses'
            ]
        ]);

        $customer_bling = $this->getCustomer($customers_id);

        if ($customer_bling->status) {
            $url = $this->url . 'contato/' . $customer->document_clean . '/json';
            $curl_request = 'PUT';
        } else {
            $url = $this->url . 'contato/json';
            $curl_request = 'POST';
        }

        $customer_data = [
            'nome' => $customer->name,
            'tipoPessoa' => strlen($customer->document_clean) > 11 ? 'J' : 'F',
            'contribuinte' => 9,
            'cpf_cnpj' => $customer->document_clean,
            'fone' => $customer->telephone,
            'celular' => $customer->cellphone,
            'email' => $customer->email,
            'tipos_contatos' => [
                'tipo_contato' => [
                    'descricao' => 'Cliente'
                ]
            ]
        ];

        if ($customer->customers_addresses) {
            $address_data = [
                'endereco' => $customer->customers_addresses[0]->address,
                'numero' => $customer->customers_addresses[0]->number,
                'complemento' => $customer->customers_addresses[0]->complement,
                'bairro' => $customer->customers_addresses[0]->neighborhood,
                'cep' => $customer->customers_addresses[0]->zipcode,
                'cidade' => $customer->customers_addresses[0]->city,
                'uf' => $customer->customers_addresses[0]->state,
            ];
            $customer_data = array_merge($customer_data, $address_data);
        }

        $xml = $this->buildXml($customer_data, 'contato');
        $data = array(
            "apikey" => $this->apiKey,
            "xml" => rawurlencode($xml)
        );

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_POST, count($data));
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, $curl_request);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);

        $response = $this->formatResponse($response);

        if ($response->status) {
            $status = 'Sincronizado em: ' . Time::now()->format('d/m/Y H:i:s');
            $bling_id = $response->data->contatos->contato->id;
        } else {
            $status = 'Não sincronizado em: ' . Time::now()->format('d/m/Y H:i:s') . '<br>Motivo: ' . $response->message;
            $bling_id = '';
        }

        $entity = $this->find()
            ->where(['customers_id' => $customers_id])
            ->first();

        if ($entity) {
            $entity = $this->patchEntity($entity, ['status' => $status, 'bling_id' => $bling_id]);
        } else {
            $entity = $this->newEntity(['status' => $status, 'bling_id' => $bling_id, 'customers_id' => $customers_id]);
        }

        $this->save($entity);

        return $response;
    }
}
