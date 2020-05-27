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
class FreeShippingComponent extends Component
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

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setConfig('session_id', $config['session_id']);
        $this->Carts = TableRegistry::getTableLocator()->get('CheckoutV2.Carts');
        $this->Shipments = TableRegistry::getTableLocator()->get('CheckoutV2.Shipments');
        foreach ($this->Shipments->findConfig('free_shipping') as $key => $config) {
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
                $subtotal = $product->price_format['regular'];
                $products[] = $product;
            } else {
                $subtotal = $this->Carts->find('subTotal', ['session_id' => $this->getConfig('session_id')]);
                $subtotal = $subtotal->subtotal;
                $products = $this->Carts->find('Products', ['session_id' => $this->getConfig('session_id'), 'shipping_required' => 1]);
            }

            $this->setConfig('product_additional_days', $this->Shipments->getProductsAdditionalDays($products));
            $zipcode = str_replace("-", "", $address['zipcode']);

            $intervals = $this->getConfig('interval');

            if ($intervals) {
                $shipment = [];
                foreach ($intervals as $key => $interval) {
                    $zipcode1 = str_replace('-', '', trim($interval[0]));
                    $zipcode2 = str_replace('-', '', trim($interval[1]));

                    if (isset($interval[3])) {
                        $min_order_value = str_replace(',', '.', str_replace(".", "", $interval[3]));
                    } else {
                        $min_order_value = 0;
                    }

                    is_numeric($interval[2]) ? $days = $interval[2] : $days = 0;
                    $days += $this->getConfig('product_additional_days');

                    if ($days > 0) {
                        $title = ' - Entrega em até ';
                        $days == 1 ? $title .= '1 dia útil' : $title .= $days . ' dias úteis';
                    } else {
                        $title = '';
                    }

                    if ($zipcode >= $zipcode1 && $zipcode <= $zipcode2 && $subtotal >= $min_order_value) {
                        if (empty($shipment) || (isset($shipment['deadline']) && $interval[2] < $shipment['deadline'])) {
                            $shipment['free_shipping'] = [
                                'code' => 'free_shipping.frete_gratis',
                                'title' => 'Frete Grátis' . $title,
                                'cost' => 0.00,
                                'text' => 'Grátis',
                                'deadline' => $days,
                                'image' => ''
                            ];
                        }
                    }
                }
                if ($shipment) {
                    $method_data = [
                        'code' => 'free_shipping.frete_gratis',
                        'title' => 'Frete Grátis',
                        'quote' => $shipment,
                        'sort_order' => 1,
                        'error' => ''
                    ];
                } else {
                    $method_data = [
                        'code' => 'free_shipping.frete_gratis',
                        'title' => 'Frete Grátis',
                        'quote' => 'Não disponível para esse endereço',
                        'sort_order' => 1,
                        'error' => 'Não disponível para esse endereço'
                    ];
                }
            } else {
                $method_data = [
                    'code' => 'free_shipping.frete_gratis',
                    'title' => 'Frete Grátis',
                    'quote' => 'Não disponível para esse endereço',
                    'sort_order' => 1,
                    'error' => 'Não disponível para esse endereço'
                ];
            }
        }
        return $method_data;
    }
}