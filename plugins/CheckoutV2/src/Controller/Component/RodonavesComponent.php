<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\LogTrait;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use DOMDocument;

/**
 * Correios component
 *
 * @property \Checkout\Model\Table\ShipmentsTable Shipments
 * @property \Checkout\Model\Table\CartsTable Carts
 */
class RodonavesComponent extends Component
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

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setConfig('session_id', $config['session_id']);
        $this->Carts = TableRegistry::getTableLocator()->get('CheckoutV2.Carts');
        $this->Shipments = TableRegistry::getTableLocator()->get('CheckoutV2.Shipments');
        foreach ($this->Shipments->findConfig('rodonaves') as $key => $config) {
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

            $zipcode_destination = str_replace("-", "", $address['zipcode']);

            $this->quote_data = $this->quotation($zipcode_destination);
            if ($this->quote_data) {
                $method_data = [
                    'code' => 'rodonaves',
                    'title' => "Transportadora",
                    'quote' => $this->quote_data,
                    'sort_order' => 1,
                    'error' => false
                ];
            } else {
                $method_data = [
                    'code' => 'rodonaves',
                    'title' => "Transportadora",
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
     * @return array|bool
     */
    private function quotation($zipcode)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "9090",
            CURLOPT_URL => "http://200.210.75.4:9090/ecommerce/wsquotation.asmx?WSDL=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\n  <soap:Body>\n    <EcommerceOnlineQuotation xmlns=\"http://tempuri.org/\">\n      <quotationWebserviceInputInfo>\n        <CustomerRecipientTaxIdRegistration>" . $this->getConfig('user') . "</CustomerRecipientTaxIdRegistration>\n        <CEPPickup>" . $this->getConfig('zipcode') . "</CEPPickup>\n        <CEPDelivery>" . $zipcode . "</CEPDelivery>\n        <OperationType>0</OperationType>\n        <NCM>1</NCM>\n        <Packing>1</Packing>\n        <CFOP>5102</CFOP>\n        <ContactName>Teste</ContactName>\n        <ContactDDDPhoneCommercial>41</ContactDDDPhoneCommercial>\n        <ContactPhoneCommercial>988556699</ContactPhoneCommercial>\n        <InvoiceValue>" . $this->total_price . "</InvoiceValue>\n        <AmountPackages>" . $this->total_amounts . "</AmountPackages>\n        <TotalFiscalDocumentWeight>" . $this->total_weight . "</TotalFiscalDocumentWeight>\n        <TotalBaseWeight>" . $this->total_weight . "</TotalBaseWeight>\n        <TotalCubicWeight>" . $this->total_cubic_weight . "</TotalCubicWeight>\n        <TotalRealWeight>" . $this->total_weight . "</TotalRealWeight>\n        <Amounts>" . $this->total_amounts . "</Amounts>\n        <Weight>" . $this->total_weight . "</Weight>\n        <Lenght>" . $this->total_length . "</Lenght>\n        <Height>" . $this->total_height . "</Height>\n        <Widht>" . $this->total_width . "</Widht>\n      </quotationWebserviceInputInfo>\n      <user>" . $this->getConfig('user') . "</user>\n      <passwordSend>" . $this->getConfig('password') . "</passwordSend>\n    </EcommerceOnlineQuotation>\n  </soap:Body>\n</soap:Envelope>",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: text/xml",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $data = false;
        } else {
            $response = new \SimpleXMLElement(str_replace(["</soap:Body>", "<soap:Body>"], "", $response));
            $success = $response->EcommerceOnlineQuotationResponse->EcommerceOnlineQuotationResult->Success->__toString();
            $days = $this->getConfig('additional_days') + $this->getConfig('product_additional_days');
            if ($days > 0) {
                $title = ' - Entrega em até ';
                $days == 1 ? $title .= '1 dia útil' : $title .= $days . ' dias úteis';
            } else {
                $title = '';
            }
            if ($success == 'true') {
                $value = $response->EcommerceOnlineQuotationResponse->EcommerceOnlineQuotationResult->Value->__toString();
                $data[] = [
                    'code' => 'Transportadora',
                    'title' => 'Transportadora' . $title,
                    'cost' => $value,
                    'text' => 'R$ ' . number_format($value, 2, ",", "."),
                    'deadline' => $days,
                    'image' => ''
                ];
            } else {
                $data = false;
            }
        }
        return $data;
    }
}