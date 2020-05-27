<?php

namespace Admin\Controller;

use Admin\Model\Table\CustomersTable;
use Admin\Model\Table\DiscountsGroupsCustomersTable;
use Cake\Http\Response;
use Cake\I18n\Date;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Zend\Diactoros\Response\JsonResponse;

/**
 * DiscountsGroups Controller
 *
 * @property \Admin\Model\Table\DiscountsGroupsTable $DiscountsGroups
 * @property \Admin\Model\Table\CustomersTable $Customers
 */
class DiscountsGroupsController extends AppController
{
    /**
     *
     */

    public $discounts_type = [
        'fixed' => 'Desconto fixo (R$)',
        'percentage' => 'Desconto em porcentagem (%)'
    ];

    public $free_shipping = [
        '1' => 'Sim',
        '0' => 'Não'
    ];

    public function index()
    {
        $conditions = [];
        $filter = [
            'name' => ''
        ];

        if ($this->request->getQuery('name')) {
            $conditions[] = ['DiscountsGroups.name LIKE' => "%{$this->request->getQuery('name')}%"];
            $filter['name'] = $this->request->getQuery('name');
        }

        $this->paginate = [
            'conditions' => $conditions,
            'limit' => 100
        ];
        $discountsGroups = $this->paginate($this->DiscountsGroups);

        $this->set(compact('discountsGroups', 'filter'));
    }

    public function add()
    {
        $discountsGroups = $this->DiscountsGroups->newEntity();
        $discounts_type = $this->discounts_type;
        $free_shipping = $this->free_shipping;

        if ($this->request->is('post')) {
            $discountsGroups = $this->DiscountsGroups->patchEntity($discountsGroups, $this->request->getData());

            if ($this->DiscountsGroups->save($discountsGroups)) {
                $this->Flash->success(__('O grupo de desconto foi salvo!'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O grupo de desconto não pode ser salvo. Por favor, tente novamente.'));
        }

        $this->set(compact('discounts_type', 'free_shipping', 'discountsGroups'));
    }

    /**
     * @param $id
     * @return Response|null
     */
    public function edit($id)
    {
        $discountsGroup = $this->DiscountsGroups->get($id);
        $discounts_type = $this->discounts_type;
        $free_shipping = $this->free_shipping;

        if ($this->request->is(['post', 'put'])) {
            $discountsGroup = $this->DiscountsGroups->patchEntity($discountsGroup, $this->request->getData());

            if ($this->DiscountsGroups->save($discountsGroup)) {
                $this->Flash->success(__('O grupo de desconto foi salvo!'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O grupo de desconto não pode ser salvo. Por favor, tente novamente.'));
        }
        $discountsGroup->discount = number_format($discountsGroup->discount, 2, ',', ',');
        $this->set(compact('discounts_type', 'free_shipping', 'discountsGroup'));
    }

    public function addCustomer($id = null)
    {
        /** @var DiscountsGroupsCustomersTable $DiscountsGroupsCustomersTable */
        $DiscountsGroupsCustomersTable = TableRegistry::getTableLocator()->get('Admin.DiscountsGroupsCustomers');
        $discountsGroupsCustomers = $DiscountsGroupsCustomersTable->newEntity();

        if ($this->request->is(['post', 'put'])) {
            $discountsGroupsCustomers = $DiscountsGroupsCustomersTable->patchEntity($discountsGroupsCustomers, [
                'customers_id' => $this->request->getData('customers_id'),
                'discounts_groups_id' => $id
            ]);

            if ($DiscountsGroupsCustomersTable->save($discountsGroupsCustomers)) {
                $this->Flash->success('Cliente adicionado');
                return $this->redirect([
                    'controller' => 'discounts-groups',
                    'action' => 'add-customer',
                    $id,
                    'plugin' => 'admin'
                ]);
            }
            $this->Flash->error('Cliente não adicionado, tente novamente');
        }

        $query = $DiscountsGroupsCustomersTable->find()
            ->where([
                'DiscountsGroupsCustomers.discounts_groups_id' => $id
            ])
            ->contain([
                'Customers'
            ])
            ->orderAsc('Customers.name', 'ASC');
        $allCustomers = $this->paginate($query);

        $this->set(compact('discountsGroupsCustomers', 'allCustomers', 'id'));
    }

    /**
     * @param null $id
     * @return Response|null
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $discountGroup = $this->DiscountsGroups->get($id);
        if ($this->DiscountsGroups->delete($discountGroup)) {
            $this->Flash->success(__('O Grupo de Desconto foi excluído.'));
        } else {
            $this->Flash->error(__('O Grupo de Desconto não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect($this->referer());
    }

    public function deleteCustomer()
    {
        $this->request->allowMethod(['post', 'delete']);
        /** @var DiscountsGroupsCustomersTable $DiscountsGroupsCustomersTable */
        $DiscountsGroupsCustomersTable = TableRegistry::getTableLocator()->get('Admin.DiscountsGroupsCustomers');
        $discountsGroupsCustomer = $DiscountsGroupsCustomersTable->find()
            ->where([
                'customers_id' => $this->request->getData('customerId'),
                'discounts_groups_id' => $this->request->getData('groupId')
            ])
            ->first();

        if ($DiscountsGroupsCustomersTable->delete($discountsGroupsCustomer)) {
            $this->Flash->success(__('O cliente foi removido do grupo.'));
        } else {
            $this->Flash->error(__('O cliente não foi removido do grupo. Por favor, tente novamente.'));
        }

        return $this->redirect($this->referer());
    }

    public function findCustomer($discountGroupId)
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;

            /** @var CustomersTable $customersTable */
            $customersTable = TableRegistry::getTableLocator()->get('Admin.Customers');
            $customers = $customersTable->find()
                ->select(['id' => 'Customers.id', 'label' => 'Customers.name'])
                ->leftJoin('discount_group_customers', [
                    'discount_group_customers.customers_id = Customers.id'
                ])
                ->where([
                    'Customers.name LIKE' => '%' . $this->request->getQuery('term') . '%',
                    'OR' => [
                        'discount_group_customers.discounts_groups_id <>' => $discountGroupId,
                        'discount_group_customers.discounts_groups_id is null',
                        'discount_group_customers.deleted is null'
                    ]
                ])
                ->orderAsc('Customers.name')
                ->limit(100)
                ->toArray();

            return new Response([
                'status' => 202,
                'body' => \GuzzleHttp\json_encode($customers)
            ]);
        }
    }
}