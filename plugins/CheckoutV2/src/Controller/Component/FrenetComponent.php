<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\LogTrait;
use Cake\ORM\TableRegistry;

/**
 * Correios component
 *
 * @property \Checkout\Model\Table\ShipmentsTable Shipments
 * @property \Checkout\Model\Table\CartsTable Carts
 */
class FrenetComponent extends Component
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

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setConfig('session_id', $config['session_id']);
        $this->Carts = TableRegistry::getTableLocator()->get('CheckoutV2.Carts');
        $this->Shipments = TableRegistry::getTableLocator()->get('CheckoutV2.Shipments');
        foreach ($this->Shipments->findConfig('frenet') as $key => $config) {
            if (preg_match('/services_/', $key)) {
                $key = str_replace('services_', "", $key);
                $this->setConfig('services.' . $key, $key);
            } else {
                $this->setConfig($key, $config);
            }
        }
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
            $this->data['ShipmentInvoiceValue'] = 0;
            foreach ($products as $product) {
                $this->calculateDimensions($product);
            }

            $this->setConfig('product_additional_days', $this->Shipments->getProductsAdditionalDays($products));

            $this->data['RecipientCEP'] = str_replace("-", "", $address['zipcode']);
            $this->data['SellerCEP'] = str_replace("-", "", $this->getConfig('zipcode'));
            $this->data['RecipientCountry'] = 'BR';
            $this->quote_data = $this->quotation();
            if ($this->quote_data) {
                $method_data = [
                    'code' => 'frenet',
                    'title' => "Frenet",
                    'quote' => $this->quote_data,
                    'sort_order' => 1,
                    'error' => false
                ];
            } else {
                $method_data = [
                    'code' => 'frenet',
                    'title' => "Frenet",
                    'quote' => 'Não disponível para esse endereço',
                    'sort_order' => 1,
                    'error' => 'Não disponível para esse endereço'
                ];
            }
        }
        return $method_data;
    }

    /**
     * @param $product
     */
    private function calculateDimensions($product)
    {
//        $data_product['Length'] = ($product->length == 0 ? 10 : $product->length) * $product->quantity;
//        $data_product['Height'] = ($product->height == 0 ? 10 : $product->height) * $product->quantity;
//        $data_product['Width'] = ($product->width == 0 ? 10 : $product->width) * $product->quantity;
//        $data_product['Weight'] = ($product->weight == 0 ? 1 : $product->weight) * $product->quantity;
        $data_product['Length'] = $product->length;
        $data_product['Height'] = $product->height;
        $data_product['Width'] = $product->width;
        $data_product['Weight'] = $product->weight;
        if ($product->code) {
            $data_product['SKU'] = $product->code;
        }
        $data_product['Quantity'] = $product->quantity;
        $this->data['ShipmentInvoiceValue'] += $product->price_format['regular'];
        $this->data['ShippingItemArray'][] = $data_product;
    }

    /**
     * @return array|bool
     */
    private function quotation()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.frenet.com.br/shipping/quote",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($this->data),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "token: " . $this->getConfig('token')
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        }
        
        $quotes = [];
        if ($response && is_array($response->ShippingSevicesArray)) {
            foreach ($response->ShippingSevicesArray as $service) {
                if (!$service->Error) {
                    $delivery_time = $service->DeliveryTime + $this->getConfig('additional_days') + $this->getConfig('product_additional_days');
                    $title = ' - Entrega em até ';
                    $delivery_time == 1 ? $title .= '1 dia útil' : $title .= $delivery_time . ' dias úteis';

                    $quotes[$service->ServiceCode] = [
                        'code' => 'frenet.' . $service->ServiceCode,
                        'title' => $service->ServiceDescription . $title,
                        'cost' => $service->ShippingPrice,
                        'text' => 'R$ ' . number_format($service->ShippingPrice, 2, ",", "."),
                        'deadline' => $delivery_time,
                        'image' => ''
                    ];
                }
            }
        }
        return $quotes;
    }
}
