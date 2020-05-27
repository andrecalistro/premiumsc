<?php

namespace Admin\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Payments Controller
 *
 * @property \Admin\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{

    /**
     *
     */
    public function index()
    {
        $payments = [
            [
                'name' => 'PagSeguro',
                'status' => $this->Payments->getConfig('pagseguro_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'pagseguro'
            ],
            [
                'name' => 'Cielo Cartão de Crédito',
                'status' => $this->Payments->getConfig('cielo_credit_card_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'cielo_credit_card'
            ],
            [
                'name' => 'Moip (sem checkout padrao)',
                'status' => $this->Payments->getConfig('moip_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'moip'
            ],
            [
                'name' => 'Moip Boleto',
                'status' => $this->Payments->getConfig('moip_ticket_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'moip-ticket'
            ],
            [
                'name' => 'Moip Cartão de Crédito',
                'status' => $this->Payments->getConfig('moip_credit_card_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'moip-credit-card'
            ],
            [
                'name' => 'Depósito bancário',
                'status' => $this->Payments->getConfig('deposit_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'deposit'
            ],
            [
                'name' => 'PayPal Express Checkout',
                'status' => $this->Payments->getConfig('paypal_express_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'paypal-express'
            ],
            [
                'name' => 'PayPal Plus',
                'status' => $this->Payments->getConfig('paypal_plus_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'paypal-plus'
            ],
            [
                'name' => 'Mercado Pago Cartão de Crédito',
                'status' => $this->Payments->getConfig('mp_credit_card_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'mp-credit-card'
            ],
            [
                'name' => 'Mercado Pago Boleto',
                'status' => $this->Payments->getConfig('mp_ticket_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'mp-ticket'
            ],
            [
                'name' => 'PagSeguro Cartão de Crédito',
                'status' => $this->Payments->getConfig('pagseguro_credit_card_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'pagseguro_credit_card'
            ],
            [
                'name' => 'PagSeguro Boleto',
                'status' => $this->Payments->getConfig('pagseguro_ticket_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'pagseguro_ticket'
            ],
            [
                'name' => 'Boleto Bradesco',
                'status' => $this->Payments->getConfig('bradesco_ticket_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'bradesco_ticket'
            ],
            [
                'name' => 'Cielo Cartão de débito',
                'status' => $this->Payments->getConfig('cielo_debit_card_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'cielo_debit_card'
            ],
        ];

        array_multisort(array_column($payments, 'name'), SORT_ASC, $payments);

        $this->set(compact('payments'));
        $this->set('_serialize', ['payments']);
    }

    public function pagseguro()
    {
        $result = $this->Payments->findConfig('pagseguro');
        $entity = (object)[
            'status' => 0,
            'email' => '',
            'environment' => 'production',
            'token' => '',
            'status_waiting_payment' => '',
            'status_payment_analysis' => '',
            'status_approved_payment' => '',
            'status_payment_dispute' => '',
            'status_canceled_payment' => '',
            'status_reversed_payment' => '',
            'status_chargeback_payment' => '',
            'logo' => ''
        ];
        $pagseguro = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'pagseguro');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do PagSeguro foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        if (!empty($pagseguro->logo)) {
            $pagseguro->thumb_logo = Router::url("img" . DS . "files" . DS . "Pagseguro" . DS . "thumbnail-" . $pagseguro->logo, true);
            $pagseguro->logo = Router::url(DS . "img" . DS . "files" . DS . "Pagseguro" . DS . $pagseguro->logo, true);
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $environments = ['production' => 'Produção', 'sandbox' => 'Sandbox'];
        $this->set(compact('statuses', 'pagseguro', 'ordersStatuses', 'environments'));
        $this->set('_serialize', 'pagseguro');
        $this->set('notification_url', Router::url('/pagseguro/notification', true));
        $this->set('redirect_url', Router::url(['controller' => 'payment', 'action' => 'success', 'plugin' => Configure::read('Theme')], true));
        $this->set('cancel_url', Router::url(['controller' => 'payment', 'action' => 'cancel', 'plugin' => Configure::read('Theme')], true));
    }

    public function cieloCreditCard()
    {
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $store = $Stores->findConfig('store');
        $result = $this->Payments->findConfig('cielo_credit_card');
        $entity = (object)[
            'label' => 'Cielo Cartão de Crédito',
            'status' => 0,
            'merchant_id' => '',
            'merchant_key' => '',
            'environment' => 'production',
            'status_not_approval_payment' => '',
            'status_waiting_payment' => '',
            'status_payment_analysis' => '',
            'status_approved_payment' => '',
            'status_canceled_payment' => '',
            'return_url' => '',
            'address' => $store->address,
            'assignor' => $store->name,
            'demonstrative' => '',
            'instructions' => '',
            'expiration_date' => '',
            'identification' => '',
            'installment_free' => '',
            'installment' => '',
            'interest' => '',
            'installment_min' => '',
        ];
        $cielo_credit_card = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'cielo_credit_card');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações da Cielo Cartão de Crédito foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $environments = ['production' => 'Produção', 'sandbox' => 'Sandbox'];
        $this->set(compact('statuses', 'cielo_credit_card', 'ordersStatuses', 'environments'));
        $this->set('_serialize', 'cielo');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function configuration()
    {
        $result = $this->Payments->findConfig('payment');
        $entity = (object)[
            'debit_discount' => '',
            'installment_min' => '',
            'installment_free' => '',
            'installment' => '',
            'interest' => '',
            'ticket_expiration_date' => '',
            'ticket_discount' => '',
            'ticket_demonstrative' => '',
            'ticket_instructions' => ''
        ];
        $payment = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'payment');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações de parcelamento e desconto foram salvas."));
                return $this->redirect(['controller' => 'payments', 'action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações de parcelamento e desconto não foram salvas. Por favor, tente novamente."));
            }
        }

        $this->set(compact('payment'));
        $this->set('_serialize', 'payment');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function moip()
    {
        $result = $this->Payments->findConfig('moip');
        $entity = (object)[
            'status' => 0,
            'email' => '',
            'token' => '',
            'key' => '',
            'public_key' => '',
            'environment' => 'production',
            'status_waiting' => '',
            'status_in_analysis' => '',
            'status_pre_authorized' => '',
            'status_authorized' => '',
            'status_cancelled' => '',
            'status_refunded' => '',
            'status_reversed' => '',
            'status_settled' => '',
        ];
        $moip = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'moip');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Moip foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $environments = ['production' => 'Produção', 'sandbox' => 'Sandbox/Teste'];
        $this->set(compact('statuses', 'moip', 'ordersStatuses', 'environments'));
        $this->set('_serialize', 'moip');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function moipTicket()
    {
        $result = $this->Payments->findConfig('moip_ticket');
        $entity = (object)[
            'status' => 0,
            'label' => 'Boleto',
            'email' => '',
            'token' => '',
            'key' => '',
            'public_key' => '',
            'environment' => 'production',
            'status_waiting' => '',
            'status_in_analysis' => '',
            'status_pre_authorized' => '',
            'status_authorized' => '',
            'status_cancelled' => '',
            'status_refunded' => '',
            'status_reversed' => '',
            'status_settled' => '',
        ];
        $moip = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'moip_ticket');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Moip Boleto foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $environments = ['production' => 'Produção', 'sandbox' => 'Sandbox/Teste'];
        $this->set(compact('statuses', 'moip', 'ordersStatuses', 'environments'));
        $this->set('_serialize', 'moip');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function moipCreditCard()
    {
        $result = $this->Payments->findConfig('moip_credit_card');
        $entity = (object)[
            'status' => 0,
            'label' => 'Cartão de Crédito',
            'email' => '',
            'token' => '',
            'key' => '',
            'public_key' => '',
            'environment' => 'production',
            'status_waiting' => '',
            'status_in_analysis' => '',
            'status_pre_authorized' => '',
            'status_authorized' => '',
            'status_cancelled' => '',
            'status_refunded' => '',
            'status_reversed' => '',
            'status_settled' => '',
        ];
        $moip = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'moip_credit_card');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Moip Cartão de Crédito foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $environments = ['production' => 'Produção', 'sandbox' => 'Sandbox/Teste'];
        $this->set(compact('statuses', 'moip', 'ordersStatuses', 'environments'));
        $this->set('_serialize', 'moip');
    }

    public function deposit()
    {
        $result = $this->Payments->findConfig('deposit');
        $entity = (object)[
            'status' => 0,
            'instructions' => ''
        ];
        $deposit = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'deposit');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Depósito foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'deposit'));
        $this->set('_serialize', 'deposit');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function paypalExpress()
    {
        $result = $this->Payments->findConfig('paypal_express');
        $entity = (object)[
            'status' => 0,
            'label' => 'PayPal',
            'api_username' => '',
            'api_password' => '',
            'api_signature' => '',
            'client_id' => '',
            'client_secret' => '',
            'test' => 0,
            'status_waiting' => '',
            'status_authorized' => '',
            'status_cancelled' => ''
        ];
        $paypal_express = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'paypal_express');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do PayPal Express Checkout foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $tests = [0 => 'Não', 1 => 'Sim'];
        $this->set(compact('statuses', 'paypal_express', 'ordersStatuses', 'tests'));
        $this->set('_serialize', 'paypal_express');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function paypalPlus()
    {
        $result = $this->Payments->findConfig('paypal_plus');
        $entity = (object)[
            'status' => 0,
            'label' => 'PayPal Plus',
            'api_username' => '',
            'api_password' => '',
            'api_signature' => '',
            'client_id' => '',
            'client_secret' => '',
            'test' => 0,
            'status_created' => '',
            'status_approved' => '',
            'status_failed' => '',
            'email_sandbox' => ''
        ];
        $paypal_plus = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'paypal_plus');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do PayPal Plus foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $tests = [0 => 'Não', 1 => 'Sim'];
        $this->set(compact('statuses', 'paypal_plus', 'ordersStatuses', 'tests'));
        $this->set('_serialize', 'paypal_plus');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function mpCreditCard()
    {
        $result = $this->Payments->findConfig('mp_credit_card');
        $entity = (object)[
            'status' => 0,
            'label' => 'Mercado Pago Cartão de Crédito',
            'public_key' => '',
            'access_token' => '',
            'category' => '',
            'country' => 'MLB',
            'status_pending' => '',
            'status_approved' => '',
            'status_cancelled' => ''
        ];
        $mp_credit_card = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'mp_credit_card');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Mercado Pago Cartão de Cŕedito foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];

        $this->set(compact('statuses', 'mp_credit_card', 'ordersStatuses'));
        $this->set('_serialize', 'mp_credit_card');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function mpTicket()
    {
        $result = $this->Payments->findConfig('mp_ticket');
        $entity = (object)[
            'status' => 0,
            'label' => 'Mercado Pago Boleto',
            'public_key' => '',
            'access_token' => '',
            'category' => '',
            'country' => 'MLB',
            'status_pending' => '',
            'status_approved' => '',
            'status_cancelled' => '',
            'additional_days' => 2,
        ];
        $mp_ticket = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'mp_ticket');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Mercado Pago Boleto foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];

        $this->set(compact('statuses', 'mp_ticket', 'ordersStatuses'));
        $this->set('_serialize', 'mp_ticket');
    }

    public function pagseguroCreditCard()
    {
        $result = $this->Payments->findConfig('pagseguro_credit_card');
        $entity = (object)[
            'status' => 0,
            'label' => 'PagSeguro Cartão de Crédito',
            'email' => '',
            'environment' => 'production',
            'token' => '',
            'status_waiting_payment' => '',
            'status_payment_analysis' => '',
            'status_approved_payment' => '',
            'status_payment_dispute' => '',
            'status_canceled_payment' => '',
            'status_reversed_payment' => '',
            'status_chargeback_payment' => '',
            'sandbox_email' => ''
        ];
        $pagseguro_credit_card = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'pagseguro_credit_card');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do PagSeguro Cartão de Crédito foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $environments = ['production' => 'Produção', 'sandbox' => 'Sandbox'];
        $this->set(compact('statuses', 'pagseguro_credit_card', 'ordersStatuses', 'environments'));
        $this->set('_serialize', 'pagseguro');
        $this->set('notification_url', Router::url('/pagseguro/notification', true));
    }

    public function pagseguroTicket()
    {
        $result = $this->Payments->findConfig('pagseguro_ticket');
        $entity = (object)[
            'status' => 0,
            'label' => 'PagSeguro Boleto',
            'email' => '',
            'environment' => 'production',
            'token' => '',
            'status_waiting_payment' => '',
            'status_payment_analysis' => '',
            'status_approved_payment' => '',
            'status_payment_dispute' => '',
            'status_canceled_payment' => '',
            'status_reversed_payment' => '',
            'status_chargeback_payment' => '',
            'sandbox_email' => '',
            'show_logo' => 0
        ];
        $pagseguro_ticket = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'pagseguro_ticket');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do PagSeguro Boleto foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $environments = ['production' => 'Produção', 'sandbox' => 'Sandbox'];
        $this->set(compact('statuses', 'pagseguro_ticket', 'ordersStatuses', 'environments'));
        $this->set('_serialize', 'pagseguro');
        $this->set('notification_url', Router::url('/pagseguro/notification', true));
    }

    public function bradescoTicket()
    {
        $result = $this->Payments->findConfig('bradesco_ticket');
        $entity = (object)[
            'status' => 0,
            'label' => 'Bradesco Boleto',
            'additional_days' => '5',
            'initial_our_number' => '0',
            'agency' => '',
            'agency_digit' => '',
            'account' => '',
            'account_digit' => '',
            'account_wallet' => '',
            'identification' => '',
            'document' => '',
            'zipcode' => '',
            'address' => '',
            'neighborhood' => '',
            'city' => '',
            'state' => '',
            'assignor' => '',
            'demonstrative1' => '',
            'demonstrative2' => '',
            'demonstrative3' => '',
            'instructions1' => '',
            'instructions2' => '',
            'instructions3' => '',
            'instructions4' => '',
            'status_awaiting_payment' => '',
            'status_payment_approved' => '',
            'status_canceled' => '',
            'logo' => ''
        ];
        $bradesco_ticket = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'bradesco_ticket');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Bradesco Boleto foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        if (!empty($bradesco_ticket->logo)) {
            $bradesco_ticket->thumb_logo = Router::url("img" . DS . "files" . DS . "BradescoTickets" . DS . "thumbnail-" . $bradesco_ticket->logo, true);
            $bradesco_ticket->logo = Router::url(DS . "img" . DS . "files" . DS . "BradescoTickets" . DS . $bradesco_ticket->logo, true);
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'bradesco_ticket', 'ordersStatuses'));
        $this->set('_serialize', ['bradesco_ticket']);
    }

    public function cieloDebitCard()
    {
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $store = $Stores->findConfig('store');
        $result = $this->Payments->findConfig('cielo_debit_card');
        $entity = (object)[
            'label' => 'Cielo Cartão de Débito',
            'status' => 0,
            'merchant_id' => '',
            'merchant_key' => '',
            'environment' => 'production',
            'status_not_approval_payment' => '',
            'status_waiting_payment' => '',
            'status_payment_analysis' => '',
            'status_approved_payment' => '',
            'status_canceled_payment' => '',
            'return_url' => '',
            'address' => $store->address,
            'assignor' => $store->name,
            'demonstrative' => '',
            'instructions' => '',
            'expiration_date' => '',
            'identification' => '',
            'installment_free' => '',
            'installment' => '',
            'interest' => '',
            'installment_min' => '',
        ];
        $cielo_debit_card = $this->Payments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Payments->prepareSave($this->request->getData(), 'cielo_debit_card');
            $entities = $this->Payments->newEntities($data);
            if ($this->Payments->saveMany($entities)) {
                $this->Flash->success(__("Configurações da Cielo Cartão de Débito foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $environments = ['production' => 'Produção', 'sandbox' => 'Sandbox'];
        $this->set(compact('statuses', 'cielo_debit_card', 'ordersStatuses', 'environments'));
        $this->set('_serialize', 'cielo');
    }
}
