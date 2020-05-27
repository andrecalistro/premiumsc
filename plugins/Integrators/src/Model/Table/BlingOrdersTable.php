<?php

namespace Integrators\Model\Table;

use Admin\Model\Table\AppTable;
use Admin\Model\Table\OrdersTable;
use Cake\I18n\Time;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Integrators\Model\BlingTrait;

/**
 * BlingOrders Model
 *
 * @property OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 *
 * @method \Integrators\Model\Entity\BlingOrder get($primaryKey, $options = [])
 * @method \Integrators\Model\Entity\BlingOrder newEntity($data = null, array $options = [])
 * @method \Integrators\Model\Entity\BlingOrder[] newEntities(array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingOrder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Integrators\Model\Entity\BlingOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \Integrators\Model\Entity\BlingOrder findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BlingOrdersTable extends AppTable
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

        $this->setTable('bling_orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'orders_id',
            'className' => 'Admin.Orders'
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
            ->integer('bling_order')
            ->allowEmpty('bling_order');

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
        $rules->add($rules->existsIn(['orders_id'], 'Orders'));

        return $rules;
    }

    /**
     * @param $orders_id
     * @return array|object
     */
    public function getOrder($orders_id)
    {
        $order = $this->Orders->get($orders_id);

        if (!$order) {
            return (object)['status' => false];
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $this->url . 'pedido/' . $order->id . '/json?apikey=' . $this->apiKey);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $this->formatResponse($response);
    }

    /**
     * @param $orders_id
     * @return array|mixed|object
     */
    public function postOrder($orders_id)
    {
        $order = $this->Orders->get($orders_id, [
            'contain' => [
                'OrdersProducts',
                'Customers'
            ]
        ]);
        $order_bling = $this->getOrder($orders_id);

        if ($order_bling->status) {
            //$url = $this->url . 'pedido/' . $order_bling->data->produtos[0]->produto->codigo . '/json';
            return (object)['status' => true];
        } else {
            $url = $this->url . 'pedido/json';
        }

        $order_data = [
            'cliente' => [
                'nome' => $order->customer->name,
                'tipoPessoa' => 'F',
                'endereco' => $order->address,
                'cpf_cnpj' => $order->customer->document_clean,
                'numero' => $order->number,
                'complemento' => $order->complement,
                'bairro' => $order->neighborhood,
                'cep' => $order->zipcode,
                'cidade' => $order->city,
                'uf' => $order->state,
                'fone' => $order->customer->telephone,
                'email' => $order->customer->email
            ],
            'transporte' => [
                'transportadora' => $order->shipping_text,
                'tipo_frete' => 'R',
                'servico_correios' => $order->shipping_text,
                'dados_etiqueta' => [
                    'nome' => 'Endereço de entrega',
                    'endereco' => $order->address,
                    'numero' => $order->number,
                    'complemento' => $order->complement,
                    'municipio' => $order->city,
                    'uf' => $order->state,
                    'cep' => $order->zipcode,
                    'bairro' => $order->neighborhood
                ]
            ],
            'vlr_frete' => $order->shipping_total,
            'parcelas' => [
                'parcela' => [
                    'data' => $order->modified->format('d/m/Y'),
                    'vlr' => $order->total
                ]
            ],
            'situacao' => ''
        ];

        foreach ($order->orders_products as $product) {
            $order_data['itens'][]['item'] = [
                'codigo' => $product->products_id,
                'descricao' => $product->name,
                'un' => 'un',
                'qtde' => $product->quantity,
                'vlr_unit' => $product->price
            ];
        }

        $xml = $this->buildXml($order_data, 'pedido');
        $data = [
            "apikey" => $this->apiKey,
            "xml" => rawurlencode($xml),
            'gerarnfe' => true
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
            $bling_id = $response->data->pedidos[0]->pedido->numero;
            $bling_order = $response->data->pedidos[0]->pedido->idPedido;
        } else {
            $status = 'Não sincronizado em: ' . Time::now()->format('d/m/Y H:i:s') . '<br>Motivo: ' . $response->message;
            $bling_id = '';
            $bling_order = '';
        }

        $entity = $this->find()
            ->where(['orders_id' => $orders_id])
            ->first();

        if ($entity) {
            $entity = $this->patchEntity($entity, ['status' => $status, 'bling_id' => $bling_id]);
        } else {
            $entity = $this->newEntity(['status' => $status, 'bling_id' => $bling_id, 'orders_id' => $orders_id, 'bling_order' => $bling_order]);
        }

        $this->save($entity);

        return $response;
    }
}
