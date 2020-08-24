<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Exception;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

/**
 * Class PaypalExpressComponent
 * @package Checkout\Controller\Component
 *
 * @property \Checkout\Model\Table\PaymentsTable $Payments
 * @property \Checkout\Controller\Component\OrderComponent $Order
 */
class PaypalPlusComponent extends Component
{
    public $Payments;
    public $payment_config;
    public $store;
    public $Order;
    public $mode;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');

        foreach ($this->Payments->findConfig('paypal_plus') as $key => $value) {
            $this->setConfig($key, $value);
        }

        $this->payment_config = $config['payment_config'];
        $this->store = $config['store'];
        $this->mode = $this->getConfig('test') ? 'sandbox' : 'live';

        $this->Order = new OrderComponent(new ComponentRegistry());
    }

    /**
     * @param $order_id
     * @return Payment
     * @throws Exception
     */
    public function beforePay($order_id)
    {
        $apiContext = $this->getApiContext();

        $order = $this->Order->getOrder($order_id);

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $items = [];
        foreach ($order->orders_products as $product) {
            $item = new Item();
            $item->setName($product->name)
                ->setCurrency('BRL')
                ->setQuantity($product->quantity)
                ->setSku($product->product->code)// Similar to `item_number` in Classic API
                ->setPrice($product->price);
            $items[] = $item;
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details();
        $details->setShipping($order->shipping_total)
            ->setSubtotal($order->subtotal);

        $amount = new Amount();
        $amount->setCurrency("BRL")
            ->setTotal($order->total)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Pagamento pedido #" . $order->id)
            ->setInvoiceNumber(uniqid());

        $baseUrl = Router::url('/', true);
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($baseUrl . "checkout/paypal-express/finalize?status=true")
            ->setCancelUrl($baseUrl . "checkout/paypal-express/finalize?status=cancel");

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction))
            ->setExperienceProfileId($this->getWebProfileId($apiContext));

        try {
            $payment->create($apiContext);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), 400);
        }

        $approvalUrl = $payment->getApprovalLink();

        $this->Order->update(['payment_id' => $payment->getId()], $order_id);

        return $approvalUrl;
    }

    /**
     * @param $clientId
     * @param $clientSecret
     * @return ApiContext
     */
    public function getApiContext()
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->getConfig('client_id'), $this->getConfig('client_secret')
            )
        );

        $apiContext->setConfig([
            'mode' => $this->mode,
            'log.LogEnabled' => false,
            'log.FileName' => '../PayPal.log',
            'log.LogLevel' => 'DEBUG',
            'cache.enabled' => true
        ]);
        return $apiContext;
    }

    /**
     * @param $data
     * @return bool
     */
    public function afterPay($data)
    {
        $order = $this->Order->getOrder(Component::getController()->request->getSession()->read('orders_id'));
        $apiContext = $this->getApiContext();
        $payment = Payment::get($order->payment_id, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($data['payerId']);

        $transaction = new Transaction();
        $amount = new Amount();
        $details = new Details();

        $details->setShipping($order->shipping_total)
            ->setSubtotal($order->subtotal);

        $amount->setCurrency('BRL');
        $amount->setTotal($order->total);
        $amount->setDetails($details);
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);

        $result = $payment->execute($execution, $apiContext);
        $status = $result->getState();

        if ($status == 'approved') {
            $this->Order->update([
                'payment_method' => 'paypal_plus',
                'total' => $order->total,
                'total_without_discount' => $order->total
            ], $order->id);
            $this->Order->addHistory($order->id, 1);
            $this->Order->addHistory($order->id, 2);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $apiContext
     * @return string
     * @throws Exception
     */
    public function getWebProfileId($apiContext)
    {
        //search created profiles
        $profiles = \PayPal\Api\WebProfile::get_list($apiContext);
        if ($profiles) {
            foreach ($profiles as $key => $profile) {
                return $profile->getId();
            }
        }

        $flowConfig = new \PayPal\Api\FlowConfig();
        $flowConfig->setBankTxnPendingUrl(Router::url('/finalizar-compra/pagamento', true))
            ->setLandingPageType('Billing')
            ->setReturnUriHttpMethod('GET')
            ->setUserAction('commit');

        $inputFields = new \PayPal\Api\InputFields([
            'no_shipping' => 1,
            'address_override' => 1
        ]);

        $presentation = new \PayPal\Api\Presentation([
            'logo_image' => $this->store->logo_link
        ]);

        $webProfile = new \PayPal\Api\WebProfile($apiContext);
        $webProfile->setFlowConfig($flowConfig)
            ->setName('premiumsc_' . uniqid())
            ->setInputFields($inputFields)
            ->setPresentation($presentation);

        try {
            $webProfile->create($apiContext);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), 400);
        }

        return $webProfile->getId();
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }
}