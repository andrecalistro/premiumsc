<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Client;
use Cake\Log\LogTrait;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Integrators\Controller\Component\ApiBestShippingComponent;

/**
 * Correios component
 *
 * @property \Integrators\Controller\Component\ApiBestShippingComponent $ApiBestShipping
 *
 * @property \Checkout\Model\Table\ShipmentsTable Shipments
 * @property \Checkout\Model\Table\CartsTable Carts
 */
class MelhorEnvioComponent extends Component
{
    use LogTrait;
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $Shipments;
    public $Carts;
    public $session_id;

    private $quote_data = [];
    private $error_message = [];

    private $data = [];
    public $ApiBestShipping;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setConfig('session_id', $config['session_id']);
        $this->Carts = TableRegistry::getTableLocator()->get('CheckoutV2.Carts');
        $this->Shipments = TableRegistry::getTableLocator()->get('CheckoutV2.Shipments');
        $config = (array)$this->Shipments->findConfig('melhor_envio');
        $this->setConfig((array)$this->Shipments->findConfig('melhor_envio'));
        $this->ApiBestShipping = new ApiBestShippingComponent(new ComponentRegistry(), $config);
    }

    /**
     * @param $address
     * @param null $product
     * @return array
     */
    public function getQuote($address, $product = null)
    {
        $method_data = [];
        if ($this->getConfig('status')) {

            if ($product) {
                $products[] = $product;
            } else {
                $products = $this->Carts->find('Products', ['session_id' => $this->getConfig('session_id'), 'shipping_required' => 1]);
            }
            $total = $this->prepareProducts($products);
            $this->setConfig('product_additional_days', $this->Shipments->getProductsAdditionalDays($products));
            $this->data['from']['postal_code'] = str_replace("-", "", $this->getConfig('zipcode'));
            $this->data['to']['postal_code'] = str_replace("-", "", $address['zipcode']);
            $this->data['options'] = [
                'insurance_value' => $total,
                'receipt' => false,
                'own_hand' => false,
                'collect' => false
            ];

            $this->quote_data = $this->quotation();
            if ($this->quote_data) {
                $method_data = [
                    'code' => 'melhor_envio',
                    'title' => "Melhor Envio",
                    'quote' => $this->quote_data,
                    'sort_order' => 1,
                    'error' => false
                ];
            } else {
                $method_data = [
                    'code' => 'melhor_envio',
                    'title' => "Melhor Envio",
                    'quote' => 'Não disponível para esse endereço',
                    'sort_order' => 1,
                    'error' => 'Não disponível para esse endereço'
                ];
            }
        }
        return $method_data;
    }

    /**
     * @param $products
     * @return $this
     */
    private function prepareProducts($products)
    {
        $total = 0;
        foreach ($products as $product) {
            $this->data['products'][] = [
                'id' => $product->id,
                'weight' => $product->weight * $product->quantity,
                'width' => $product->width * $product->quantity,
                'height' => $product->height * $product->quantity,
                'length' => $product->length * $product->quantity,
                'quantity' => $product->quantity,
                'insurance_value' => $product->price_format['regular']
            ];
            $total = $total + $product->price_format['regular'];
        }
        return $total;
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function quotation()
    {
        $response = $this->ApiBestShipping->calculate($this->data);
        $quotes = [];
        foreach ($response as $service) {
            if (!isset($service->error)) {
                $delivery_time = $service->delivery_time + $this->getConfig('additional_days') + $this->getConfig('product_additional_days');
                $title = ' - Entrega em até ';
                $delivery_time == 1 ? $title .= '1 dia útil' : $title .= $delivery_time . ' dias úteis';
                $service_code = Text::slug(strtolower($service->company->name . $service->name));
                $quotes[$service_code] = [
                    'code' => 'melhor_envio.' . $service_code,
                    'title' => $service->company->name . ' ' . $service->name . $title,
                    'cost' => $service->price,
                    'text' => 'R$ ' . number_format($service->price, 2, ",", "."),
                    'deadline' => $delivery_time,
                    'image' => ''
                ];
            }
        }
        return $quotes;
    }
}