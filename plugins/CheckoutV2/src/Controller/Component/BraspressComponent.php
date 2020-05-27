<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\LogTrait;
use Cake\ORM\TableRegistry;

/**
 * Class BraspressComponent
 * @package Checkout\Controller\Component
 */
class BraspressComponent extends Component
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

    private $total_weight = 0;
    private $total_cubic_weight = 0;
    private $total_amounts = 0;
    private $total_length = 0;
    private $total_height = 0;
    private $total_width = 0;
    private $total_price = 1;

    private $ship_emporigem = 2;
    private $ship_tipofrete = 1;
    private $ship_modal = 'R';

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setConfig('session_id', $config['session_id']);
        $this->Carts = TableRegistry::getTableLocator()->get('CheckoutV2.Carts');
        $this->Shipments = TableRegistry::getTableLocator()->get('CheckoutV2.Shipments');
        foreach ($this->Shipments->findConfig('braspress') as $key => $config) {
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
            $this->setConfig('product_additional_days', $this->Shipments->getProductsAdditionalDays($products));
            foreach ($products as $product) {
                $this->calculateDimensions($product);
            }

            $this->setConfig('product_additional_days', $this->Shipments->getProductsAdditionalDays($products));

            $zipcode_destination = str_replace("-", "", $address['zipcode']);

            $document = isset($address['document']) ? $address['document'] : '49987059031';

            $this->quote_data = $this->quotation($zipcode_destination, $document);
            if ($this->quote_data) {
                $method_data = [
                    'code' => 'braspress.braspress',
                    'title' => "Transportadora Braspress",
                    'quote' => $this->quote_data,
                    'sort_order' => 2,
                    'error' => false
                ];
            } else {
                $method_data = [
                    'code' => 'braspress.braspress',
                    'title' => "Transportadora Braspress",
                    'quote' => 'Não disponível para esse endereço',
                    'sort_order' => 2,
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
        $length = $product->length / 100;
        $height = $product->height / 100;
        $width = $product->width / 100;
        $this->total_weight = $this->total_weight + ($product->weight * $product->quantity);
        $this->total_price = $this->total_price + $product->total_price;
        $this->total_amounts = $this->total_amounts + $product->quantity;
        $this->total_cubic_weight = $this->total_cubic_weight + (($length * $height * $width) * $product->quantity);
        $this->total_length = $this->total_length + $length;
        $this->total_height = $this->total_height + $height;
        $this->total_width = $this->total_width + $width;
    }

    /**
     * @param $zipcode
     * @param string $document
     * @return array|bool
     */
    private function quotation($zipcode, $document)
    {
        $params = [
            str_replace(['/', '-', '.'], '', $this->getConfig('cnpj')),
            $this->ship_emporigem,
            str_replace(['/', '-', '.'], '', $this->getConfig('zipcode')),
            str_replace(['/', '-', '.'], '', $zipcode),
            str_replace(['/', '-', '.'], '', $this->getConfig('cnpj')),
            $document,
            $this->ship_tipofrete,
            $this->total_weight,
            $this->total_price,
            $this->total_amounts,
            $this->ship_modal
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.braspress.com.br/cotacaoXml?param=" . implode(',', $params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $data = false;
        } else {
            if (!preg_match('/calculofrete/', $response)) {
                $response = new \SimpleXMLElement($response);
                $success = $response->MSGERRO->__toString();
                if ($success == 'OK') {
                    $value = floatval(str_replace(',', '.', $response->TOTALFRETE->__toString()));
                    $start = intval($response->PRAZO->__toString());
                    $end = $start + $this->getConfig('additional_days') + $this->getConfig('product_additional_days');
                    if ($start > 0) {
                        $title = ' - Entrega de ' . $start . ' a ' . $end . ' dias úteis';
                    } else {
                        $title = '';
                    }

                    $data[] = [
                        'code' => 'Braspress.Braspress',
                        'title' => 'Braspress' . $title,
                        'cost' => $value,
                        'text' => 'R$ ' . number_format($value, 2, ",", "."),
                        'deadline' => $end,
                        'image' => ''
                    ];
                } else {
                    $data = false;
                }
            } else {
                $data = false;
            }
        }
        return $data;
    }
}