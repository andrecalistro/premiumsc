<?php

namespace CheckoutV2\Controller;


use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\View\CellTrait;
use Cake\View\View;
use CheckoutV2\Model\Table\PaymentsTable;

/**
 * Class CheckoutController
 * @package CheckoutV2\Controller
 *
 * @property \CheckoutV2\Model\Table\CustomersTable $Customers
 * @property \CheckoutV2\Model\Table\ShipmentsTable $Shipments
 * @property \Admin\Model\Table\EmailTemplatesTable $EmailTemplates
 * @property \Admin\Model\Table\EmailQueuesTable $EmailQueues
 * @property array|bool|object genders
 * @property \CheckoutV2\Model\Entity\Order $order
 * @property \CheckoutV2\Model\Table\OrdersTable $Orders
 *
 * @property \CheckoutV2\Controller\Component\OrderComponent $Order
 * @property \CheckoutV2\Controller\Component\MoipComponent $Moip
 */
class CheckoutController extends AppController
{
    use CellTrait;

    public $Customers;
    public $Shipments;
    public $Orders;
    public $genders = ['Feminino' => 'Feminino', 'Masculino' => 'Masculino'];
    public $cart;
    public $order = null;

    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['identification', 'checkRegister', 'register', 'login']);

        $this->loadComponent('CheckoutV2.Order', [
            'payment_config' => $this->payment_config
        ]);
        $this->loadComponent('Recaptcha.Recaptcha', [
            'enable' => true,
            'sitekey' => $this->store->google_recaptcha_site_key,
            'secret' => $this->store->google_recaptcha_secret_key,
            'type' => 'image',
            'theme' => 'light',
            'lang' => 'pt-BR',
            'size' => 'normal'
        ]);
        $this->loadComponent('CheckoutV2.FreeShipping', [
            'session_id' => $this->request->getSession()->id()
        ]);

        $this->Customers = TableRegistry::getTableLocator()->get("CheckoutV2.Customers");
        $this->Shipments = TableRegistry::getTableLocator()->get('CheckoutV2.Shipments');
        $this->EmailTemplates = TableRegistry::getTableLocator()->get('Admin.EmailTemplates');
        $this->EmailQueues = TableRegistry::getTableLocator()->get('Admin.EmailQueues');
        $this->Orders = TableRegistry::getTableLocator()->get('CheckoutV2.Orders');

        if ($this->request->getSession()->check('orders_id') && ($order = $this->Order->getOrder($this->request->getSession()->read('orders_id')))) {
            $this->order = $order;
        }
    }

    /**
     * @param Event $event
     * @return \Cake\Network\Response|void|null
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setLayout('CheckoutV2.checkout');
        $this->set('_steps', $this->_steps);
    }

    /**
     * @param Event $event
     * @return \Cake\Http\Response|null
     */
    public function beforeFilter(Event $event)
    {
        if ($this->request->getParam('action') != 'success') {
            $this->cart = $this->Cart->getProducts();

            if (count($this->cart['products']) == 0) {
                return $this->redirect(['controller' => 'carts', 'action' => 'index']);
            }
        }
        return parent::beforeFilter($event);
    }

    /**
     * @return \Cake\Http\Response|string|null
     */
    public function identification()
    {
        $this->pageTitle = "Identificação";

        if ($this->Auth->user() && $this->Auth->user('rules_id') == 999) {
            $this->Order->addNewOrderEmpty($this->Auth->user('id'), $this->request->getSession()->id());
            return $this->redirect(['controller' => 'checkout', 'action' => 'choose-address']);
        }

        if ($this->request->is('post')) {
            $login = $this->request->getData('login');
            $customer = $this->Customers->find()
                ->where([
                    'OR' => [
                        'document_clean' => preg_replace('/\D/', '', $login),
                        'email' => $login,
                    ]
                ])
                ->first();

            if (!$customer) {
                return $this->redirect([
                    'controller' => 'checkout',
                    'action' => 'register',
                    'login' => $login
                ]);
            }

            return $this->redirect([
                'controller' => 'checkout',
                'action' => 'login',
                $login
            ]);
        }

        $this->_steps['identification'] = 'active';

        $customer = $this->Customers->newEntity();
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    public function login($login)
    {
        if ($this->request->is('post')) {
            $customer = $this->Auth->identify();
            if ($customer) {
                $session_id = $this->request->getSession()->id();
                $customer['rules_id'] = 999;
                $this->Auth->setUser($customer);

                $this->Cart->regenerateSessionId($session_id, $this->request->getSession()->id());

                $this->Order->addNewOrderEmpty($this->Auth->user('id'), $this->request->getSession()->id());

                return $this->redirect(['controller' => 'checkout', 'action' => 'choose-address']);
            } else {
                $this->Flash->error(__("E-mail/CPF ou senha inválidos. Por favor tente novamente"));
            }
        }

        $this->_steps['identification'] = 'active';

        $customer = $this->Customers->newEntity();
        $this->set(compact('customer', 'login'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * @param null $addresses_id
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function shipment($addresses_id = null)
    {
        $this->pageTitle = __("Envio");

        /**
         * verify if this order need the shipping
         */
        if (!$this->Order->shippingIsRequired()) {
            $this->Order->setOrderNeedShipping(false);
            $this->Order->addAddress($this->request->getSession()->read('orders_id'), $addresses_id);
            return $this->redirect(['controller' => 'checkout', 'action' => 'choose-payment', 'plugin' => 'CheckoutV2']);
        } else {
            $this->Order->setOrderNeedShipping(true);
        }

        if (!$addresses_id) {
            return $this->redirect(['controller' => 'checkout', 'action' => 'addresses']);
        }

        if ($this->request->is(['post', 'put'])) {
            $data = json_decode($this->request->getData('data'), true);
            $data['total'] = $data['shipping_total'] + $this->order->subtotal - $this->order->coupon_discount;
            if ($this->Order->update($data, $this->request->getSession()->read('orders_id'))) {
                return $this->redirect(['controller' => 'checkout', 'action' => 'choose-payment']);
            }
            $this->Flash->error(__("Ocorreu um problema ao selecionar o frete. Por favor, tente novamente."));
            return $this->redirect(['controller' => 'checkout', 'action' => 'shipment', $addresses_id]);
        }

        $address = $this->Customers->CustomersAddresses->get($addresses_id);
        $this->Order->addAddress($this->request->getSession()->read('orders_id'), $addresses_id);

        $shipments = $this->Shipments->find('enables')->toArray();
        $quotes = [];

        if ($shipments) {
            foreach ($shipments as $shipment) {
                $shipment_code = Inflector::camelize($shipment->code);

                $this->loadComponent('CheckoutV2.' . $shipment_code, [
                    'session_id' => $this->request->getSession()->id()
                ]);

                if (method_exists($this->$shipment_code, 'getQuote')) {
                    $quotes[] = $this->$shipment_code->getQuote($address);
                }
            }

            foreach ($quotes as $key => $quote) {
                if ($quote['error']) {
                    unset($quotes[$key]);
                    continue;
                }

                foreach ($quote['quote'] as $key2 => $service) {

                    $cost = $this->Order->calcShippingCostDiscountGroup($service['cost'], $this->request->getSession()->read('orders_id'));

                    //se o frete ja foi escolhido
                    if ($this->request->getSession()->check('quote_code') && $this->request->getSession()->check('quote_price') && $this->request->getSession()->read('quote_code') == $service['code'] && $this->request->getSession()->read('quote_price') == $service['cost']) {
                        $data = [
                            'total' => $cost + $this->order->subtotal,
                            'shipping_total' => $cost,
                            'shipping_code' => $service['code'],
                            'shipping_text' => $service['title'],
                            'shipping_deadline' => $service['deadline'],
                            'shipping_image' => $service['image']
                        ];
                        if ($this->Order->update($data, $this->request->getSession()->read('orders_id'))) {
                            return $this->redirect(['controller' => 'checkout', 'action' => 'choose-payment']);
                        }
                    }

                    $quotes[$key]['quote'][$key2]['data'] = [
                        'shipping_total' => $cost,
                        'shipping_code' => $service['code'],
                        'shipping_text' => $service['title'],
                        'shipping_deadline' => $service['deadline'],
                        'shipping_image' => $service['image']
                    ];
                    $quotes[$key]['quote'][$key2]['cost'] = $cost;
                    $quotes[$key]['quote'][$key2]['text'] = 'R$ ' . number_format($cost, 2, ',', '.');
                    $quotes[$key]['quote'][$key2]['addresses_id'] = $addresses_id;
                }
            }
        }

        $content = '';
        $allShipments = [];

        foreach ($quotes as $quote) {
            if (!$quote['error']) {
                foreach ($quote['quote'] as $shipment) {
                    $allShipments[] = $shipment;
                }
            }
        }

        usort($allShipments, function ($a, $b) {
            return floatval($a['cost']) - floatval($b['cost']);
        });

        foreach ($allShipments as $shipment) {
            $content .= $this->cell("CheckoutV2.Shipment::chooseQuoteCheckout", [$shipment]);
        }

        if (empty($content)) {
            $content = '<p>Não há opções de envio para o seu endereço. Entre em contato conosco para mais detalhes.</p>';
        }

        if (!$order = $this->Order->getOrder($this->request->getSession()->read('orders_id'))) {
            return $this->redirect(['controller' => 'carts', 'action' => 'index']);
        }

        $addresses = $this->Customers->CustomersAddresses->find()
            ->where([
                'customers_id' => $this->Auth->user('id'),
                'id <>' => $addresses_id
            ])
            ->toArray();

        $this->_steps['identification'] = 'active';
        $this->_steps['shipping_payment'] = 'active';

        $this->set(compact('quotes', 'content', 'address', 'order', 'addresses'));
        $this->set('_serialize', ['quotes']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function addAddress()
    {
        $this->pageTitle = __('Adicionar endereço');

        $customersAddress = $this->Customers->CustomersAddresses->newEntity();

        if ($this->request->is(['post', 'put'])) {
            $customersAddress = $this->Customers->CustomersAddresses->patchEntity($customersAddress, $this->request->getData());
            $customersAddress->customers_id = $this->Auth->user('id');
            if ($this->Customers->CustomersAddresses->save($customersAddress)) {
                return $this->redirect(['controller' => 'checkout', 'action' => 'shipment', $customersAddress->id]);
            }
            $this->Flash->error(__("Seu endereço não foi salvo. Por favor tente novamente."));
        }

        $this->_steps['identification'] = 'active';
        $this->_steps['shipping_payment'] = 'active';

        $this->set(compact('customersAddress'));
        $this->set('_serialize', ['address']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function chooseAddress()
    {
        $this->pageTitle = __('Escolha o endereço de entrega');

        if (!$customersAddresses = $this->Customers->CustomersAddresses->haveAddress($this->Auth->user('id'))) {
            return $this->redirect(['controller' => 'checkout', 'action' => 'add-address']);
        }

        return $this->redirect(['controller' => 'checkout', 'action' => 'shipment', $customersAddresses[0]->id]);
    }

    public function choosePayment()
    {
        if (!$order = $this->Order->getOrder($this->request->getSession()->read('orders_id'))) {
            return $this->redirect(['controller' => 'carts', 'action' => 'index']);
        }

        if (!$this->order->shipping_code && !$this->order->shipping_total && $this->order->shipping_required) {
            return $this->redirect(['controller' => 'checkout', 'action' => 'choose-address']);
        }

        /** salvando metodo de pagamento pra carregar o conteudo depois */
        if ($this->request->is(['put', 'post'])) {
            $order->payment_method = $this->request->getData('payment');
            $this->Orders->save($order);

            return $this->redirect([
                'controller' => 'checkout',
                'action' => 'payment'
            ]);
        }

        $this->pageTitle = 'Forma de Pagamento';

        $installments = $this->Order->installments($this->payment_config, $order->total);
        $lastInstallment = array_pop($installments);

        //get actives payment methods
        /** @var PaymentsTable $Payments */
        $Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');
        $payment_methods = $Payments->enables();

        $data = [
            'total' => $order->subtotal + $order->shipping_total - $order->coupon_discount,
            'total_without_discount' => $order->subtotal + $order->shipping_total,
            'discount' => 0,
            'discount_percent' => 0
        ];
        $order = $this->Orders->patchEntity($order, $data);
        $this->Orders->save($order);

        $this->_steps['identification'] = 'active';
        $this->_steps['shipping_payment'] = 'active';

        $this->set(compact('order', 'lastInstallment', 'payment_methods'));
    }

    /**
     *
     */
    public function payment()
    {
        $this->pageTitle = 'Pagamento';

        if (!$this->order->shipping_code && !$this->order->shipping_total && $this->order->shipping_required) {
            return $this->redirect(['controller' => 'checkout', 'action' => 'choose-address']);
        }

        if (!$order = $this->Order->getOrder($this->request->getSession()->read('orders_id'))) {
            return $this->redirect(['controller' => 'carts', 'action' => 'index']);
        }

        if (!$order->payment_method) {
            return $this->redirect([
                'controller' => 'checkout',
                'action' => 'choose-payment'
            ]);
        }

        $months = [
            "01" => "Janeiro (01)",
            "02" => "Fevereiro (02)",
            "03" => "Março (03)",
            "04" => "Abril (04)",
            "05" => "Maio (05)",
            "06" => "Junho (06)",
            "07" => "Julho (07)",
            "08" => "Agosto (08)",
            "09" => "Setembro (09)",
            "10" => "Outubro (10)",
            "11" => "Novembro (11)",
            "12" => "Dezembro (12)"
        ];

        $year_now = (int)Time::now('America/Sao_Paulo')->format("Y");
        $year_limit = $year_now + 15;
        for ($i = $year_now; $i <= $year_limit; $i++) {
            $years[$i] = $i;
        }

//        $public_key = $this->Moip->getPublicKey();

        $installments = $this->Order->installments($this->payment_config, $order->total);

        $customer = $this->Customers->get($this->Auth->user('id'));

        $document = $customer->document;
        $name = $customer->name;

        if (!$customer->birth_date) {
            $birth_date = false;
        } else {
            $birth_date = $customer->birth_date->format('d/m/Y');
        }

        //get actives payment methods
        /** @var PaymentsTable $Payments */
        $Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');
        $payment_method = $Payments->findConfig($order->payment_method);

        $data = [
            'total' => $order->subtotal + $order->shipping_total - $order->coupon_discount,
            'total_without_discount' => $order->subtotal + $order->shipping_total,
            'discount' => 0,
            'discount_percent' => 0
        ];
        $order = $this->Orders->patchEntity($order, $data);
        $this->Orders->save($order);

        $this->_steps['identification'] = 'active';
        $this->_steps['shipping_payment'] = 'active';

        $this->set(compact('order', 'months', 'years', 'installments', 'name', 'document', 'birth_date', 'payment_method'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function register()
    {
        $this->pageTitle = 'Cadastro';

        $customer = $this->Customers->newEntity(null, ['associated' => ['CustomersAddresses']]);

        $login = $this->request->getQuery('login');
        if (strlen(preg_replace('/\D/', '', $login)) === 11) {
            $customer->document = $login;
        } else {
            $customer->email = $login;
        }

        if ($this->request->is(['post'])) {
            if ($this->request->getData('customers_types_id') == 2) {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses'], 'validate' => 'companyPeople']);
            } else {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses']]);
            }
            $customer->status = 1;

            if ($this->Customers->save($customer)) {
                $customer->rules_id = 999;
                $session_id = $this->request->getSession()->id();
                $this->Auth->setUser($customer);
                $this->Cart->regenerateSessionId($session_id, $this->request->getSession()->id());

                $this->Order->addNewOrderEmpty($this->Auth->user('id'), $this->request->getSession()->id());

                return $this->redirect(['controller' => 'checkout', 'action' => 'shipment', $customer->customers_addresses[0]->id]);
            }
            $this->Flash->error(__("Ocorreu um problema ao finalizar seu cadastro. Por favor, revise e tente novamente."));
        }

        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $garrula = $Stores->findConfig('garrula');
        isset($garrula->company_register) ? $company_register = $garrula->company_register : $company_register = false;

        unset($customer->password);
        unset($customer->password_confirm);
        $this->getTermsPage($this->store->terms_pages_id);

        $this->_steps['identification'] = 'active';
        $this->_steps['shipping_payment'] = 'active';

        $customersTypes = $this->Customers->CustomersTypes->find('list')
            ->toArray();
        $this->set('genders', $this->genders);
        $this->set(compact('customer', 'company_register', 'customersTypes'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function checkRegister()
    {
        if ($this->request->is(['post'])) {
            $customer = $this->Customers->find()
                ->where(['email' => $this->request->getData('email')])
                ->first();
            if (!$customer) {
                $this->redirect(['controller' => 'checkout', 'action' => 'register', 'nome' => $this->request->getData('name'), 'email' => $this->request->getData('email')]);
            } else {
                $this->Flash->error(__("Já existe um cadastro com esse e-mail."));
                return $this->redirect(['controller' => 'checkout', 'action' => 'identification']);
            }
        }
    }

    /**
     * @param $orders_id
     * @return \Cake\Http\Response|null
     */
    public function success($orders_id)
    {
        $view = new View($this->request, $this->response);
        $this->request->getSession()->delete('orders_id');

        $order = $this->Order->getOrder($orders_id);

        if (!$order || $order->customers_id != $this->Auth->user('id')) {
            return $this->redirect(['controller' => 'carts', 'action' => 'index']);
        }

        $template = $this->EmailTemplates->find()
            ->where(['slug' => 'novo-pedido'])
            ->first();

        if ($view->elementExists(Configure::read('Theme') . '.Order/product')) {
            $products_html = $view->element(Configure::read('Theme') . '.Order/product', ['products' => $order->orders_products]);
        } else {
            $products_html = $view->element('Order/product', ['products' => $order->orders_products]);
        }

        $data = [
            'orders_id' => $order->id,
            'name' => $order->customer->name,
            'document' => $order->customer->document,
            'email' => $order->customer->email,
            'telephone' => $order->customer->telephone,
            'address' => $order->address . ', ' . $order->number . ', ' . $order->complement . ' - ' . $order->neighborhood,
            'zipcode' => $order->zipcode,
            'city' => $order->city,
            'uf' => $order->state,
            'products' => $products_html,
            'subtotal' => $order->subtotal_format,
            'shipping_text' => $order->shipping_text,
            'shipping_total' => $order->shipping_total_format,
            'discount' => $order->discount_format,
            'total' => $order->total_format,
            'payment_type' => $order->payment_method_text,
            'payment_condition' => $order->installments_text,
            'shipping_deadline' => $order->shipment_deadline_text,
            'order_url' => Router::url(['_full' => true, 'controller' => 'customers', 'action' => 'order', $order->id])
        ];

        $html = $this->EmailTemplates->buildHtml($template, $data);

        /**
         * store email
         */
        $email = $this->EmailQueues->newEntity([
            'from_name' => $template->from_name,
            'from_email' => $template->from_email,
            'subject' => $template->subject,
            'content' => $html,
            'to_name' => $this->store->name,
            'to_email' => $this->store->email_contact,
            'email_statuses_id' => 1,
        ]);

        $this->EmailQueues->save($email);

        /**
         * customer email
         */
        $email = $this->EmailQueues->newEntity([
            'from_name' => $template->from_name,
            'from_email' => $template->from_email,
            'subject' => $template->subject,
            'content' => $html,
            'to_name' => $order->customer->name,
            'to_email' => $order->customer->email,
            'email_statuses_id' => 1,
            'reply_name' => $template->reply_name,
            'reply_email' => $template->reply_email
        ]);

        $this->EmailQueues->save($email);

        $this->pageTitle = 'Obrigado por comprar conosco!';
        $this->viewBuilder()->setTemplate('Checkout/success/credit_card');

        if (preg_match('/ticket/', $order->payment_method)) {
            $this->pageTitle = 'Obrigado por comprar conosco!';
            $this->viewBuilder()->setTemplate('Checkout/success/ticket');
        }

        $link = null;
        if (preg_match('/http/', $order->payment_url)) {
            $link = $order->payment_url;
        }

        $this->Cart->clearValues(false);
        $this->Cart->deleteAll(['session_id ' => $this->request->getSession()->id()]);

        $this->_steps['identification'] = 'active';
        $this->_steps['shipping_payment'] = 'active';
        $this->_steps['done'] = 'active';

        $this->set(compact('order', 'link'));
    }

    /**
     *
     */
    public function discount()
    {
        $discount = $this->Order->discount($this->request->getSession()->read('orders_id'), $this->request->getData('method'));

        $this->set(compact('discount'));
        $this->set('_serialize', ['discount']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function clearAddress()
    {
        $this->request->getSession()->delete('quote_code');
        $this->request->getSession()->delete('quote_price');
        $this->request->getSession()->delete('total');
        $this->request->getSession()->delete('total_format');
        $this->request->getSession()->delete('quote_price_format');
        $this->request->getSession()->delete('zipcode');

        return $this->redirect(['controller' => 'checkout', 'action' => 'choose-address']);
    }

    /**
     *
     */
    public function getPaymentHtml()
    {
        $payment_method = Inflector::camelize($this->request->getData('payment_method'));
        $content = $this->cell('CheckoutV2.' . $payment_method . '::getPaymentHtml', [$this->order, $this->payment_config, $this->Auth->user(), $this->store])->render();
        $this->set(compact('content'));
        $this->set('_serialize', ['content']);
    }
}