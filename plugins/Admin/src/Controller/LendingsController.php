<?php

namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\I18n\Date;
use Cake\ORM\TableRegistry;
use Cake\View\View;

/**
 * Lendings Controller
 *
 * @property \Admin\Model\Table\LendingsTable $Lendings
 * @property \Admin\Model\Table\EmailTemplatesTable $EmailTemplates
 *
 * @method \Admin\Model\Entity\Lending[] paginate($object = null, array $settings = [])
 */
class LendingsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
            'order' => ['Lendings.created' => 'desc']
        ];
        $lendings = $this->paginate($this->Lendings);

        $this->set(compact('lendings'));
        $this->set('_serialize', ['lendings']);
    }

    /**
     * View method
     *
     * @param string|null $id Lending id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lending = $this->Lendings->get($id, [
            'contain' => [
                'Users',
                'Products' => function ($q) {
                    return $q->contain('ProductsImages');
                }
            ]
        ]);

        $this->set('lending', $lending);
        $this->set('_serialize', ['lending']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lending = $this->Lendings->newEntity();

        if ($this->request->is('post')) {
            $lending = $this->Lendings->patchEntity($lending, $this->request->getData());
            $lending->users_id = $this->Auth->user('id');

            if ($this->request->getData('send_date') && $this->request->getData('send_date') != '') {
                $date = Date::createFromFormat('d/m/Y', $this->request->getData('send_date'));
                $lending->send_date = $date;
            } else {
                $lending->send_date = null;
            }

            if ($this->Lendings->save($lending)) {
                foreach ($lending->products as $product) {
                    $product->status = 5;
                    $this->Lendings->Products->save($product);
                }

                $this->Flash->success(__('O comodato foi salvo.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O comodato não pode ser salvo. Por favor, tente novamente.'));
        }

        $statuses = [0 => 'Não enviado para o cliente', 1 => 'Enviado para o cliente'];
        $products = $this->Lendings->Products->find('all', [
            'conditions' => [
                'stock >' => 0,
                'status' => 1
            ],
            'contain' => [
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC']);
                },
            ]
        ]);
        $this->set(compact('lending', 'products', 'statuses'));
        $this->set('_serialize', ['lending']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lending id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lending = $this->Lendings->get($id, [
            'contain' => [
                'Products' => function ($q) {
                    return $q->contain('ProductsImages');
                }
            ]
        ]);

        if ($lending->status == 1) {
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $lending = $this->Lendings->patchEntity($lending, $this->request->getData());

            if ($this->request->getData('send_date') && $this->request->getData('send_date') != '') {
                $date = Date::createFromFormat('d/m/Y', $this->request->getData('send_date'));
                $lending->send_date = $date;
            } else {
                $lending->send_date = null;
            }

            if ($this->Lendings->save($lending)) {
                foreach ($lending->products as $product) {
                    $product->status = 5;
                    $this->Lendings->Products->save($product);
                }

                $this->Flash->success(__('O comodato foi salvo.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O comodato não pode ser salvo. Por favor, tente novamente.'));
        }

        $statuses = [0 => 'Não enviado para o cliente', 1 => 'Enviado para o cliente'];
        $products = $this->Lendings->Products->find('all', [
            'limit' => 200,
            'conditions' => [
                'stock >' => 0,
                'status' => 1
            ],
            'contain' => [
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC']);
                },
            ]
        ]);

        $selected_ids = [];
        foreach ($lending->products as $product) {
            $selected_ids[] = $product->id;
        }

        $products = $lending->products + $products->toArray();
        $this->set(compact('lending', 'products', 'selected_ids', 'statuses'));
        $this->set('_serialize', ['lending']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lending id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lending = $this->Lendings->get($id);
        if ($this->Lendings->delete($lending)) {
            $this->Flash->success(__('The lending has been deleted.'));
        } else {
            $this->Flash->error(__('The lending could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function finalize($id = null)
    {
        $lending = $this->Lendings->get($id, [
            'contain' => [
                'Users',
                'Products' => function ($q) {
                    return $q->contain('ProductsImages');
                }
            ]
        ]);

        if ($lending->status == 1) {
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $lending = $this->Lendings->patchEntity($lending, $data);

            if ($this->Lendings->save($lending)) {
                foreach ($lending->products as $product) {
                    if ($product->_joinData->status) {
                        $product->status = 4;
                        $product->stock = $product->stock - 1;
                    } else {
                        $product->status = 1;
                    }

                    $this->Lendings->Products->save($product);
                }

                $this->Flash->success(__('O comodato foi salvo.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O comodato não pode ser salvo. Por favor, tente novamente.'));
        }

        $this->set(compact('lending'));
        $this->set('_serialize', ['lending']);
    }

    public function cancel($id = null)
    {
        $lending = $this->Lendings->get($id, [
            'contain' => [
                'Products' => function ($q) {
                    return $q->contain('ProductsImages');
                }
            ]
        ]);

        if ($lending->status > 0) {
            return $this->redirect(['action' => 'index']);
        }

        foreach ($lending->products as $product) {
            $product->status = 1;
            $this->Lendings->Products->save($product);
        }

        $lending->status = 2; //cancelado
        $this->Lendings->save($lending);

        $this->Flash->success(__("Orçamento #" . $lending->id . " foi canelado."));
        return $this->redirect(['controller' => 'lendings', 'action' => 'index']);
    }

    /**
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function sendEmail($id = null)
    {
        $lending = $this->Lendings->get($id, [
            'contain' => [
                'Users',
                'Products' => function ($q) {
                    return $q->contain('ProductsImages');
                }
            ]
        ]);

        $productsValue = 0;

        foreach ($lending->products as $product) {
            $productsValue += $product->price_final['regular'];
        }

        $view = new View($this->request, $this->response);
        $EmailTemplates = TableRegistry::getTableLocator()->get('Admin.EmailTemplates');
        $EmailQueues = TableRegistry::getTableLocator()->get('Admin.EmailQueues');

        $template = $EmailTemplates->find()
            ->where(['slug' => 'novo-comodato'])
            ->first();

        $productsHtml = $view->element('Admin.Lending/email_products', ['products' => $lending->products]);

        $data = [
            'lendings_id' => $lending->id,
            'customer_name' => $lending->customer_name,
            'customer_email' => $lending->customer_email,
            'products' => $productsHtml,
            'products_number' => count($lending->products),
            'products_value' => 'R$ ' . number_format($productsValue, 2, ',', '.'),
            'send_date' => !is_null($lending->send_date) ? $lending->send_date->format('d/m/Y') : 'Produtos ainda não foram enviados'
        ];

        $html = $EmailTemplates->buildHtml($template, $data);

        $email = $EmailQueues->newEntity([
            'from_name' => $template->from_name,
            'from_email' => $template->from_email,
            'subject' => $template->subject,
            'content' => $html,
            'to_name' => $lending->customer_name,
            'to_email' => $lending->customer_email,
            'email_statuses_id' => 1,
            'reply_name' => $template->reply_name,
            'reply_email' => $template->reply_email
        ]);

        $EmailQueues->save($email);

        $this->Flash->success(__('As informações do comodato foram enviadas para o cliente!'));
        return $this->redirect($this->referer());
    }

    /**
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function sendProducts($id = null)
    {
        $lending = $this->Lendings->get($id, [
            'contain' => [
                'Users',
                'Products' => function ($q) {
                    return $q->contain('ProductsImages');
                }
            ]
        ]);

        $lending->send_date = Date::now('America/Sao_Paulo');
        $lending->send_status = 1;

        if ($this->Lendings->save($lending)) {
            $this->Flash->success(__('O orçamento #' . $lending->id . ' foi marcado como enviado para o cliente.'));
        } else {
            $this->Flash->error(__('Ocorreu um problema ao marcar o orçamento #' . $lending->id . ' como enviado para o cliente.  Por favor, tente novamente.'));
        }

        return $this->redirect(['controller' => 'lendings', 'action' => 'index']);
    }

    /**
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function exportPdf($id = null)
    {
        $lending = $this->Lendings->get($id, [
            'contain' => [
                'Users',
                'Products' => function ($q) {
                    return $q->contain('ProductsImages');
                }
            ]
        ]);

        $productsValue = 0;

        foreach ($lending->products as $product) {
            $productsValue += $product->price_final['regular'];
        }

        $view = new View($this->request, $this->response);
        $EmailTemplates = TableRegistry::getTableLocator()->get('Admin.EmailTemplates');

        $template = $EmailTemplates->find()
            ->where(['slug' => 'novo-comodato'])
            ->first();

        $productsHtml = $view->element('Admin.Lending/email_products', ['products' => $lending->products]);

        $data = [
            'lendings_id' => $lending->id,
            'customer_name' => $lending->customer_name,
            'customer_email' => $lending->customer_email,
            'products' => $productsHtml,
            'products_number' => count($lending->products),
            'products_value' => 'R$ ' . number_format($productsValue, 2, ',', '.'),
            'send_date' => !is_null($lending->send_date) ? $lending->send_date->format('d/m/Y') : 'Produtos ainda não foram enviados'
        ];

        $html = $EmailTemplates->buildHtml($template, $data);

        $this->viewBuilder()->setOptions([
            'pdfConfig' => [
                'filename' => 'Orcamento_' . $id
            ]
        ]);

        $this->set(compact('html'));
    }
}