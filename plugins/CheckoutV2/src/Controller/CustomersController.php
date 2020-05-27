<?php

namespace CheckoutV2\Controller;

use Admin\Model\Table\ProductsRatingsTable;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Checkout\Model\Table\OrdersTable;
use Firebase\JWT\JWT;
use Mpdf\Tag\Q;

/**
 * Customers Controller
 *
 * @property \CheckoutV2\Model\Table\CustomersTable $Customers
 */
class CustomersController extends AppController
{
    private $genders;

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow([
            'login', 'register', 'confirm', 'completeRegister', 'lostPassword', 'resetPassword', 'emailsMarketings',
            'validateLinkRating'
        ]);
        $this->genders = ['Feminino' => 'Feminino', 'Masculino' => 'Masculino'];
        $this->loadComponent('CheckoutV2.Order');
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
     * @param Event $event
     * @return \Cake\Network\Response|void|null
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setTheme('CheckoutV2');
        $this->viewBuilder()->setLayout('CheckoutV2.checkout');
        $this->set(false, $this->_steps);
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

        if (!$this->Customers->Orders->exists(['id' => $orders_id, 'orders_statuses_id >' => 0, 'Orders.customers_id' => $this->Auth->user('id')])) {
            return $this->redirect(['controller' => 'customers', 'action' => 'orders']);
        }

        $this->pageTitle = 'Detalhes do meu pedido';

        $order = $this->Customers->Orders->get($orders_id, [
            'contain' => [
                'OrdersProducts' => [
                    'Products' => [
                        'ProductsImages',
                    ],
                    'OrdersProductsVariations' => function ($q) {
                        return $q->contain([
                            'Variations' => function ($q) {
                                return $q->contain([
                                    'VariationsGroups'
                                ]);
                            }
                        ]);
                    }
                ],
                'Customers',
                'OrdersStatuses',
                'OrdersHistories' => function ($q) {
                    return $q->contain(['OrdersStatuses']);
                },
            ]
        ]);

        $statuses = $this->Customers->Orders->OrdersStatuses->find()
            ->limit(5)
            ->toArray();

        $Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');
        $payment_method = $Payments->getConfig($order->payment_method . '_label');

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
            if ($customer->customers_types_id == 2) {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData(), ['validate' => 'companyPeople']);
            } else {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            }
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('Seus dados foram salvos.'));
                return $this->redirect(['action' => 'account']);
            }
            $this->Flash->error(__("Seus dados não foram salvos. Por favor, tente novamente."));
        }
        unset($customer->password);
        $customersTypes = $this->Customers->CustomersTypes->find('list')
            ->toArray();

        $this->set('genders', $this->genders);
        $this->set(compact('customer', 'customersTypes'));
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
        if ($this->Auth->user() && $this->Auth->user('rules_id') == 999) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        if ($this->request->is('post')) {
            $customer = $this->Auth->identify();
            if ($customer) {
                $customer['rules_id'] = 999;
                $session_id = $this->request->getSession()->id();
                $this->Auth->setUser($customer);
                $this->Cart->regenerateSessionId($session_id, $this->request->getSession()->id());

                $redirectUrl = $this->request->getQuery('redirect');
                if ($redirectUrl && preg_match('/http/', $redirectUrl)) {
                    $parse_url = parse_url($redirectUrl);
                    if (isset($parse_url['query']) && !empty($parse_url['query'])) {
                        $redirectUrl .= '&token=' . $customer['token'];
                    } else {
                        $redirectUrl .= '?token=' . $customer['token'];
                    }
                    return $this->redirect($redirectUrl);
                }

                return $this->redirect($this->Auth->redirectUrl());
            }
        }
        $this->Flash->error(__('E-mail/CPF ou senha incorretos.'));
        return $this->redirect($this->referer());
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $session_id = $this->request->getSession()->id();
        $this->Customers->destroyToken($this->Auth->user('id'));
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
        if ($this->Auth->user() && $this->Auth->user('rules_id') == 999) {
            return $this->redirect($this->Auth->redirectUrl());
        }

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

        $login_url = ['_name' => 'customer_login'];
        $register_url = ['_name' => 'customer_register'];
        if ($this->request->getQuery('redirect')) {
            $login_url['?'] = ['redirect' => $this->request->getQuery('redirect')];
            $register_url['?'] = ['redirect' => $this->request->getQuery('redirect')];
        }
        $login_url = Router::url($login_url, true);
        $register_url = Router::url($register_url, true);

        $this->pageTitle = 'Acessar / Cadastrar';
        $this->set(compact('customer', 'login_url', 'register_url'));
        $this->set('_serialize', ['customer', 'redirect']);
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function completeRegister()
    {
        $customer = $this->Customers->newEntity(null, ['associated' => ['CustomersAddresses']]);

        $customer->name = $this->request->getQuery('nome');
        $customer->email = $this->request->getQuery('email');

        if ($this->request->is(['post'])) {
            if ($this->request->getData('customers_types_id') == 2) {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses'], 'validate' => 'companyPeople']);
            } else {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses']]);
            }
            $customer->status = 1;

            if ($this->Customers->save($customer)) {
                $customer->rules_id = 999;
                $customer->token = $this->Customers->createToken($customer->id);
                $this->Auth->setUser($customer);
                $this->Flash->success(__("Seu cadastro foi realizado com sucesso."));
                $redirectUrl = $this->request->getQuery('redirect');
                if ($redirectUrl && preg_match('/http/', $redirectUrl)) {
                    $parse_url = parse_url($redirectUrl);
                    if (isset($parse_url['query']) && !empty($parse_url['query'])) {
                        $redirectUrl .= '&token=' . $customer->token;
                    } else {
                        $redirectUrl .= '?token=' . $customer->token;
                    }
                    return $this->redirect($redirectUrl);
                }

                return $this->redirect(['controller' => 'customers', 'action' => 'account']);
            }
            $this->Flash->error(__("Ocorreu um problema ao finalizar seu cadastro. Por favor, revise e tente novamente."));
        }
        unset($customer->password);
        unset($customer->password_confirm);

        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $garrula = $Stores->findConfig('garrula');
        isset($garrula->company_register) ? $company_register = $garrula->company_register : $company_register = false;

        $customersTypes = $this->Customers->CustomersTypes->find('list')
            ->toArray();

        $this->getTermsPage($this->store->terms_pages_id);
        $this->pageTitle = 'Cadastrar';
        $this->set('genders', $this->genders);
        $this->set(compact('customer', 'company_register', 'customersTypes'));
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

        $addresses = $this->Customers->CustomersAddresses->find()
            ->where(['customers_id' => $this->Auth->user('id')])
            ->limit(3);

        $orders = $this->Customers->Orders->find()
            ->contain([
                'OrdersProducts',
                'OrdersStatuses'
            ])
            ->where(['customers_id' => $this->Auth->user('id'), 'orders_statuses_id >' => 0])
            ->orderDesc('Orders.created')
            ->limit(3);

        $customer = $this->Customers->get($this->Auth->user('id'));

        $this->set(compact('addresses', 'orders', 'customer'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function lostPassword()
    {
        $this->pageTitle = 'Esqueci minha senha';

        if ($this->request->is(['post', 'put'])) {
            $login = preg_replace('/[^0-9]/', '', $this->request->getData('login'));
            if (is_numeric($login)) {
                $conditions = ['document_clean' => $login];
            } else {
                $conditions = ['email' => trim($this->request->getData('login'))];
            }

            $customer = $this->Customers->find()
                ->where($conditions)
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
            $emailsMarketings = TableRegistry::getTableLocator()->get('Admin.EmailsMarketings');

            $data = $this->request->getData();
            $data['ip'] = $this->request->clientIp();

            $emailsMarketing = $emailsMarketings->newEntity($data);

            if ($emailsMarketings->save($emailsMarketing)) {
                $json['status'] = true;
                $json['message'] = __('Obrigado por assinar nossa Newsletter, em breve você receberá novidades');
            } else {
                $errors = $emailsMarketing->getErrors();
                $json['status'] = false;
                $json['message'] = implode("<br>", $errors['email']);
            }
        }
        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }

    /**
     *
     */
    public function forceUpdateData()
    {
        $json = [
            'status' => false,
            'message' => 'Não foi possível salvar seus dados. Por favor, tente novamente.'
        ];
        if ($this->request->is(['post', 'put'])) {
            $customer = $this->Customers->get($this->Auth->user('id'));
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $json['status'] = true;
                $json['message'] = 'Seus dados foram salvos.';
            }
        }
        $this->set(compact('json'));
        $this->set('_serialize', ['json']);
    }

    /**
     * @param $token
     * @return \Cake\Http\Response|null
     */
    public function validateLinkRating($token)
    {
        try {
            $tokenValidate = JWT::decode($token, Security::getSalt(), ['HS256']);

            /** @var OrdersTable $OrdersTable */
            $OrdersTable = TableRegistry::getTableLocator()->get('CheckoutV2.Orders');
            $order = $OrdersTable->get($tokenValidate->orders_id, [
                'contain' => 'Customers'
            ]);

            $this->Auth->logout();

            $order->customer->rules_id = 999;
            $this->Auth->setUser($order->customer);

            return $this->redirect([
                'controller' => 'customers',
                'action' => 'products-ratings',
                $tokenValidate->orders_id,
                'plugin' => 'CheckoutV2'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), 'ProductRating');
            $this->Flash->error('Não foi possivel validar o link para avaliar sua compra');
            return $this->redirect('/');
        }
    }

    /**
     * @param $orders_id
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function productsRatings($orders_id)
    {
        /** @var OrdersTable $OrdersTable */
        $OrdersTable = TableRegistry::getTableLocator()->get('CheckoutV2.Orders');

        /** @var ProductsRatingsTable $ProductsRatingsTable */
        $ProductsRatingsTable = TableRegistry::getTableLocator()->get('Admin.ProductsRatings');

        $checkAnswered = $ProductsRatingsTable->checkAnswered($orders_id, $this->Auth->user('id'));
        if ($checkAnswered) {
            $this->Flash->success('Vocẽ já avaliou essa compra. Obrigado!');
            return $this->redirect([
                'controller' => 'customers',
                'action' => 'orders',
                'plugin' => 'CheckoutV2'
            ]);
        }

        $order = $OrdersTable->get($orders_id, [
            'contain' => [
                'Customers',
                'OrdersProducts' => function (Query $q) {
                    return $q->contain([
                        'Products' => function (Query $q) {
                            return $q->contain([
                                'ProductsImages' => function (Query $q) {
                                    return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                                }
                            ]);
                        },
                    ]);
                }
            ]
        ]);

        if ($this->request->is(['post'])) {
            $entities = [];
            foreach ($this->request->getData('rating') as $products_id => $rating) {
                if (empty($rating['rating']) && empty($rating['answer'])) {
                    continue;
                }

                $product = $ProductsRatingsTable->Products->get($products_id, [
                    'contain' => [
                        'ProductsImages' => function (Query $q) {
                            return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                        }
                    ]
                ]);

                $entities[] = [
                    'orders_id' => $orders_id,
                    'customers_id' => $order->customers_id,
                    'products_id' => $products_id,
                    'rating' => $rating['rating'],
                    'answer' => $rating['answer'],
                    'products_ratings_statuses_id' => 1,
                    'products_name' => $product->name,
                    'products_image' => $product->main_image
                ];
            }

            if (!$entities) {
                $this->Flash->error('Não foi possivel salvar sua avaliação. Por favor, tente novamente');
                return $this->redirect([
                    'controller' => 'customers',
                    'action' => 'products-ratings',
                    $orders_id,
                    'plugin' => 'CheckoutV2'
                ]);
            }

            $entities = $ProductsRatingsTable->newEntities($entities);
            if ($ProductsRatingsTable->saveMany($entities)) {
                $this->Flash->success('Recebemos sua avaliação. Obrigado!');
                return $this->redirect([
                    'controller' => 'customers',
                    'action' => 'orders',
                    'plugin' => 'CheckoutV2'
                ]);
            }
            $this->Flash->error('Não foi possivel salvar sua avaliação. Por favor, tente novamente');
        }

        if (!$order || $order->customers_id !== $this->Auth->user('id')) {
            $this->Flash->error('Pedido inválido para avaliar');
            return $this->redirect([
                'controller' => 'customers',
                'action' => 'orders',
                'plugin' => 'CheckoutV2'
            ]);
        }

        $this->pageTitle = 'Avaliações de produtos';
        $this->set(compact('order'));
    }
}
