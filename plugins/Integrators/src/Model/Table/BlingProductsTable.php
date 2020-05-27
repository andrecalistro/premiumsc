<?php

namespace Integrators\Model\Table;

use Admin\Model\Table\AppTable;
use Admin\Model\Table\StoresTable;
use Cake\I18n\Time;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Integrators\Model\BlingTrait;

/**
 * BlingProducts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Products
 *
 * @method \Integrators\Model\Entity\BlingProduct get($primaryKey, $options = [])
 * @method \Integrators\Model\Entity\BlingProduct newEntity($data = null, array $options = [])
 * @method \Integrators\Model\Entity\BlingProduct[] newEntities(array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingProduct|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Integrators\Model\Entity\BlingProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingProduct[] patchEntities($entities, array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingProduct findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BlingProductsTable extends AppTable
{
    use BlingTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @var StoresTable $Stores
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

        $this->setTable('bling_products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
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
        $rules->add($rules->existsIn(['products_id'], 'Products'));

        return $rules;
    }

    /**
     * @param $products_id
     * @return array|object
     */
    public function getProduct($products_id)
    {
        $product = $this->Products->get($products_id);

        if (empty($product->code)) {
            return (object)['status' => false];
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $this->url . 'produto/' . $product->code . '/json?apikey=' . $this->apiKey);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $this->formatResponse($response);
    }

    /**
     * @param $products_id
     * @return array|mixed|object
     */
    public function postProduct($products_id)
    {
        $product = $this->Products->get($products_id, [
            'contain' => [
                'Filters' => function ($q) {
                    return $q->contain(['FiltersGroups']);
                }
            ]
        ]);

        $product_bling = $this->getProduct($products_id);

        if ($product_bling->status) {
            $url = $this->url . 'produto/' . $product_bling->data->produtos[0]->produto->codigo . '/json';
        } else {
            $url = $this->url . 'produto/json';
        }

        $product_data = [
            'codigo' => $product->code,
            'descricao' => $product->name,
            'descricaoCurta' => $product->resume,
            'descricaoComplementar' => $product->description,
            'un' => 'un',
            'vlr_unit' => $product->price,
            'preco_custo' => $product->price,
            'peso_bruto' => $product->weight,
            'peso_liq' => $product->weight,
            'origem' => 0,
            'largura' => $product->width,
            'altura' => $product->height,
            'profundidade' => $product->lentgth,
            'estoqueMinimo' => 0.00,
            'estoque' => $product->stock
        ];

//        if (isset($product->filters)) {
//            foreach ($product->filters as $filter) {
//                $product_data['variacoes'][] = [
//                    'variacao' => [
//                        'nome' => $filter->filters_group->name . ':' . $filter->name
//                    ]
//                ];
//            }
//        }

        $xml = $this->buildXml($product_data, 'produto');
        $data = [
            "apikey" => $this->apiKey,
            "xml" => rawurlencode($xml)
        ];

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_POST, count($data));
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'POST');
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);

        $response = $this->formatResponse($response);

        if ($response->status) {
            $status = 'Sincronizado em: ' . Time::now()->format('d/m/Y H:i:s');
            $bling_id = $response->data->produtos[0][0]->produto->codigo;
        } else {
            $status = 'Não sincronizado em: ' . Time::now()->format('d/m/Y H:i:s') . '<br>Motivo: ' . $response->message;
            $bling_id = '';
        }

        $entity = $this->find()
            ->where(['products_id' => $products_id])
            ->first();

        if ($entity) {
            $entity = $this->patchEntity($entity, ['status' => $status, 'bling_id' => $bling_id]);
        } else {
            $entity = $this->newEntity(['status' => $status, 'bling_id' => $bling_id, 'products_id' => $products_id]);
        }

        $this->save($entity);

        return $response;
    }

    public function deleteProduct($code)
    {
        $url = $this->url . 'produto/' . $code . '/json';
        $data = [
            "apikey" => $this->apiKey
        ];

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $this->formatResponse($response);
    }
}
