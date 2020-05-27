<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Checkout\Model\Table\PaymentsTable;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\CreditCard;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\Request\CieloError;
use Cielo\API30\Ecommerce\Request\CieloRequestException;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Merchant;

/**
 * Class CieloComponent
 * @package App\Controller\Component
 *
 * @property \Checkout\Model\Table\PaymentsTable $Payments
 * @property \Checkout\Controller\Component\OrderComponent $Order
 */
class CieloComponent extends Component
{
    public $Payments;
    public $components = ['Order'];
    public $payment_config;

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');

        foreach ($this->Payments->findConfig('cielo_credit_card') as $key => $value) {
            $this->setConfig($key, $value);
        }

        if ($this->getConfig('environment') == 'sandbox') {
            $this->setConfig('environment_type', Environment::sandbox());
        } else {
            $this->setConfig('environment_type', Environment::production());
        }

        $this->setConfig('merchant', new Merchant($this->getConfig('merchant_id'), $this->getConfig('merchant_key')));

        $this->payment_config = $config['payment_config'];
    }

    /**
     * @param $orders_id
     * @return bool
     */
    public function ticket($orders_id)
    {
        $order = $this->Order->getOrder($orders_id);

        $sale = new Sale($orders_id);

        $sale->customer($order->customer->name)
            ->setIdentity($order->customer->document_clean)
            ->setIdentityType('CPF')
            ->address()
            ->setZipCode($order->zipcode)
            ->setCountry('BRA')
            ->setState($order->state)
            ->setCity($order->city)
            ->setDistrict($order->neighborhood)
            ->setStreet($order->address)
            ->setNumber($order->number);

        $total = $order->total;
        $discount = 0;
        $discount_percent = 0;
        $total_without_discount = $order->total;

        //aplica desconto se tiver
        if (isset($this->payment_config->ticket_discount) && is_numeric($this->payment_config->ticket_discount) && $this->payment_config->ticket_discount > 0) {
            $discount = (($this->payment_config->ticket_discount / 100) * $total);
            $total = $total - $discount;
            $total_without_discount = $order->total;
            $discount_percent = $this->payment_config->ticket_discount;
        }

        $total_ticket = number_format($total, 2, "", "");

        $sale->payment($total_ticket)
            ->setType(Payment::PAYMENTTYPE_BOLETO)
            ->setAddress($this->getConfig('address'))
//            ->setBoletoNumber('1234')
            ->setAssignor($this->getConfig('assignor'))
            ->setDemonstrative($this->getConfig('demonstrative'))
            ->setExpirationDate(date('d/m/Y', strtotime('+' . $this->getConfig('expiration_date') . ' days')))
            ->setIdentification($orders_id)
            ->setInstructions($this->getConfig('instructions'));

        try {
            $sale = (new CieloEcommerce($this->getConfig('merchant'), $this->getConfig('environment_type')))->createSale($sale);

            $this->Order->update([
                'payment_id' => $sale->getPayment()->getPaymentId(),
                'payment_url' => $sale->getPayment()->getUrl(),
                'payment_method' => 'ticket',
                'total' => $total,
                'discount' => $discount,
                'discount_percent' => $discount_percent,
                'total_without_discount' => $total_without_discount

            ], $orders_id);

            $this->Order->addHistory($orders_id, $this->getConfig('status_waiting_payment'), 'Boleto gerado<br><a href="' . $sale->getPayment()->getUrl() . '" target="_blank">Clique aqui para emitir a 2ª via</a>');

            return true;
        } catch (CieloRequestException $e) {
            Log::write('error', $e->getCieloError());
            return false;
        }
    }

    /**
     * @param $orders_id
     * @param $data
     * @return bool
     */
    public function creditCard($orders_id, $data, $store)
    {
        $order = $this->Order->getOrder($orders_id);
        $installments = $this->Payments->installments($this->payment_config, $order->total);
        $total = number_format($installments[$data['installment']]['regular'] * $data['installment'], 2, "", "");
        $items = [];

        foreach ($order->orders_products as $product) {
            $items[] = [
                "GiftCategory" => "Undefined",
                "HostHedge" => "Off",
                "NonSensicalHedge" => "Off",
                "ObscenitiesHedge" => "Off",
                "PhoneHedge" => "Off",
                "Name" => $product->name,
                "Quantity" => $product->quantity,
                "Sku" => $product->code,
                "UnitPrice" => number_format($product->price, 2, "", ""),
//                "Risk" => "High",
//                "TimeHedge" => "Normal",
//                "Type" => "All",
//                "VelocityHedge" => "High",
//                                "Passenger" => [
//                                    "Email" => "compradorteste@live.com",
//                                    "Identity" => "1234567890",
//                                    "Name" => "Comprador accept",
//                                    "Rating" => "Adult",
//                                    "Phone" => "999994444",
//                                    "Status" => "Accepted"
//                                ]
            ];
        }

        $sale = [
            "MerchantOrderId" => $order->id,
            "Customer" => [
                "Name" => $order->customer->name,
                "Email" => $order->email,
                "Birthdate" => $order->customer->birth_date->format("Y-m-d"),
                "Address" => [
                    "Street" => $order->address,
                    "Number" => $order->number,
                    "Complement" => $order->complement,
                    "ZipCode" => preg_replace('/\D/', '', $order->zipcode),
                    "City" => $order->city,
                    "State" => $order->state,
                    "Country" => "BRA"
                ],
                "DeliveryAddress" => [
                    "Street" => $order->address,
                    "Number" => $order->number,
                    "Complement" => $order->complement,
                    "ZipCode" => preg_replace('/\D/', '', $order->zipcode),
                    "City" => $order->city,
                    "State" => $order->state,
                    "Country" => "BRA"
                ]
            ],
            "Payment" => [
                "Type" => "CreditCard",
                "Amount" => $total,
                "Currency" => "BRL",
                "Country" => "BRA",
                "ServiceTaxAmount" => 0,
                "Installments" => $data['installment'],
                "SoftDescriptor" => Text::slug($store->name, ['replacement' => '']),
                "Interest" => "ByMerchant",
                "Capture" => false,
                "Authenticate" => false,
                "CreditCard" => [
                    "CardNumber" => preg_replace('/\D/', '', $data['card_number']),
                    "Holder" => $data['card_name'],
                    "ExpirationDate" => $data['expiry_month'] . "/" . $data['expiry_year'],
                    "SecurityCode" => $data['cvc'],
                    "Brand" => $this->getBrand($data['card_type'])
                ],
                "FraudAnalysis" => [
                    "Sequence" => "AuthorizeFirst",
                    "SequenceCriteria" => "OnSuccess",
//                    "FingerPrintId" => "074c1ee676ed4998ab66491013c565e2",
                    "Browser" => [
                        "CookiesAccepted" => false,
                        "Email" => $order->customer->email,
//                        "HostName" => "Teste",
                        "IpAddress" => $order->ip,
                        "Type" => $this->request->getEnv('HTTP_USER_AGENT')
                    ],
                    "Cart" => [
                        "IsGift" => false,
                        "ReturnsAccepted" => true,
                        "Items" => $items
                    ],
//                    "MerchantDefinedFields" => [
//                        [
//                            "Id" => 95,
//                            "Value" => "Eu defini isso"
//                        ]
//                    ],
                    "Shipping" => [
                        "Addressee" => $order->customer->name,
                        "Method" => 'LowCost',
                        "Phone" => preg_replace('/\D/', '', $order->customer->telephone)
                    ],
//                    "Travel" => [
//                        "DepartureTime" => "2010-01-02",
//                        "JourneyType" => "Ida",
//                        "Route" => "MAO-RJO",
//                        "Legs" => [
//                            [
//                                "Destination" => "GYN",
//                                "Origin" => "VCP"
//                            ]
//                        ]
//                    ]
                ]
            ]
        ];

        try {
            $sale = $this->createSale($sale);

            $paymentId = $sale->Payment->PaymentId;

            $sale = $this->captureSale($paymentId, $total, 0);

            if ($sale->Status == 2) {
                $this->Order->update([
                    'payment_id' => $paymentId,
                    'payment_method' => 'cielo_credit_card',
                    'total_without_discount' => $installments[$data['installment']]['regular'] * $data['installment'],
                    'payment_brand' => $data['card_type'],
                    'payment_installment' => $data['installment'],
                    'payment_card_number' => substr($data['card_number'], -4),
                    'payment_name' => $data['card_name'],
                    'payment_document' => $order->customer->document,
//                    'payment_birth_date' => Date::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d'),
                    'payment_installment_value' => $installments[$data['installment']]['regular'],
                    'orders_statuses_id' => 1
                ], $orders_id);

                $this->Order->addHistory($orders_id, $this->getConfig('status_approved_payment'));

                return true;
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::write('alert', $error, ['escope' => 'cielo']);
            return false;
        }
    }

    /**
     * @param $orders_id
     * @param $data
     * @param $store
     * @return bool
     */
    public function debitCard($orders_id, $data, $store)
    {
        $order = $this->Order->getOrder($orders_id);
        $total = number_format($order->total, 2, "", "");
        $items = [];

        foreach ($order->orders_products as $product) {
            $items[] = [
                "GiftCategory" => "Undefined",
                "HostHedge" => "Off",
                "NonSensicalHedge" => "Off",
                "ObscenitiesHedge" => "Off",
                "PhoneHedge" => "Off",
                "Name" => $product->name,
                "Quantity" => $product->quantity,
                "Sku" => $product->code,
                "UnitPrice" => number_format($product->price, 2, "", ""),
//                "Risk" => "High",
//                "TimeHedge" => "Normal",
//                "Type" => "All",
//                "VelocityHedge" => "High",
//                                "Passenger" => [
//                                    "Email" => "compradorteste@live.com",
//                                    "Identity" => "1234567890",
//                                    "Name" => "Comprador accept",
//                                    "Rating" => "Adult",
//                                    "Phone" => "999994444",
//                                    "Status" => "Accepted"
//                                ]
            ];
        }

        $sale = [
            "MerchantOrderId" => $order->id,
            "Customer" => [
                "Name" => $order->customer->name,
                "Email" => $order->email,
                "Birthdate" => $order->customer->birth_date->format("Y-m-d"),
                "Address" => [
                    "Street" => $order->address,
                    "Number" => $order->number,
                    "Complement" => $order->complement,
                    "ZipCode" => preg_replace('/\D/', '', $order->zipcode),
                    "City" => $order->city,
                    "State" => $order->state,
                    "Country" => "BRA"
                ],
                "DeliveryAddress" => [
                    "Street" => $order->address,
                    "Number" => $order->number,
                    "Complement" => $order->complement,
                    "ZipCode" => preg_replace('/\D/', '', $order->zipcode),
                    "City" => $order->city,
                    "State" => $order->state,
                    "Country" => "BRA"
                ]
            ],
            "Payment" => [
                "Type" => "DebitCard",
                "Amount" => $total,
                "ReturnUrl" => Router::url(['plugin' => 'CheckoutV2', 'controller' => 'cielo-debit-card', 'action' => 'process-return', $this->request->getSession()->read('orders_id')], true),
                "Currency" => "BRL",
                "Country" => "BRA",
                "SoftDescriptor" => Text::slug($store->name, ['replacement' => '']),
                "Interest" => "ByMerchant",
//                "Capture" => true,
                "Authenticate" => true,
                "DebitCard" => [
                    "CardNumber" => preg_replace('/\D/', '', $data['card_number']),
                    "Holder" => $data['card_name'],
                    "ExpirationDate" => $data['expiry_month'] . "/" . $data['expiry_year'],
                    "SecurityCode" => $data['cvc'],
                    "Brand" => $this->getBrand($data['card_type'])
                ],
                "FraudAnalysis" => [
                    "Sequence" => "AuthorizeFirst",
                    "SequenceCriteria" => "OnSuccess",
//                    "FingerPrintId" => "074c1ee676ed4998ab66491013c565e2",
                    "Browser" => [
                        "CookiesAccepted" => false,
                        "Email" => $order->customer->email,
//                        "HostName" => "Teste",
                        "IpAddress" => $order->ip,
                        "Type" => $this->request->getEnv('HTTP_USER_AGENT')
                    ],
                    "Cart" => [
                        "IsGift" => false,
                        "ReturnsAccepted" => true,
                        "Items" => $items
                    ],
//                    "MerchantDefinedFields" => [
//                        [
//                            "Id" => 95,
//                            "Value" => "Eu defini isso"
//                        ]
//                    ],
                    "Shipping" => [
                        "Addressee" => $order->customer->name,
                        "Method" => 'LowCost',
                        "Phone" => preg_replace('/\D/', '', $order->customer->telephone)
                    ],
//                    "Travel" => [
//                        "DepartureTime" => "2010-01-02",
//                        "JourneyType" => "Ida",
//                        "Route" => "MAO-RJO",
//                        "Legs" => [
//                            [
//                                "Destination" => "GYN",
//                                "Origin" => "VCP"
//                            ]
//                        ]
//                    ]
                ]
            ]
        ];

        try {
            $sale = $this->createSale($sale);
            if ($sale->Payment->AuthenticationUrl) {
                $this->Order->update([
                    'payment_id' => $sale->Payment->PaymentId,
                    'payment_method' => 'cielo_debito_card',
                    'payment_brand' => $data['card_type'],
                    'payment_card_number' => substr($data['card_number'], -4),
                    'payment_name' => $data['card_name'],
                    'payment_document' => $order->customer->document
                ], $orders_id);

                return $sale->Payment->AuthenticationUrl;
            }
            return false;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            dd($e);
            Log::write('alert', $error, ['escope' => 'cielo']);
            return false;
        }
    }

    /**
     * @param $orders_id
     * @param $data
     * @return bool
     */
    public function onlineDebit($orders_id, $data)
    {
        $order = $this->Order->getOrder($orders_id);

        $sale = new Sale($orders_id);

        $sale->customer($order->customer->name);

        $total = $order->total;
        $discount = 0;
        $discount_percent = 0;
        $total_without_discount = $order->total;

        //aplica desconto se tiver
        if (isset($this->payment_config->ticket_discount) && is_numeric($this->payment_config->ticket_discount) && $this->payment_config->ticket_discount > 0) {
            $discount = (($this->payment_config->ticket_discount / 100) * $total);
            $total = $total - $discount;
            $total_without_discount = $order->total;
            $discount_percent = $this->payment_config->ticket_discount;
        }

        $total_debit = number_format($total, 2, "", "");

        $payment = $sale->payment($total_debit);

        $payment->setReturnUrl(Router::url(['controller' => 'checkout', 'action' => 'success', $this->getController()->request->getSession()->read('orders_id')], true));

        $payment->debitCard($data['cvc'], $data['card_type'])
            ->setExpirationDate($data['expiry_month'] . "/" . $data['expiry_year'])
            ->setCardNumber($data['card_number'])
            ->setHolder($data['card_name']);

        try {
            $sale = (new CieloEcommerce($this->getConfig('merchant'), $this->getConfig('environment_type')))->createSale($sale);

            $paymentId = $sale->getPayment()->getPaymentId();

            $authenticationUrl = $sale->getPayment()->getAuthenticationUrl();

            $this->Order->update([
                'payment_id' => $paymentId,
                'payment_url' => $authenticationUrl,
                'payment_method' => 'debit-card',
                'total' => $total,
                'discount' => $discount,
                'discount_percent' => $discount_percent,
                'total_without_discount' => $total_without_discount,
                'payment_brand' => $data['card_type'],
                'payment_card_number' => substr($data['card_number'], -4)
            ], $orders_id);

            $this->Order->addHistory($orders_id, $this->getConfig('status_waiting_payment'));

            return $authenticationUrl;
        } catch (CieloRequestException $e) {
            Log::write('error', $e->getCieloError());
            return false;
        }
    }

    /**
     * @param $orders_id
     * @param $method
     * @return array
     */
    public function discount($orders_id, $method)
    {
        $order = $this->Order->getOrder($orders_id);

        $discount = 0;
        $total = $order->total;
        $discount_text = '';
        $status = false;

        switch ($method) {
            case 'ticket':
                if (isset($this->payment_config->ticket_discount) && is_numeric($this->payment_config->ticket_discount) && $this->payment_config->ticket_discount > 0) {
                    $discount = (($this->payment_config->ticket_discount / 100) * $total);
                    $total = $total - $discount;
                    $discount_text = $this->payment_config->ticket_discount . '% de desconto no boleto';
                    $status = true;
                }
                break;
            case 'debit-card':
                if (isset($this->payment_config->debit_discount) && is_numeric($this->payment_config->debit_discount) && $this->payment_config->debit_discount > 0) {
                    $discount = (($this->payment_config->debit_discount / 100) * $total);
                    $total = $total - $discount;
                    $discount_text = $this->payment_config->debit_discount . '% de desconto no débito';
                    $status = true;
                }
                break;
            default:
                break;
        }

        return [
            'status' => $status,
            'total' => $total,
            'discount' => $discount,
            'total_format' => 'R$ ' . number_format($total, 2, ",", "."),
            'discount_format' => '-R$ ' . number_format($discount, 2, ",", "."),
            'discount_text' => $discount_text
        ];
    }

    public function getBrand($brand)
    {
        switch ($brand) {
            case 'visa':
                return CreditCard::VISA;
                break;
            case 'mastercard':
            case 'master':
                return CreditCard::MASTERCARD;
                break;
            case 'elo':
                return CreditCard::ELO;
                break;
            case 'amex':
                return CreditCard::AMEX;
                break;
            case 'aura':
                return CreditCard::AURA;
                break;
            case 'dinners':
                return CreditCard::DINERS;
                break;
            case 'discover':
                return CreditCard::DISCOVER;
                break;
            case 'hipercard':
                return CreditCard::HIPERCARD;
                break;
            case 'JCB':
                return CreditCard::JCB;
                break;
            default:
                return $brand;
                break;
        }
    }

    public function createSale($data)
    {
        if ($this->getConfig('environment') == 'sandbox') {
            $api = 'https://apisandbox.cieloecommerce.cielo.com.br/';
            $apiQuery = 'https://apiquerysandbox.cieloecommerce.cielo.com.br/';
        } else {
            $api = 'https://api.cieloecommerce.cielo.com.br/';
            $apiQuery = 'https://apiquery.cieloecommerce.cielo.com.br/';
        }

        $headers = [
            'Accept: application/json',
            'Accept-Encoding: gzip',
            'User-Agent: CieloEcommerce/3.0 PHP SDK',
            'MerchantId: ' . $this->getConfig('merchant_id'),
            'MerchantKey: ' . $this->getConfig('merchant_key'),
            'RequestId: ' . uniqid()
        ];

        $curl = curl_init($api . '1/sales/');
        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        if ($data !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            $headers[] = 'Content-Type: application/json';
        } else {
            $headers[] = 'Content-Length: 0';
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            throw new \RuntimeException('Curl error: ' . curl_error($curl));
        }

        curl_close($curl);

        return $this->readResponse($statusCode, $response);
    }

    protected function readResponse($statusCode, $responseBody)
    {
        $unserialized = null;

        switch ($statusCode) {
            case 200:
            case 201:
                $unserialized = json_decode($responseBody);
                break;
            case 400:
                $exception = null;
                $response = json_decode($responseBody);

                foreach ($response as $error) {
                    $cieloError = new CieloError($error->Message, $error->Code);
                    $exception = new CieloRequestException('Request Error', $statusCode, $exception);
                    $exception->setCieloError($cieloError);
                }

                throw $exception;
            case 404:
                throw new CieloRequestException('Resource not found', 404, null);
            default:
                throw new CieloRequestException('Unknown status', $statusCode);
        }

        return $unserialized;
    }

    public function captureSale($paymentId, $total, $tax)
    {
        if ($this->getConfig('environment') == 'sandbox') {
            $api = 'https://apisandbox.cieloecommerce.cielo.com.br/';
            $apiQuery = 'https://apiquerysandbox.cieloecommerce.cielo.com.br/';
        } else {
            $api = 'https://api.cieloecommerce.cielo.com.br/';
            $apiQuery = 'https://apiquery.cieloecommerce.cielo.com.br/';
        }

        $url = $api . '1/sales/' . $paymentId . '/capture';
        $params = [];

        if ($total != null) {
            $params['amount'] = $total;
        }

        if ($tax != null) {
            $params['serviceTaxAmount'] = $tax;
        }

        $url .= '?' . http_build_query($params);

        $headers = [
            'Accept: application/json',
            'Accept-Encoding: gzip',
            'User-Agent: CieloEcommerce/3.0 PHP SDK',
            'MerchantId: ' . $this->getConfig('merchant_id'),
            'MerchantKey: ' . $this->getConfig('merchant_key'),
            'RequestId: ' . uniqid(),
            'Content-Length: 0'
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');

        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            throw new \RuntimeException('Curl error: ' . curl_error($curl));
        }

        curl_close($curl);

        return $this->readResponse($statusCode, $response);
    }

    /**
     * @param $paymentId
     * @param $orders_id
     * @return bool
     * @throws CieloRequestException
     */
    public function processDebit($paymentId, $orders_id)
    {
        $sale = (new CieloEcommerce($this->getConfig('merchant'), $this->getConfig('environment_type')));
        $status = $sale->getSale($paymentId)->getPayment()->getStatus();
        if ($status == 2) {
            $this->Order->update([
                'orders_statuses_id' => 1
            ], $orders_id);

            $this->Order->addHistory($orders_id, $this->getConfig('status_approved_payment'));
            return true;
        } else {
            return false;
        }
    }
}