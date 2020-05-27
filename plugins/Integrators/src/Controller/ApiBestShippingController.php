<?php

namespace Integrators\Controller;

use Admin\Model\Table\OrdersTable;
use Cake\I18n\Date;

/**
 * Class ApiBestShippingController
 * @property \Admin\Model\Table\ShipmentsTable $Shipments
 * @property \Integrators\Controller\Component\ApiBestShippingComponent $ApiBestShipping
 * @property OrdersTable $Orders
 * @package Integrators\Controller
 */
class ApiBestShippingController extends \Admin\Controller\AppController
{
    public $Shipments;

    /**
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Admin.Shipments');
        $bestShippingConfig = $this->Shipments->findConfig('melhor_envio');

        $this->loadComponent('Integrators.ApiBestShipping', (array)$bestShippingConfig);
    }

    /**
     *
     */
    public function ordersTags()
    {
        $filter = [
            'id' => '',
            'customer' => '',
            'payment_method' => '',
            'created' => '',
            'orders_statuses_id' => ''
        ];
        $conditions = [
            'Orders.orders_statuses_id IN' => [2, 3, 4, 5],
            'Orders.shipping_code LIKE' => 'melhor_envio%'
        ];

        if ($this->request->getQuery('id')) {
            $conditions[] = ['Orders.id' => "{$this->request->getQuery('id')}"];
            $filter['id'] = $this->request->getQuery('id');
        }

        if ($this->request->getQuery('customer')) {
            $conditions[] = ['Customers.name LIKE' => "%{$this->request->getQuery('customer')}%"];
            $filter['customer'] = $this->request->getQuery('customer');
        }

        if ($this->request->getQuery('created')) {
            $created = Date::createFromFormat('d/m/Y', $this->request->getQuery('created'));
            $conditions[] = ['Orders.created >=' => "{$created->format("Y-m-d")} 00:00:00"];
            $conditions[] = ['Orders.created <=' => "{$created->format("Y-m-d")} 23:59:59"];
            $filter['created'] = $this->request->getQuery('created');
        }

        if ($this->request->getQuery('orders_statuses_id')) {
            $conditions[] = ['Orders.orders_statuses_id' => "{$this->request->getQuery('orders_statuses_id')}"];
            $filter['orders_statuses_id'] = $this->request->getQuery('orders_statuses_id');
        }

        $this->loadModel('Admin.Orders');
        $orders = $this->paginate($this->Orders->find()
            ->where($conditions)
            ->contain([
                'Customers' => function ($q) {
                    return $q->find('all', ['withDeleted']);
                },
                'CustomersAddresses' => function ($q) {
                    return $q->find('all', ['withDeleted']);
                },
                'OrdersStatuses',
                'OrdersProducts',
                'PaymentsMethods'
            ])
            ->order([
                'Orders.created' => 'DESC'
            ]));

        $statuses = $this->Orders->OrdersStatuses->find('list')->where(['id <>' => 6]);
        $this->set(compact('orders', 'filter', 'statuses'));
    }

    public function buyShipping($order_id)
    {
        $this->loadModel('Admin.Orders');
        $order = $this->Orders->get($order_id, [
            'contain' => [
                'OrdersProducts',
                'Customers'
            ]
        ]);
    }
}