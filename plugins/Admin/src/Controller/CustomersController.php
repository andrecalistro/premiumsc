<?php

namespace Admin\Controller;

use Cake\I18n\Date;
use Cake\ORM\TableRegistry;

/**
 * Customers Controller
 *
 * @property \Admin\Model\Table\CustomersTable $Customers
 */
class CustomersController extends AppController
{
    /**
     *
     */
    public function index()
    {
        $conditions = [];
        $filter = [
            'name' => '',
            'email' => '',
            'document' => '',
            'created' => '',
            'company_document' => ''
        ];

        if ($this->request->getQuery('name')) {
            $conditions[] = ['Customers.name LIKE' => "%{$this->request->getQuery('name')}%"];
            $filter['name'] = $this->request->getQuery('name');
        }

        if ($this->request->getQuery('email')) {
            $conditions[] = ['Customers.email LIKE' => "%{$this->request->getQuery('email')}%"];
            $filter['email'] = $this->request->getQuery('email');
        }

        if ($this->request->getQuery('document')) {
            $conditions[] = ['Customers.document_clean' => preg_replace('/\D/', '', $this->request->getQuery('document'))];
            $filter['document'] = $this->request->getQuery('document');
        }

        if ($this->request->getQuery('company_document')) {
            $conditions[] = ['Customers.document_clean' => preg_replace('/\D/', '', $this->request->getQuery('company_document'))];
            $filter['company_document'] = $this->request->getQuery('company_document');
        }

        if ($this->request->getQuery('created')) {
            $created = Date::createFromFormat('d/m/Y', $this->request->getQuery('created'));
            $conditions[] = [
                'DAY(Customers.created)' => $created->format('d'),
                'MONTH(Customers.created)' => $created->format('m'),
                'YEAR(Customers.created)' => $created->format('Y')
            ];
            $filter['created'] = $this->request->getQuery('created');
        }

        $this->paginate = [
            'contain' => [
                'CustomersAddresses',
                'Orders' => function ($q) {
                    return $q->where(['Orders.orders_statuses_id > ' => 1]);
                }
            ],
            'conditions' => $conditions,
            'limit' => 100
        ];
        $customers = $this->paginate($this->Customers);
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $main = $Stores->findConfig('main');
        isset($main->company_register) ? $company_register = $main->company_register : $company_register = false;

        $this->set(compact('customers', 'filter', 'company_register'));
        $this->set('_serialize', ['customers']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => [
                'CustomersAddresses',
                'Orders' => function ($q) {
                    return $q->contain(['OrdersStatuses', 'OrdersProducts', 'PaymentsMethods'])
                        ->where(['Orders.orders_statuses_id >' => 0]);
                },
                'CustomersTypes'
            ]
        ]);

        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $main = $Stores->findConfig('main');
        isset($main->company_register) ? $company_register = $main->company_register : $company_register = false;
        $referer = $this->referer();

        $this->set(compact('customer', 'company_register', 'referer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customer = $this->Customers->newEntity();
        if ($this->request->is('post')) {
            if ($this->request->getData('customers_types_id') == 2) {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses'], 'validate' => 'companyPeople']);
            } else {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses']]);
            }
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('O cliente foi salvo.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O cliente não foi salvo. Por favore, tente novamente.'));
        }
        $statuses = [0 => 'Inativo', 1 => 'Ativo'];

        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $main = $Stores->findConfig('main');
        isset($main->company_register) ? $company_register = $main->company_register : $company_register = false;
        $customersTypes = $this->Customers->CustomersTypes->find('list')
            ->toArray();

        $referer = $this->referer();

        $this->set(compact('customer', 'statuses', 'company_register', 'customersTypes', 'referer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => ['CustomersAddresses']
        ]);
        unset($customer->password);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->request->getData('customers_types_id') == 2) {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses'], 'validate' => 'companyPeople']);
            } else {
                $customer = $this->Customers->patchEntity($customer, $this->request->getData(), ['associated' => ['CustomersAddresses']]);
            }
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('O cliente foi salvo.'));
                return $this->redirect($this->request->getSession()->read('referer-edit-customer'));
            }
            $this->Flash->error(__('O cliente não foi salvo. Por favor, tente novamente.'));
        }
        $this->request->getSession()->write('referer-edit-customer', $this->referer());
        $this->set('referer', $this->request->getSession()->read('referer-edit-customer'));
        $statuses = [0 => 'Inativo', 1 => 'Ativo'];

        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $main = $Stores->findConfig('main');
        isset($main->company_register) ? $company_register = $main->company_register : $company_register = false;
        $customersTypes = $this->Customers->CustomersTypes->find('list')
            ->toArray();

        $this->set(compact('customer', 'statuses', 'customersTypes', 'company_register'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('O cliente foi excluído.'));
        } else {
            $this->Flash->error(__('O cliente não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     *
     */
    public function find()
    {
        $conditions = [];
        if ($this->request->getQuery('q')) {
            $query = preg_replace('/\D/', '', $this->request->getQuery('q'));
            if (is_numeric($query)) {
                $conditions = [
                    'OR' => [
                        'Customers.document_clean' => $query
                    ]
                ];
            } else {
                $conditions = [
                    'OR' => [
                        'Customers.name LIKE' => "%{$this->request->getQuery('q')}%",
                        'Customers.email LIKE' => "%{$this->request->getQuery('q')}%"
                    ]
                ];
            }
        }
        $conditions[] = [
            'Customers.name <>' => '',
            'Customers.name is not' => null
        ];

        $items = $this->Customers->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
            ->contain([
                'CustomersAddresses'
            ])
            ->where($conditions)
            ->limit(30)
            ->order(['Customers.name' => 'ASC'])
            ->toArray();

        $this->set(compact('items'));
        $this->set('_serialize', ['items']);
    }
}
