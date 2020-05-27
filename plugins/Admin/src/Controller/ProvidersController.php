<?php

namespace Admin\Controller;

use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\Http\Session;
use Cake\ORM\TableRegistry;
use Cake\View\View;

/**
 * Providers Controller
 *
 * @property \Admin\Model\Table\ProvidersTable $Providers
 *
 * @method \Admin\Model\Entity\Provider[] paginate($object = null, array $settings = [])
 */
class ProvidersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $conditions = [];
        $filter = [
            'name' => '',
            'email' => '',
            'telephone' => '',
            'bank' => '',
            'agency' => '',
            'account' => ''
        ];

        if ($this->request->getQuery('name')) {
            $conditions[] = ['Providers.name LIKE' => "%{$this->request->getQuery('name')}%"];
            $filter['name'] = $this->request->getQuery('name');
        }

        if ($this->request->getQuery('email')) {
            $conditions[] = ['Providers.email LIKE' => "%{$this->request->getQuery('email')}%"];
            $filter['email'] = $this->request->getQuery('email');
        }

        if ($this->request->getQuery('telephone')) {
            $conditions[] = ['Providers.telephone' => "{$this->request->getQuery('telephone')}"];
            $filter['telephone'] = $this->request->getQuery('telephone');
        }

        if ($this->request->getQuery('bank')) {
            $conditions[] = ['Providers.bank LIKE' => "%{$this->request->getQuery('bank')}%"];
            $filter['bank'] = $this->request->getQuery('bank');
        }

        if ($this->request->getQuery('agency')) {
            $conditions[] = ['Providers.telephone' => "{$this->request->getQuery('agency')}"];
            $filter['agency'] = $this->agency->getQuery('agency');
        }

        if ($this->request->getQuery('account')) {
            $conditions[] = ['Providers.account' => "{$this->request->getQuery('account')}"];
            $filter['account'] = $this->request->getQuery('account');
        }

        $this->paginate = [
            'conditions' => $conditions
        ];

        $providers = $this->paginate($this->Providers);

        $this->set(compact('providers', 'filter'));
        $this->set('_serialize', ['providers']);
    }

    /**
     * View method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $provider = $this->Providers->get($id, [
            'contain' => [
                'Products' => function ($q) {
                    return $q->contain(['ProductsImages', 'ProductsStatuses']);
                },
            ]
        ]);

        $commissions = [
            'total' => 0,
            'received' => 0,
            'toReceive' => 0
        ];

        foreach ($provider->products as $key => $product) {
            $commission = ($provider->commission * $product->price_final['regular']) / 100;
            $commissions['total'] += $commission;

            $provider->products[$key]->commission = [
                'regular' => $commission,
                'formatted' => 'R$ ' . number_format($commission, 2, ',', '')
            ];

            if ($product->status == 4 && $product->providers_payment_status) {
                $commissions['received'] += $commission;
            } else {
                $commissions['toReceive'] += $commission;
            }
        }

        if ($this->request->is('post')) {
            $requestData = $this->request->getData();

            if (isset($requestData['submit'])) {
                $received = $toReceive = [
                    'total' => [
                        'regular' => 0,
                        'formatted' => ''
                    ],
                    'commission' => [
                        'regular' => 0,
                        'formatted' => ''
                    ],
                    'products' => []
                ];

                switch ($requestData['submit']) {
                    case 'export':
                        break;

                    case 'send-email':
                        $i = 0;
                        foreach ($provider->products as $product) {
                            if (in_array($product->id, $requestData['products_id'])) {
                                if ($product->status == 4 && $product->providers_payment_status) {
                                    $received['total']['regular'] += $product->price_final['regular'];
                                    $received['commission']['regular'] += $product->commission['regular'];
                                    $received['products'][] = $product;
                                } else {
                                    $toReceive['total']['regular'] += $product->price_final['regular'];
                                    $toReceive['commission']['regular'] += $product->commission['regular'];
                                    $toReceive['products'][] = $product;
                                }

                                $i++;
                            }
                        }

                        $received['total']['formatted'] = 'R$ ' . number_format($received['total']['regular'], 2, ',', '');
                        $toReceive['total']['formatted'] = 'R$ ' . number_format($toReceive['total']['regular'], 2, ',', '');
                        $received['commission']['formatted'] = 'R$ ' . number_format($received['commission']['regular'], 2, ',', '');
                        $toReceive['commission']['formatted'] = 'R$ ' . number_format($toReceive['commission']['regular'], 2, ',', '');

                        if ($i == 0) {
                            $this->Flash->error(__('Nenhum produto selecionado.'));
                            return $this->redirect($this->referer());
                        }

                        $view = new View($this->request, $this->response);
                        $EmailTemplates = TableRegistry::getTableLocator()->get('Admin.EmailTemplates');
                        $EmailQueues = TableRegistry::getTableLocator()->get('Admin.EmailQueues');

                        $template = $EmailTemplates->find()
                            ->where(['slug' => 'relatorio-fornecedor'])
                            ->first();

                        $toReceiveHtml = $view->element('Admin.Provider/report_products', ['products' => $toReceive['products']]);
                        $receivedHtml = $view->element('Admin.Provider/report_products', ['products' => $received['products']]);

                        $data = [
                            'provider_name' => $provider->name,
                            'to_sell_products' => $toReceiveHtml,
                            'to_sell_total_price' => $toReceive['total']['formatted'],
                            'to_sell_provider_price' => $toReceive['commission']['formatted'],
                            'sold_products' => $receivedHtml,
                            'sold_total_price' => $received['total']['formatted'],
                            'sold_provider_price' => $received['commission']['formatted']
                        ];

                        $html = $EmailTemplates->buildHtml($template, $data);

                        $email = $EmailQueues->newEntity([
                            'from_name' => $template->from_name,
                            'from_email' => $template->from_email,
                            'subject' => $template->subject,
                            'content' => $html,
                            'to_name' => $provider->name,
                            'to_email' => $provider->email,
                            'email_statuses_id' => 1,
                            'reply_name' => $template->reply_name,
                            'reply_email' => $template->reply_email
                        ]);

                        $EmailQueues->save($email);
                        $this->Flash->success(__('E-mail dos produtos foi enviado para o fornecedor!'));
                        break;

                    default:
                        break;
                }

				return $this->redirect($this->referer());
            }
        }

        $this->set('provider', $provider);
        $this->set('commissions', $commissions);
        $this->set('_serialize', ['provider', 'commissions']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $provider = $this->Providers->newEntity();
        if ($this->request->is('post')) {
            $provider = $this->Providers->patchEntity($provider, $this->request->getData());
            if ($this->Providers->save($provider)) {
                $this->Flash->success(__('O fornecedor foi salvo.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O fornecedor não foi salvo. Por favor, tente novamente.'));
        }
        $statuses = [0 => 'Inativo', 1 => 'Ativo'];
        $this->set(compact('provider', 'statuses'));
        $this->set('_serialize', ['provider']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $provider = $this->Providers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $provider = $this->Providers->patchEntity($provider, $this->request->getData());
            if ($this->Providers->save($provider)) {
                $this->Flash->success(__('O fornecedor foi salvo.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O fornecedor não foi salvo. Por favor, tente novamente.'));
        }
        $statuses = [0 => 'Inativo', 1 => 'Ativo'];
        $this->set(compact('provider', 'statuses'));
        $this->set('_serialize', ['provider']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $provider = $this->Providers->get($id);
        if ($this->Providers->delete($provider)) {
            $this->Flash->success(__('O fornecedor foi excluído.'));
        } else {
            $this->Flash->error(__('O fornecedor não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param null $providers_id
     * @return \Cake\Http\Response|null
     */
    public function lending($providers_id = null)
    {
        $provider = $this->Providers->get($providers_id, [
            'contain' => [
                'Products' => function ($q) {
                    return $q->contain(['ProductsImages', 'ProductsStatuses']);
                },
            ]
        ]);

        if ($this->request->getData('products_id')) {
            $products_send = [];
            foreach ($provider->products as $product) {
                if (in_array($product->id, $this->request->getData('products_id'))) {
                    if ($product->status == 1) {
                        $products_send[] = $product;
                        $product->status = 5;
                        $this->Providers->Products->save($product);
                    }
                }
            }

            if (!$products_send) {
                $this->Flash->error('Nenhum produto com status disponivel foi selecionado');
                return $this->redirect(['controller' => 'providers', 'action' => 'view', $providers_id]);
            }
        } else {
            $this->Flash->error('Nenhum produto selecionado');
            return $this->redirect(['controller' => 'providers', 'action' => 'view', $providers_id]);
        }
        $date = Time::now('America/Sao_Paulo');
        $this->viewBuilder()->setOptions([
            'pdfConfig' => [
                'filename' => 'Produtos_Comodato_' . $date->format('Y-m-d-H-i-s')
            ]
        ]);
        $date = $date->format('d/m/Y H:i');

        $this->set(compact('products_send', 'provider', 'date'));
    }

}
