<?php

namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\View\View;

/**
 * Orders Controller
 *
 * @property \Admin\Model\Table\OrdersTable $Orders
 * @property \Admin\Model\Table\LendingsTable $Lendings
 *
 * @method \Admin\Model\Entity\Order[] paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
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

        $this->paginate = [
            'contain' => [
                'Customers' => function ($q) {
                    return $q->find('all', ['withDeleted']);
                },
                'CustomersAddresses' => function ($q) {
                    return $q->find('all', ['withDeleted']);
                },
                'OrdersStatuses',
                'OrdersProducts',
                'PaymentsMethods'
            ],
            'conditions' => $conditions,
            'order' => ['Orders.created' => 'desc']
        ];
        $orders = $this->paginate($this->Orders);
        $statuses = $this->Orders->OrdersStatuses->find('list')->where(['id <>' => 6]);
        $payments_methods = $this->Orders->PaymentsMethods->find('list', [
            'keyField' => 'slug',
            'valueField' => 'name'
        ]);

        $this->set(compact('orders', 'statuses', 'filter', 'payments_methods'));
        $this->set('_serialize', ['orders']);
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $order = $this->Orders->get($id, [
                'contain' => [
                    'Customers' => function ($q) {
                        return $q->find('all', ['withDeleted']);
                    },
                    'CustomersAddresses' => function ($q) {
                        return $q->find('all', ['withDeleted']);
                    },
                    'OrdersStatuses',
                    'OrdersProducts' => function ($q) {
                        return $q->contain([
                            'Products' => function ($q) {
                                return $q->contain([
                                    'ProductsImages' => function ($q) {
                                        return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                                    }
                                ]);
                            },
                            'OrdersProductsVariations' => function ($q) {
                                return $q->contain([
                                    'Variations' => function ($q) {
                                        return $q->contain([
                                            'VariationsGroups'
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                    },
                    'PaymentsMethods',
                    'OrdersHistories' => function ($q) {
                        return $q->contain(['OrdersStatuses'])
                            ->order(['OrdersHistories.id' => 'DESC']);
                    }
                ]
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Pedido não encontrado'));
            return $this->redirect(['controller' => 'orders', 'action' => 'index']);
        }

        $statuses = $this->Orders->OrdersStatuses->find('list')
            ->toArray();

        $ordersHistory = $this->Orders->OrdersHistories->newEntity();
        $this->set(compact('order', 'statuses', 'ordersHistory'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param $orders_id
     * @return \Cake\Http\Response|null
     */
    public function changeStatus($orders_id)
    {
        if (!$this->Orders->exists(['id' => $orders_id])) {
            return $this->redirect(['controller' => 'orders', 'action' => 'index']);
        }

        $order = $this->Orders->get($orders_id, [
            'contain' => [
                'OrdersProducts' => function ($q) {
                    return $q->contain('Products');
                },
                'OrdersStatuses',
            ]
        ]);

        $ordersHistory = $this->Orders->OrdersHistories->newEntity($this->request->getData());
        if ($this->Orders->OrdersHistories->save($ordersHistory)) {
            $order->orders_statuses_id = $this->request->getData('orders_statuses_id');
            $this->Orders->save($order);

            if ($this->request->getData('orders_statuses_id') == 6 && $order->orders_statuses_id != 6) {
                foreach ($order->orders_products as $orders_product) {
                    $this->Orders->Products->updateAll(['stock' => $orders_product->product->stock + $orders_product->quantity], ['id' => $orders_product->product->id]);
                }
            } else if ($this->request->getData('orders_statuses_id') != 6 && $order->orders_statuses_id == 6) {
                foreach ($order->orders_products as $orders_product) {
                    $this->Orders->Products->updateAll(['stock' => $orders_product->product->stock - $orders_product->quantity], ['id' => $orders_product->product->id]);
                }
            }

            $this->Flash->success(__("Status do pedido foi alterado."));
        } else {
            $this->Flash->error(__('Não foi possivel alterar o status da venda. Por favor, tente novamente.'));
        }
        return $this->redirect(['controller' => 'orders', 'action' => 'view', $orders_id]);
    }

    /**
     * @param null $orders_id
     * @return \Cake\Http\Response|null
     */
    public function exportPdf($orders_id = null)
    {
        try {
            $order = $this->Orders->get($orders_id, [
                'contain' => [
                    'Customers',
                    'CustomersAddresses',
                    'OrdersStatuses',
                    'OrdersProducts' => function ($q) {
                        return $q->contain([
                            'Products',
                            'OrdersProductsVariations' => function ($q) {
                                return $q->contain([
                                    'Variations' => function ($q) {
                                        return $q->contain([
                                            'VariationsGroups'
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                    },
                    'PaymentsMethods'
                ]
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Pedido não encontrado'));
            return $this->redirect(['controller' => 'orders', 'action' => 'view', $orders_id]);
        }
        $this->viewBuilder()->setLayout('Checkout.ajax');
        $this->set(compact('order'));
    }

    public function generateTagShipping($orders_id = null)
    {
        $this->viewBuilder()->setLayout('pdf/default');
        try {
            $order = $this->Orders->get($orders_id, [
                'contain' => [
                    'Customers',
                    'CustomersAddresses',
                    'OrdersStatuses',
                    'OrdersProducts' => function ($q) {
                        return $q->contain(['Products']);
                    },
                    'PaymentsMethods'
                ]
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Pedido não encontrado'));
            return $this->redirect(['controller' => 'orders', 'action' => 'view', $orders_id]);
        }

        $this->set('store', $this->request->getSession()->read('Store'));
        $this->set(compact('order'));
    }

    /**
     *
     */
    public function registerTracking()
    {
        $json = [
            'status' => false,
            'message' => ''
        ];

        $data = $this->request->getData();

        if (!isset($data['shipping_sent_date']) || empty($data['shipping_sent_date'])) {
            $data['shipping_sent_date'] = Time::now('America/Sao_Paulo');
        } else {
            $data['shipping_sent_date'] = Time::createFromFormat('d/m/Y', $data['shipping_sent_date']);
        }

        $comment = "<p><b>Código de rastreio: </b> {$data['tracking']}</p>";
        $comment .= "<p><b>Data de envio: </b> {$data['shipping_sent_date']->format('d/m/Y')}</p>";

        $ordersHistory = $this->Orders->OrdersHistories->newEntity([
            'orders_id' => $data['orders_id'],
            'orders_statuses_id' => $data['orders_statuses_id'],
            'notify_customer' => $data['notify_customer'],
            'comment' => $comment
        ]);

        if ($this->Orders->OrdersHistories->save($ordersHistory)) {
            $order = $this->Orders->get($data['orders_id']);
            $order = $this->Orders->patchEntity($order, ['orders_statuses_id' => $data['orders_statuses_id'], 'tracking' => $data['tracking'], 'shipping_sent_date' => $data['shipping_sent_date']]);
            $this->Orders->save(
                $this->Orders->patchEntity($order, ['orders_statuses_id' => $data['orders_statuses_id'], 'tracking' => $data['tracking'], 'shipping_sent_date' => $data['shipping_sent_date']])
            );
            //$this->Orders->updateAll(['orders_statuses_id' => $data['orders_statuses_id'], 'tracking' => $data['tracking'], 'shipping_sent_date' => $data['shipping_sent_date']], ['id' => $data['orders_id']]);
            $json['status'] = true;
            $json['message'] = __('O código de rastreio foi salvo.');

            $status = $this->Orders->OrdersStatuses->get($data['orders_statuses_id']);
            $json['status_name'] = $status->name;
        } else {
            $json['status'] = false;
            $json['message'] = __('O código de rastreio não foi salvo. Por favor, tente novamente.');
        }

        $this->set(compact('json'));
        $this->set('_serialize', ['json']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function add($lendingId = null)
    {
        $default_products = [];
        $selected_ids = [];
        $from_lending = false;
        $order = $this->Orders->newEntity();

        if ($lendingId) {
            $Lendings = TableRegistry::getTableLocator()->get('Admin.Lendings');

            $lending = $Lendings->get($lendingId, [
                'contain' => [
                    'Users',
                    'Products' => function ($q) {
                        return $q->contain('ProductsImages');
                    }
                ]
            ]);

            if ($lending->status != 1) {
                $order = $this->Orders->newEntity([
                    'name' => $lending->customer_name,
                    'email' => $lending->customer_email,
                    'document' => $lending->customer_document
                ]);

                foreach ($lending->products as $product) {
                    $selected_ids[] = $product->id;
                }

                $default_products = $lending->products;
                $from_lending = true;
            }
        }

        if ($this->request->is(['post', 'put'])) {
            if ($this->Orders->Customers->exists(['email' => $this->request->getData('email')])) {
                $customer = $this->Orders->Customers->find()
                    ->where(['email' => $this->request->getData('email')])
                    ->first();

            } else {
                $customer = $this->Orders->Customers->newEntity([
                    'name' => $this->request->getData('name'),
                    'email' => $this->request->getData('email'),
                    'document' => $this->request->getData('document')
                ]);
                $this->Orders->Customers->save($customer);
            }

            $data = $this->request->getData();
            $data['customers_id'] = $customer->id;
            $data['orders_types_id'] = 2;
            $data['orders_statuses_id'] = 0;

            $data['subtotal'] = $data['total'] = 0;

            $products_ids = $data['products']['_ids'];

            foreach ($data['products']['_ids'] as $product) {
                $info = $this->Orders->Products->get($product, [
                    'contain' => [
                        'ProductsImages' => function ($q) {
                            return $q->order(['ProductsImages.main' => 'desc', 'ProductsImages.id' => 'asc']);
                        }
                    ]
                ]);
                $price = str_replace(",", ".", str_replace(".", "", $data['product_price_' . $product]));
                $quantity = $data['product_quantity_' . $product];
                unset($data['product_price_' . $product]);
                unset($data['product_quantity_' . $product]);
                $data['orders_products'][] = [
                    'products_id' => $info->id,
                    'name' => $info->name,
                    'quantity' => $quantity,
                    'price' => $price,
                    'price_total' => $price,
                    'price_special' => null,
                    'image_thumb' => $info->thumb_main_image,
                    'image' => $info->main_image
                ];
                $data['subtotal'] += $price;
            }
            $data['shipping_total'] = $price = str_replace(",", ".", str_replace(".", "", $data['shipping_total']));
            $data['discount'] = $price = str_replace(",", ".", str_replace(".", "", $data['discount']));
            $data['total'] = $data['subtotal'] + $data['shipping_total'] - $data['discount'];
            unset($data['products']);
            unset($data['email']);
            unset($data['name']);

            $order = $this->Orders->patchEntity($order, $data, ['associated' => ['OrdersProducts']]);

            if ($this->Orders->save($order)) {
                $this->Flash->success(__('Nova compra realizada com sucesso'));
                $this->Orders->addHistory($order->id, 1, '');
                $this->Orders->addHistory($order->id, $this->request->getData('orders_statuses_id'), '');

                $order = $this->Orders->get($order->id, [
                    'contain' => [
                        'OrdersProducts',
                        'Customers'
                    ]
                ]);

                $view = new View($this->request, $this->response);

                $EmailTemplates = TableRegistry::getTableLocator()->get('Admin.EmailTemplates');
                $EmailQueues = TableRegistry::getTableLocator()->get('Admin.EmailQueues');

                $template = $EmailTemplates->find()
                    ->where(['slug' => 'novo-pedido'])
                    ->first();

                if ($view->elementExists(Configure::read('Theme') . '.Order/product')) {
                    $products_html = $view->element(Configure::read('Theme') . '.Order/product', ['products' => $order->orders_products]);
                } else {
                    $products_html = $view->element('Order/product', ['products' => $order->orders_products]);
                }

                $data = [
                    'orders_id' => $order->id,
                    'name' => $order->customer->name,
                    'document' => $order->customer->document,
                    'email' => $order->customer->email,
                    'telephone' => $order->customer->telephone,
                    'address' => $order->address . ', ' . $order->number . ', ' . $order->complement . ' - ' . $order->neighborhood,
                    'zipcode' => $order->zipcode,
                    'city' => $order->city,
                    'uf' => $order->state,
                    'products' => $products_html,
                    'subtotal' => $order->subtotal_format,
                    'shipping_text' => $order->shipping_text,
                    'shipping_total' => $order->shipping_total_format,
                    'discount' => $order->discount_format,
                    'total' => $order->total_format,
                    'payment_type' => $order->payment_method_text,
                    'payment_condition' => $order->installments_text,
                    'shipping_deadline' => $order->shipment_deadline_text,
                    'order_url' => Router::url(['_full' => true, 'controller' => 'customers', 'action' => 'order', $order->id])
                ];

                $html = $EmailTemplates->buildHtml($template, $data);

                /**
                 * store email
                 */
                $email = $EmailQueues->newEntity([
                    'from_name' => $template->from_name,
                    'from_email' => $template->from_email,
                    'subject' => $template->subject,
                    'content' => $html,
                    'to_name' => $this->store->name,
                    'to_email' => $this->store->email_contact,
                    'email_statuses_id' => 1,
                ]);

                $EmailQueues->save($email);

                /**
                 * customer email
                 */
                $email = $EmailQueues->newEntity([
                    'from_name' => $template->from_name,
                    'from_email' => $template->from_email,
                    'subject' => $template->subject,
                    'content' => $html,
                    'to_name' => $order->customer->name,
                    'to_email' => $order->customer->email,
                    'email_statuses_id' => 1,
                    'reply_name' => $template->reply_name,
                    'reply_email' => $template->reply_email
                ]);

                $EmailQueues->save($email);

                if ($from_lending) {
                    $lending->status = 1;
                    $Lendings->save($lending);

                    $Lendings->updateProducts($lending->id, $products_ids);
                }

                return $this->redirect(['controller' => 'orders', 'action' => 'index']);
            } else {
                $this->Flash->error(__('Ocorreu um problema ao finalizar a compra. Por favor, tente novamente'));
            }
        }

        $products = $this->Orders->Products->find('all', [
            'contain' => [
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC']);
                },
            ]
        ])->toArray();

        $statuses = $this->Orders->OrdersStatuses->find('list')->toArray();

        $PaymentsMethods = TableRegistry::getTableLocator()->get('Admin.PaymentsMethods');
        $payment_methods = $PaymentsMethods->find('list', [
            'keyField' => 'slug',
            'valueField' => 'name'
        ])
            ->order(['PaymentsMethods.name' => 'asc'])
            ->toArray();

        $shipping_methods = [
            'Sedex' => 'Sedex',
            'PAC' => 'PAC',
            'Carta Registrada' => 'Carta Registrada',
            'Impresso simples' => 'Impresso simples',
            'Impresso registrado' => 'Impresso registrado',
            'Carta simples' => 'Carta simples',
            'Remessa Internacional' => 'Remessa Internacional'
        ];

        $this->set(compact('order', 'products', 'selected_ids', 'default_products', 'statuses', 'payment_methods', 'shipping_methods'));
        $this->set('_serialize', ['order']);
    }
}
