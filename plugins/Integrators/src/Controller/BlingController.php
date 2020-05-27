<?php

namespace Integrators\Controller;

use Cake\I18n\Date;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Integrators\Controller\Component\BlingComponent;
use Integrators\Model\Table\BlingCustomersTable;

/**
 * Class BlingController
 * @package Integrators\Controller
 * @property BlingComponent $Bling
 */
class BlingController extends \Admin\Controller\AppController
{
    public $Stores;

    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setClassName('Integrators.App');
        $this->Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $this->loadComponent('Integrators.Bling');
    }

    public function index()
    {
        $links = [
            [
                'name' => 'Configuração',
                'icon' => 'fa-sliders',
                'link' => Router::url(['controller' => 'bling', 'action' => 'settings'], true)
            ],
            [
                'name' => 'Produtos',
                'icon' => 'fa-shopping-cart',
                'link' => Router::url(['controller' => 'bling', 'action' => 'products'], true)
            ],
            [
                'name' => 'Fornecedores',
                'icon' => 'fa-truck',
                'link' => Router::url(['controller' => 'bling', 'action' => 'providers'], true)
            ],
            [
                'name' => 'Clientes',
                'icon' => 'fa-user-o',
                'link' => Router::url(['controller' => 'bling', 'action' => 'customers'], true)
            ],
            [
                'name' => 'Pedidos',
                'icon' => 'fa-files-o',
                'link' => Router::url(['controller' => 'bling', 'action' => 'orders'], true)
            ]
        ];

        $this->set(compact('links'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function settings()
    {
        $result = $this->Stores->findConfig('bling');
        $entity = (object)[
            'api_key' => '',
            'status' => '',
            'synchronize_providers' => 0,
            'synchronize_customers' => 0,
            'synchronize_products' => 0,
            'synchronize_orders' => 0,
            'synchronize_orders_statuses_id' => ''
        ];
        $bling = $this->Stores->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Stores->prepareSave($this->request->getData(), 'bling');
            $entities = $this->Stores->newEntities($data);
            if ($this->Stores->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Bling foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações do Bling não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];

        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');
        $orders_statuses = $OrdersStatuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ]);

        $this->set(compact('bling', 'statuses', 'orders_statuses'));
    }

    /**
     *
     */
    public function products()
    {
        $conditions = [];
        $filter = [
            'name' => '',
            'code' => '',
            'stock' => '',
            'price' => ''
        ];

        if ($this->request->getQuery('name')) {
            $conditions[] = ['Products.name LIKE' => "%{$this->request->getQuery('name')}%"];
            $filter['name'] = $this->request->getQuery('name');
        }

        if ($this->request->getQuery('code')) {
            $conditions[] = ['Products.code' => $this->request->getQuery('code')];
            $filter['code'] = $this->request->getQuery('code');
        }

        if ($this->request->getQuery('stock')) {
            $conditions[] = ['Products.stock' => $this->request->getQuery('stock')];
            $this->set('stock', $this->request->getQuery('stock'));
            $filter['stock'] = $this->request->getQuery('stock');
        }

        if ($this->request->getQuery('price')) {
            $price = str_replace(',', '.', str_replace('.', '', $this->request->getQuery('price')));
            $conditions[] = ['Products.price' => $price];
            $this->set('price', $this->request->getQuery('price'));
            $filter['price'] = $this->request->getQuery('price');
        }

        $BlingProducts = TableRegistry::getTableLocator()->get('Integrators.BlingProducts');

        $query = $BlingProducts->Products->find()
            ->contain([
                'BlingProducts'
            ])
            ->order(['Products.name' => 'ASC']);

        if ($conditions) {
            $query->where($conditions);
        }

        $products = $this->paginate($query);

        $this->set(compact('products', 'filter'));
    }

    /**
     * @param $products_id
     * @return \Cake\Http\Response|null
     */
    public function synchronizeProduct($products_id)
    {
        $synchronize = $this->Bling->synchronizeProduct($products_id);
        if ($synchronize) {
            $this->Flash->success(__("Produto sincronizado com sucesso"));
        } else {
            $this->Flash->error(__("Não foi possível sincronizar o produto. Por favor, tente novamente."));
        }
        return $this->redirect($this->referer());
    }

    /**
     *
     */
    public function providers()
    {
        $BlingProviders = TableRegistry::getTableLocator()->get('Integrators.BlingProviders');
        $conditions = [];
        $filter = [
            'name' => '',
            'email' => '',
            'telephone' => ''
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

        $this->paginate = [
            'conditions' => $conditions
        ];

        $query = $BlingProviders->Providers->find()
            ->contain(['BlingProviders'])
            ->where($conditions);

        $providers = $this->paginate($query);

        $this->set(compact('providers', 'filter'));
        $this->set('_serialize', ['providers']);
    }

    /**
     * @param $providers_id
     * @return \Cake\Http\Response|null
     */
    public function synchronizeProvider($providers_id)
    {
        $synchronize = $this->Bling->synchronizeProvider($providers_id);
        if ($synchronize->status) {
            $this->Flash->success(__("Fornecedor sincronizado com sucesso"));
        } else {
            $this->Flash->error(__("Não foi possível sincronizar o fornecedor. Por favor, tente novamente."));
        }
        return $this->redirect($this->referer());
    }

    /**
     * @var BlingCustomersTable $BlingCustomers
     */
    public function customers()
    {
        $BlingCustomers = TableRegistry::getTableLocator()->get('Integrators.BlingCustomers');
        $conditions = [];
        $filter = [
            'name' => '',
            'email' => '',
            'telephone' => '',
            'cellphone' => ''
        ];

        if ($this->request->getQuery('name')) {
            $conditions[] = ['Customers.name LIKE' => "%{$this->request->getQuery('name')}%"];
            $filter['name'] = $this->request->getQuery('name');
        }

        if ($this->request->getQuery('email')) {
            $conditions[] = ['Customers.email LIKE' => "%{$this->request->getQuery('email')}%"];
            $filter['email'] = $this->request->getQuery('email');
        }

        if ($this->request->getQuery('telephone')) {
            $conditions[] = ['Customers.telephone' => "{$this->request->getQuery('telephone')}"];
            $filter['telephone'] = $this->request->getQuery('telephone');
        }

        if ($this->request->getQuery('cellphone')) {
            $conditions[] = ['Customers.cellphone' => "{$this->request->getQuery('cellphone')}"];
            $filter['cellphone'] = $this->request->getQuery('cellphone');
        }

        $query = $BlingCustomers->Customers->find()
            ->contain([
                'BlingCustomers'
            ])
            ->where($conditions)
            ->order(['Customers.name' => 'ASC']);

        $customers = $this->paginate($query);

        $this->set(compact('customers', 'filter'));
        $this->set('_serialize', ['customers']);
    }

    /**
     * @param $customers_id
     * @return \Cake\Http\Response|null
     */
    public function synchronizeCustomer($customers_id)
    {
        $synchronize = $this->Bling->synchronizeCustomer($customers_id);
        if ($synchronize->status) {
            $this->Flash->success(__("Cliente sincronizado com sucesso"));
        } else {
            $this->Flash->error(__("Não foi possível sincronizar o cliente. Por favor, tente novamente."));
        }
        return $this->redirect($this->referer());
    }

    public function orders()
    {
        $BlingOrders = TableRegistry::getTableLocator()->get('Integrators.BlingOrders');
        $conditions[] = ['Orders.orders_statuses_id >' => 0];
        $filter = [
            'id' => '',
            'customer' => '',
            'payment_method' => '',
            'created' => '',
            'orders_statuses_id' => ''
        ];

        if ($this->request->getQuery('id')) {
            $conditions[] = ['Orders.id' => "{$this->request->getQuery('id')}"];
            $filter['id'] = $this->request->getQuery('id');
        }

        if ($this->request->getQuery('customer')) {
            $conditions[] = ['Customers.name LIKE' => "%{$this->request->getQuery('customer')}%"];
            $filter['customer'] = $this->request->getQuery('customer');
        }

        if ($this->request->getQuery('payment_method')) {
            $conditions[] = ['Orders.payment_method' => "{$this->request->getQuery('payment_method')}"];
            $filter['payment_method'] = $this->request->getQuery('payment_method');
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

        $query = $BlingOrders->Orders->find()
            ->contain([
                'Customers' => function ($q) {
                    return $q->find('all', ['withDeleted']);
                },
                'CustomersAddresses' => function ($q) {
                    return $q->find('all', ['withDeleted']);
                },
                'OrdersStatuses',
                'OrdersProducts',
                'PaymentsMethods',
                'BlingOrders'
            ])
            ->where($conditions)
            ->order(['Orders.created' => 'desc']);

        $orders = $this->paginate($query);
        $statuses = $BlingOrders->Orders->OrdersStatuses->find('list')->where(['id <>' => 6]);
        $payments_methods = $BlingOrders->Orders->PaymentsMethods->find('list', [
            'keyField' => 'slug',
            'valueField' => 'name'
        ]);

        $this->set(compact('orders', 'statuses', 'filter', 'payments_methods'));
        $this->set('_serialize', ['orders']);
    }

    public function synchronizeOrder($orders_id)
    {
        $synchronize = $this->Bling->synchronizeOrder($orders_id);
        if ($synchronize->status) {
            $this->Flash->success(__("Pedido sincronizado com sucesso"));
        } else {
            $this->Flash->error(__("Não foi possível sincronizar o pedido. Por favor, tente novamente."));
        }
        return $this->redirect($this->referer());
    }
}