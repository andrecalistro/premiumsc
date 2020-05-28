<?php

namespace Theme\Controller;

use Cake\Core\Configure;
use Cake\I18n\Date;
use Cake\ORM\TableRegistry;
use Cake\View\Helper\HtmlHelper;

/**
 * Customers Controller
 *
 * @property \Theme\Model\Table\CustomersTable $Customers
 */
class CustomersController extends AppController
{
    private $genders;

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['login', 'register', 'confirm', 'completeRegister', 'lostPassword', 'resetPassword', 'emailsMarketings']);
        $this->genders = ['Feminino' => 'Feminino', 'Masculino' => 'Masculino'];
        $this->loadComponent(Configure::read('Theme') . '.Order');
        $this->loadComponent('Recaptcha.Recaptcha', [
            'enable' => true,
            'sitekey' => $this->store->google_recaptcha_site_key,
            'secret' => $this->store->google_recaptcha_secret_key,
            'type' => 'image',
            'theme' => 'light',
            'lang' => 'pt-BR',
            'size' => 'normal'
        ]);
    }

    /**
     *
     */
    public function orders()
    {
        $this->pageTitle = 'Meus pedidos';

        $this->paginate = [
            'limit' => 10
        ];

        $orders = $this->paginate($this->Customers->Orders->find()
            ->contain([
                'OrdersProducts',
                'OrdersStatuses'
            ])
            ->where(['customers_id' => $this->Auth->user('id'), 'orders_statuses_id >' => 0])
            ->orderDesc('Orders.created')
        );

        $this->set(compact('orders'));
    }

    public function order($orders_id)
    {
        if (!$this->Customers->Orders->exists(['id' => $orders_id, 'orders_statuses_id >' => 0])) {
            return $this->redirect(['controller' => 'customers', 'action' => 'orders']);
        }

        $this->pageTitle = 'Detalhes do meu pedido';

        $order = $this->Customers->Orders->get($orders_id, [
            'contain' => [
                'OrdersProducts' => [
                    'Products' => [
                        'ProductsImages',
                    ],
                    'OrdersProductsVariations' => function($q) {
                        return $q->contain([
                            'Variations' => function($q) {
                                return $q->contain([
                                    'VariationsGroups'
                                ]);
                            }
                        ]);
                    }
                ],
                'Customers',
                'OrdersStatuses',
                'OrdersHistories'
            ]
        ]);

        $statuses = $this->Customers->Orders->OrdersStatuses->find()
            ->limit(5)
            ->toArray();


        switch ($order->payment_method) {
            case 'ticket':
                $payment_method = 'Boleto';
                break;
            case 'credit-card':
                $payment_method = 'Cartão de Crédito';
                break;
            case 'debit-card':
                $payment_method = 'Cartão de Débito';
                break;
            default:
                break;
        }

        $this->set(compact('order', 'statuses', 'payment_method'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function account()
    {
        $this->pageTitle = 'Meus dados';
        $customer = $this->Customers->get($this->Auth->user('id'));
        if ($this->request->is(['post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('Seus dados foram salvos.'));
                return $this->redirect(['action' => 'account']);
            }
            $this->Flash->error(__("Seus dados não foram salvos. Por favor, tente novamente."));
        }
        unset($customer->password);
        $this->set('genders', $this->genders);
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function changePassword()
    {
        $this->pageTitle = 'Alterar senha';
        $customer = $this->Customers->get($this->Auth->user('id'));

        if ($this->request->is(['post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('Sua senha foi alterada.'));
                return $this->redirect(['action' => 'change-password']);
            }
            $this->Flash->error(__("Sua senha não foi alterada. Por favor, tente novamente."));
        }
        unset($customer->password);

        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function login()
    {
        if ($this->request->is('post')) {
            $customer = $this->Auth->identify();
            if ($customer) {
                $customer['rules_id'] = 999;
                $session_id = $this->request->getSession()->id();
                $this->Auth->setUser($customer);
                $this->Cart->regenerateSessionId($session_id, $this->request->getSession()->id());
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
        $this->Flash->error(__('E-mail/CPF ou senha incorretos.'));
        return $this->redirect(['action' => 'register']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $session_id = $this->request->getSession()->id();
        $this->Auth->logout();
        $this->Cart->regenerateSessionId($session_id, $this->request->getSession()->id());
        $this->request->getSession()->delete('orders_id');
        return $this->redirect(['controller' => 'customers', 'action' => 'register']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function register()
    {
        $customer = $this->Customers->newEntity();

        if ($this->request->is(['post'])) {
            $customer = $this->Customers->find()
                ->where(['email' => $this->request->getData('email')])
                ->first();
            if (!$customer) {
                $this->redirect(['action' => 'complete-register', 'nome' => $this->request->getData('name'), 'email' => $this->request->getData('email')]);
            } else {
                $this->Flash->error(__("Já existe um cadastro com esse e-mail."));
            }
        }

        unset($customer->password);
        unset($customer->password_confirm);

        $this->pageTitle = 'Acessar / Cadastrar';
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function completeRegister()
    {
        $customer = $this->Customers->newEntity(null, ['associated' => ['CustomersAddresses']]);

        $customer->name = $this->request->getQuery('nome');
        $customer->email = $this->request->getQuery('email');

        if ($this->request->is(['post'])) {
//            if ($this->Recaptcha->verify()) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses']]);
            $customer->status = 1;
            $customer->birth_date = Date::createFromFormat('d/m/Y', $this->request->getData('birth_date'));
            if ($this->Customers->save($customer)) {
//                    $this->Customers->CustomersConfirmations->sendConfirmationEmail($customer, $this->store);
                $customer->rules_id = 999;
                $this->Auth->setUser($customer);
                $this->Flash->success(__("Seu cadastro foi realizado com sucesso."));
                return $this->redirect(['controller' => 'customers', 'action' => 'dashboard']);
            }
            $this->Flash->error(__("Ocorreu um problema ao finalizar seu cadastro. Por favor, revise e tente novamente."));
//            } else {
//                $this->Flash->error(__('Você precisa confirmar que não é um robo.'));
//            }
        }

        unset($customer->password);
        unset($customer->password_confirm);
        $this->getTermsPage($this->store->terms_pages_id);
        $this->pageTitle = 'Cadastrar';
        $this->set('genders', $this->genders);
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * @param null $token
     * @return \Cake\Http\Response|null
     */
    public function confirm($token = null)
    {
        if (!$token) {
            return $this->redirect(['action' => 'register']);
        }

        $confirm = $this->Customers->CustomersConfirmations->find()
            ->contain('Customers')
            ->where(['token' => $token])
            ->first();

        if ($confirm) {
            $customer = $this->Customers->patchEntity($confirm->customer, ['status' => 1]);
            if ($this->Customers->save($customer)) {
                $this->Customers->CustomersConfirmations->delete($confirm);
                $this->Flash->success(__('Sua conta foi confirmada.'));
            }
        }
        return $this->redirect(['action' => 'register']);
    }

    /**
     *
     */
    public function dashboard()
    {
        $this->pageTitle = "Minha conta";

        $address = $this->Customers->CustomersAddresses->find()
            ->where(['customers_id' => $this->Auth->user('id')])
            ->first();

        $order = $this->Customers->Orders->find()
            ->contain([
                'OrdersProducts',
                'OrdersStatuses'
            ])
            ->where(['customers_id' => $this->Auth->user('id'), 'orders_statuses_id >' => 0])
            ->orderDesc('Orders.created')
            ->first();

        $this->set(compact('address', 'order'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function lostPassword()
    {
        $this->pageTitle = 'Esqueci minha senha';

        if ($this->request->is(['post', 'put'])) {
            $customer = $this->Customers->find()
                ->where(['email' => $this->request->getData('login')])
                ->orWhere(['document_clean' => preg_replace('/[^0-9]/', '', $this->request->getData('login'))])
                ->first();

            if ($customer) {
                if ($this->Customers->CustomersResets->sendLostPasswordEmail($customer, $this->store)) {
                    $this->Flash->success(__("Enviamos um e-mail para você redefinir sua senha."));
                    return $this->redirect(['controller' => 'customers', 'action' => 'register']);
                }
            }
            $this->Flash->error(__("E-mail ou CPF não encontrado. Por favor, tente novamente"));
            return $this->redirect(['controller' => 'customers', 'action' => 'lost-password']);
        }
    }

    public function resetPassword($token = null)
    {
        $this->pageTitle = "Redefinir senha";
        if (!$token) {
            return $this->redirect(['action' => 'register']);
        }

        $reset = $this->Customers->CustomersResets->find()
            ->contain('Customers')
            ->where(['token' => $token])
            ->first();
        $customer = $reset->customer;
        if ($reset) {
            if ($this->request->is(['post', 'put'])) {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData());
                if ($this->Customers->save($customer)) {
                    $this->Customers->CustomersResets->delete($reset);
                    $this->Flash->success(__('Sua senha foi alterada.'));
                    return $this->redirect(['controller' => 'customers', 'action' => 'register']);
                }
                $this->Flash->error(__("Sua senha não foi alterada. Por favor, revise e tente novamente."));
            }
        } else {
            $this->Flash->error(__("Token inválido."));
            return $this->redirect(['action' => 'register']);
        }
        unset($customer->password);
        $this->set('customer', $customer);
    }

    /**
     *
     */
    public function emailsMarketings()
    {
        if ($this->request->is(['post', 'put'])) {
            $emailsMarketings = TableRegistry::get('EmailsMarketings');

            $emailsMarketing = $emailsMarketings->newEntity($this->request->getData());

            if ($emailsMarketings->save($emailsMarketing)) {
                $json['status'] = true;
                $json['message'] = __('Obrigado por assinar nossa Newsletter, em breve você receberá novidades');
            } else {
                $errors = $emailsMarketing->errors();
                $json['status'] = false;
                $json['message'] = implode("<br>", $errors['email']);
            }
        }
        $this->set(compact('json'));
    }
}
