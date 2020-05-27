<?php

namespace Subscriptions\Controller;

use Admin\Model\Table\EmailQueuesTable;
use Admin\Model\Table\EmailTemplatesTable;
use Admin\Model\Table\StoresTable;
use Cake\Http\Response;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\View\CellTrait;
use Checkout\Controller\AppController;
use Checkout\Model\Entity\CustomersAddress;
use Checkout\Model\Table\CustomersTable;
use Checkout\Model\Table\ShipmentsTable;
use Mpdf\Tag\Sub;
use mysql_xdevapi\Exception;
use Subscriptions\Controller\Component\SubscriptionComponent;
use Subscriptions\Model\Entity\Subscription;
use Subscriptions\Model\Entity\SubscriptionBilling;
use Subscriptions\Model\Table\PlansTable;
use Subscriptions\Model\Table\SubscriptionBillingsTable;
use Subscriptions\Model\Table\SubscriptionShipmentsTable;
use Subscriptions\Model\Table\SubscriptionsTable;
use Subscriptions\Service\Email;

/**
 * Class PlanCheckoutController
 * @property SubscriptionComponent $Subscription
 * @package Subscriptions\Controller
 */
class PlanCheckoutController extends AppController
{
    use CellTrait;

    /** @var PlansTable */
    private $plansTable;

    /** @var SubscriptionsTable */
    private $subscriptionsTable;

    /** @var SubscriptionBillingsTable */
    private $subscriptionBillingsTable;

    /** @var SubscriptionShipmentsTable */
    private $subscriptionShipmentsTable;

    /** @var CustomersTable */
    private $customersTable;

    /** @var ShipmentsTable */
    private $shipmentsTable;

    /** @var EmailTemplatesTable */
    private $emailTemplatesTable;

    /** @var EmailQueuesTable */
    private $emailQueuesTable;

    /** @var array */
    public $genders = ['Feminino' => 'Feminino', 'Masculino' => 'Masculino'];

    const SESSION_PLAN_ID = 'CartPlan.id';
    const SESSION_SHIPMENT = 'CartPlan.shipment';

    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['identification', 'checkRegister', 'register', 'addPlanCart', 'processNextPayment', 'checkStatusPayment']);

        $this->plansTable = TableRegistry::getTableLocator()->get("Subscriptions.Plans");
        $this->subscriptionsTable = TableRegistry::getTableLocator()->get("Subscriptions.Subscriptions");
        $this->subscriptionBillingsTable = TableRegistry::getTableLocator()->get("Subscriptions.SubscriptionBillings");
        $this->subscriptionShipmentsTable = TableRegistry::getTableLocator()->get("Subscriptions.SubscriptionShipments");
        $this->customersTable = TableRegistry::getTableLocator()->get("Checkout.Customers");
        $this->shipmentsTable = TableRegistry::getTableLocator()->get('Checkout.Shipments');
        $this->emailTemplatesTable = TableRegistry::getTableLocator()->get('Admin.EmailTemplates');
        $this->emailQueuesTable = TableRegistry::getTableLocator()->get('Admin.EmailQueues');

        $this->loadComponent('Subscriptions.Subscription', [
            'payment_config' => $this->payment_config
        ]);
    }

    /**
     * @param $planId
     * @return \Cake\Http\Response|null
     */
    public function addPlanCart($planId)
    {
        $plan = $this->plansTable->get($planId);

        if (!$plan) {
            return $this->redirect(['_name' => 'assinaturas']);
        }

        $this->setSessionPlanId($planId);
        return $this->redirect(['_name' => 'planIdentification']);
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function identification()
    {
        $this->pageTitle = "Identificação";

        if ($this->Auth->user() && $this->Auth->user('rules_id') == 999) {
            return $this->redirect(['_name' => 'planChooseAddress']);
        }

        if ($this->request->is('post')) {
            $planId = $this->getSessionPlanId();
            $customer = $this->Auth->identify();
            if ($customer) {
                $customer['rules_id'] = 999;
                $this->Auth->setUser($customer);

                $this->setSessionPlanId($planId);

                return $this->redirect(['_name' => 'planChooseAddress']);
            } else {
                $this->Flash->error(__("E-mail/CPF ou senha inválidos. Por favor tente novamente"));
            }
        }

        $customer = $this->customersTable->newEntity();
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function checkRegister()
    {
        if ($this->request->is(['post'])) {
            $customer = $this->customersTable->find()
                ->where(['email' => $this->request->getData('email')])
                ->first();
            if (!$customer) {
                return $this->redirect(['_name' => 'planRegister', 'nome' => $this->request->getData('name'), 'email' => $this->request->getData('email')]);
            }
            $this->Flash->error(__("Já existe um cadastro com esse e-mail."));
        }
        return $this->redirect(['_name' => 'planIdentification']);
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function register()
    {
        $this->pageTitle = 'Cadastro';

        $customer = $this->customersTable->newEntity(null, ['associated' => ['CustomersAddresses']]);

        $customer->name = $this->request->getQuery('nome');
        $customer->email = $this->request->getQuery('email');

        if ($this->request->is(['post'])) {
            if ($this->request->getData('customers_types_id') == 2) {
                $customer = $this->customersTable->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses'], 'validate' => 'companyPeople']);
            } else {
                $customer = $this->customersTable->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses']]);
            }
            $customer->status = 1;

            if ($this->customersTable->save($customer)) {
                $planId = $this->getSessionPlanId();
                $customer->rules_id = 999;
                $this->Auth->setUser($customer);

                $this->setSessionPlanId($planId);

                return $this->redirect(['_name' => 'planShipment', $customer->customers_addresses[0]->id]);
            }
            $this->Flash->error(__("Ocorreu um problema ao finalizar seu cadastro. Por favor, revise e tente novamente."));
        }

        /** @var StoresTable $Stores */
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $garrula = $Stores->findConfig('garrula');
        isset($garrula->company_register) ? $company_register = $garrula->company_register : $company_register = false;

        unset($customer->password);
        unset($customer->password_confirm);
        $this->getTermsPage($this->store->terms_pages_id);

        $customersTypes = $this->customersTable->CustomersTypes->find('list')
            ->toArray();
        $this->set('genders', $this->genders);
        $this->set(compact('customer', 'company_register', 'customersTypes'));
        $this->set('_serialize', ['customer']);
    }

    public function shipment($addresses_id = null)
    {
        $this->pageTitle = __("Envio");

        if (!$addresses_id) {
            return $this->redirect(['controller' => 'checkout', 'action' => 'addresses']);
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $data['addresses_id'] = $addresses_id;
            $this->setSessionShipment($data);
            return $this->redirect(['_name' => 'planPayment']);
        }

        /** @var CustomersAddress $address */
        $address = $this->customersTable->CustomersAddresses->get($addresses_id);

        $shipments = $this->shipmentsTable->find('enables')->toArray();
        $quotes = [];

        $plan = $this->plansTable->getPlan($this->getSessionPlanId());

        if ($shipments) {
            foreach ($shipments as $shipment) {
                if ($shipment->code !== 'correios') {
                    continue;
                }
                $shipment_code = Inflector::camelize($shipment->code);

                $this->loadComponent('Checkout.' . $shipment_code, [
                    'session_id' => $this->request->getSession()->id()
                ]);

                if (method_exists($this->$shipment_code, 'getQuotePlan')) {
                    $quotes[] = $this->$shipment_code->getQuotePlan($address, $plan->dimensions);
                }
            }

            foreach ($quotes as $key => $quote) {
                if (!$quote['error']) {
                    foreach ($quote['quote'] as $key2 => $service) {

                        $quotes[$key]['quote'][$key2]['data'] = [
                            'shipping_total' => $service['cost'],
                            'shipping_code' => $service['code'],
                            'shipping_text' => $service['title'],
                            'shipping_deadline' => $service['deadline'],
                            'shipping_image' => $service['image']
                        ];
                        $quotes[$key]['quote'][$key2]['addresses_id'] = $addresses_id;
                    }
                } else {
                    unset($quotes[$key]);
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
            $content .= $this->cell("Checkout.Shipment::chooseQuoteCheckout", [$shipment]);
        }

        if (empty($content)) {
            $content = '<p>Não há opções de envio para o seu endereço. Entre em contato conosco para mais detalhes.</p>';
        }

        $this->set(compact('quotes', 'content', 'address'));
        $this->set('_serialize', ['quotes']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function chooseAddress()
    {
        $this->pageTitle = __('Escolha o endereço de entrega');

        if (!$customersAddresses = $this->customersTable->CustomersAddresses->haveAddress($this->Auth->user('id'))) {
            return $this->redirect(['_name' => 'planAddAddress']);
        }

        $this->set(compact('customersAddresses'));
    }

    /**
     *
     */
    public function payment()
    {
        $this->pageTitle = 'Pagamento';

        //get actives payment methods
        $Payments = TableRegistry::getTableLocator()->get('Checkout.Payments');
        $payment_methods = $Payments->enables();

        foreach ($payment_methods as $key => $payment_method) {
            if ($payment_method['code'] !== 'pagseguro_credit_card') {
                unset($payment_methods[$key]);
            }
        }

        $shipment = $this->getSessionShipment();
        $address = $this->customersTable->CustomersAddresses->get($shipment['addresses_id']);
        $plan = $this->plansTable->getPlan($this->getSessionPlanId());
        $total = $plan->price + $shipment['shipping_total'];
        $totalFormat = sprintf('R$ %s', number_format($total, 2, ',', '.'));
        $shipment['price_format'] = sprintf('R$ %s', number_format($shipment['shipping_total'], 2, ',', '.'));

        $this->set(compact('payment_methods', 'address', 'plan', 'total', 'totalFormat', 'shipment'));
    }

    /**
     *
     */
    public function getPaymentHtml()
    {
        $payment_method = Inflector::camelize($this->request->getData('payment_method'));
        $plan = $this->plansTable->getPlan($this->getSessionPlanId());
        $content = $this->cell('Subscriptions.' . $payment_method . '::getPaymentHtml', [$plan, $this->payment_config, $this->Auth->user(), $this->store])->render();
        $this->set(compact('content'));
        $this->set('_serialize', ['content']);
    }

    public function processPayment()
    {
        try {
            $payment = $this->request->getData('payment');
            $method = $this->request->getData('method');
            if (!$payment) {
                throw new \Exception('Pagamento deve ser informado', 400);
            }
            if (!$method) {
                throw new \Exception('Metodo deve ser informado', 400);
            }

            $plan = $this->plansTable->getPlan($this->getSessionPlanId());
            $customer = $this->customersTable->get($this->Auth->user('id'));
            $dataShipment = $this->getSessionShipment();
            $customerAddress = $this->customersTable->CustomersAddresses->get($dataShipment['addresses_id']);

            $this->loadComponent(sprintf('Subscriptions.%s', $payment));

            $result = $this->$payment->$method(
                $this->request->getData(),
                $plan,
                $customer,
                $customerAddress,
                $dataShipment,
                $this->request->clientIp());

            /** @var Subscription $subscription */
            $subscription = $this->subscriptionsTable->newEntity();
            $subscription->set('customers_id', $customer->id);
            $subscription->set('customers_addresses_id', $customerAddress->id);
            $subscription->set('plans_id', $plan->id);
            $subscription->set('plans_name', $plan->name);
            $subscription->set('plans_image', $plan->main_image);
            $subscription->set('plans_thumb_image', $plan->thumb_main_image);
            $subscription->set('status', 1);
            $subscription->set('frequency_billing_days', $plan->plan_billing_frequency->days);
            $subscription->set('frequency_billing_name', $plan->plan_billing_frequency->name);
            $subscription->set('frequency_delivery_days', $plan->plan_delivery_frequency->days);
            $subscription->set('frequency_delivery_name', $plan->plan_delivery_frequency->name);
            $subscription->set('payment_component', $payment);
            $subscription->set('payment_method', $method);
            $subscription->set('price', $plan->price);
            if ($plan->shipping_required) {
                $subscription->set('shipping_method', \GuzzleHttp\json_encode($dataShipment));
                $subscription->set('price_shipping', $dataShipment['shipping_total']);
            }
            $subscription->set('code', $result['code']);
            $this->subscriptionsTable->save($subscription);

            $subscriptionBilling = $this->subscriptionBillingsTable->newEntity();
            $subscriptionBilling->set('subscriptions_id', $subscription->id);
            $subscriptionBilling->set('payment_component', $payment);
            $subscriptionBilling->set('payment_method', $method);
            $subscriptionBilling->set('status_id', 2);
            $subscriptionBilling->set('payment_code', $result['paymentCode']);
            $this->subscriptionBillingsTable->save($subscriptionBilling);

            if ($plan->shipping_required) {
                $subscriptionShipment = $this->subscriptionShipmentsTable->newEntity();
                $subscriptionShipment->set('subscriptions_id', $subscription->id);
                $subscriptionShipment->set('shipping_method', \GuzzleHttp\json_encode($dataShipment));
                $subscriptionShipment->set('status_id', 1);
                $this->subscriptionShipmentsTable->save($subscriptionShipment);
            }

            /** @var Email $serviceEmail */
            $serviceEmail = new Email();
            $serviceEmail->sendNewSubscription($subscription);

            return new Response(['body' => \GuzzleHttp\json_encode([
                'status' => true,
                'redirect' => Router::url([$subscription->id, '_name' => 'planSuccess'], true)
            ])]);
        } catch (\Exception $e) {
            return new Response([
                'body' => $e->getMessage(),
                'status' => 400
            ]);
        }
    }

    /**
     * @return array|string|null
     */
    private function getSessionPlanId()
    {
        return $this->request->getSession()->read(self::SESSION_PLAN_ID);
    }

    /**
     * @param $planId
     */
    private function setSessionPlanId($planId)
    {
        $this->request->getSession()->write(self::SESSION_PLAN_ID, $planId);
    }

    /**
     * @return array|string|null
     */
    private function getSessionShipment()
    {
        return $this->request->getSession()->read(self::SESSION_SHIPMENT);
    }

    /**
     * @param $data
     */
    private function setSessionShipment($data)
    {
        $this->request->getSession()->write(self::SESSION_SHIPMENT, $data);
    }

    public function checkStatusPayment()
    {
        try {
            $billings = $this->subscriptionsTable->SubscriptionBillings->find()
                ->where([
                    'SubscriptionBillings.status_id' => 2
                ])
                ->contain([
                    'Subscriptions'
                ])
                ->limit(5)
                ->toArray();

            /** @var SubscriptionBilling $billing */
            foreach ($billings as $billing) {
                $this->loadComponent(sprintf('Subscriptions.%s', $billing->payment_component));
                $component = $billing->payment_component;
                $status = $this->$component->checkStatus($billing->payment_code);
                if ($status === 3) {
                    /** @var Email $serviceEmail */
                    $serviceEmail = new Email();
                    $serviceEmail->sendNewPayment($billing->subscription);

                    $billing->status_id = 3;
                    $this->subscriptionsTable->SubscriptionBillings->save($billing);
                    $this->subscriptionsTable->SubscriptionBillings->createNextPayment($billing);
                    $this->subscriptionsTable->SubscriptionShipments->createNextShipment($billing->subscription);
                }
            }
            return new Response([
                'body' => 'Status de Pagamentos processados',
                'statusCode' => 202
            ]);
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            return new Response([
                'body' => 'Status de Pagamentos processados, alguns geraram erros, consulte o log para mais informacoes',
                'statusCode' => 400
            ]);
        }
    }

    public function processNextPayment()
    {
        try {
            $billings = $this->subscriptionsTable->SubscriptionBillings->find()
                ->where([
                    'SubscriptionBillings.status_id' => 1,
                    'SubscriptionBillings.date_process' => (new \DateTime())->format('Y-m-d')
                ])
                ->contain([
                    'Subscriptions' => function (Query $q) {
                        return $q->contain([
                            'Plans'
                        ]);
                    }
                ])
                ->limit(5)
                ->toArray();

            if (!$billings) {
                Log::info('Nenhum pagamento para processar');
                return new Response([
                    'body' => 'Nenhum pagamento para processar',
                    'statusCode' => 202
                ]);
            }

            /** @var SubscriptionBilling $billing */
            foreach ($billings as $billing) {
                $this->loadComponent(sprintf('Subscriptions.%s', $billing->payment_component));
                $component = $billing->payment_component;
                $response = $this->$component->processNextPayment($this->request->clientIp(), $billing->subscription);
                if (isset($response->transactionCode)) {
                    $billing->payment_code = $response->transactionCode;
                    $billing->status_id = 2;
                    $this->subscriptionsTable->SubscriptionBillings->save($billing);
                }
            }
            return new Response([
                'body' => 'Status de Pagamentos processados',
                'statusCode' => 202
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::alert($e->getMessage());
            return new Response([
                'body' => 'Status de Pagamentos processados, alguns geraram erros, consulte o log para mais informacoes',
                'statusCode' => 400
            ]);
        }
    }

    public function success($subscriptionId)
    {
        try {
            $subscription = $this->subscriptionsTable->getSubscription($subscriptionId);
            $this->pageTitle = sprintf('Assinatura - %s', $subscription->plan->name);

            $this->set(compact('subscription'));
        } catch (\Exception $e) {
            $this->Flash->error('Assinatura não encontrada');
            return $this->redirect('/');
        }
    }

    /**
     * @return Response|null
     */
    public function cancel()
    {
        try {
            $subscriptionId = $this->request->getData('id');

            $subscription = $this->plansTable->Subscriptions->getSubscription($subscriptionId);
            $componentPayment = $subscription->payment_component;

            $this->loadComponent(sprintf('Subscriptions.%s', $componentPayment));

            $this->$componentPayment->cancel($subscription);

            $subscription = $this->plansTable->Subscriptions->patchEntity($subscription, [
                'status' => 0
            ]);

            if ($this->plansTable->Subscriptions->save($subscription)) {
                /** @var Email $serviceEmail */
                $serviceEmail = new Email();
                $serviceEmail->sendSubscriptionCancel($subscription);

                $this->Flash->success('Assinatura cancelada');
                return $this->redirect($this->referer());
            }

            throw new \Exception('Ocorreu um erro ao cancelar a assinatura, tente novamente', 400);
        } catch (\Exception $e) {
            $this->Flash->error($e->getMessage());
            return $this->redirect(['_name' => '']);
        }
    }
}