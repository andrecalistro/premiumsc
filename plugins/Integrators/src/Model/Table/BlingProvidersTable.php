<?php

namespace Integrators\Model\Table;

use Admin\Model\Table\AppTable;
use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Integrators\Model\BlingTrait;

/**
 * BlingProviders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Providers
 *
 * @method \Integrators\Model\Entity\BlingProvider get($primaryKey, $options = [])
 * @method \Integrators\Model\Entity\BlingProvider newEntity($data = null, array $options = [])
 * @method \Integrators\Model\Entity\BlingProvider[] newEntities(array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingProvider|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Integrators\Model\Entity\BlingProvider patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingProvider[] patchEntities($entities, array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingProvider findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BlingProvidersTable extends AppTable
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

        $this->setTable('bling_providers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Providers', [
            'foreignKey' => 'providers_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Providers'
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
            ->notEmpty('providers_id', __("Por favor, selecione um fornecedor"));

        $validator
            ->allowEmpty('bling_id');

        $validator
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
        $rules->add($rules->existsIn(['providers_id'], 'Providers'));

        return $rules;
    }

    /**
     * @param $providers_id
     * @return mixed
     */
    public function getProvider($providers_id)
    {
        $provider = $this->Providers->get($providers_id);

        if (empty($provider->document)) {
            return (object)['status' => false];
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $this->url . 'contato/' . $provider->document . '/json?apikey=' . $this->apiKey);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $this->formatResponse($response);
    }

    /**
     * @param $providers_id
     * @return array|mixed|object
     */
    public function postProvider($providers_id)
    {
        $provider = $this->Providers->get($providers_id);

        $provider_bling = $this->getProvider($providers_id);

        if ($provider_bling->status) {
            $url = $this->url . 'contato/' . $provider_bling->data->contatos[0]->contato->id . '/json';
            $curl_request = 'PUT';
        } else {
            $url = $this->url . 'contato/json';
            $curl_request = 'POST';
        }

        $provider_data = [
            'nome' => $provider->name,
            'tipoPessoa' => strlen($provider->document) > 11 ? 'J' : 'F',
            'contribuinte' => 9,
            'cpf_cnpj' => $provider->document,
            'endereco' => $provider->address,
            'numero' => $provider->number,
            'complemento' => $provider->complement,
            'bairro' => $provider->neighborhood,
            'cep' => $provider->zipcode,
            'cidade' => $provider->city,
            'uf' => $provider->state,
            'celular' => $provider->telephone,
            'email' => $provider->email,
            'tipos_contatos' => [
                'tipo_contato' => [
                    'descricao' => 'Fornecedor'
                ]
            ]
        ];

        $xml = $this->buildXml($provider_data, 'contato');
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
            ->where(['providers_id' => $providers_id])
            ->first();

        if ($entity) {
            $entity = $this->patchEntity($entity, ['status' => $status, 'bling_id' => $bling_id]);
        } else {
            $entity = $this->newEntity(['status' => $status, 'bling_id' => $bling_id, 'providers_id' => $providers_id]);
        }

        $this->save($entity);

        return $response;
    }

}
