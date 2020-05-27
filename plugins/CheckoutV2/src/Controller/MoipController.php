<?php

namespace CheckoutV2\Controller;

use Cake\Core\Configure;
use Cake\I18n\Date;
use Cake\Network\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use mysql_xdevapi\Exception;

/**
 * Class CieloController
 * @package App\Controller
 *
 * @property \Checkout\Controller\Component\MoipComponent $Moip
 */
class MoipController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Checkout.Moip', [
            'payment_config' => $this->payment_config,
            'store' => $this->store
        ]);
        $this->Auth->allow(['consultWaitingOrders']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function ticket()
    {
        if ($this->request->getData('birth_date')) {
            $Customers = TableRegistry::getTableLocator()->get('Checkout.Customers');
            $customer = $Customers->get($this->Auth->user('id'));
            $Customers->save($Customers->patchEntity($customer, ['birth_date' => Date::createFromFormat('d/m/Y', $this->request->getData('birth_date'))->format("Y-m-d")]));
        }

        $ticket = $this->Moip->ticket($this->request->getSession()->read('orders_id'));

        if ($ticket) {
            return $this->redirect(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')]);
        } else {
            $this->Flash->error(__('Ocorreu um problema ao processar seu pagamento. Por favor, tente novamente.'));
            return $this->redirect(['controller' => 'checkout', 'action' => 'payment']);
        }
    }

    /**
     *
     */
    public function creditCard()
    {
        if ($this->request->getData('birth_date')) {
            $Customers = TableRegistry::getTableLocator()->get('Checkout.Customers');
            $customer = $Customers->get($this->Auth->user('id'));
            $Customers->save($Customers->patchEntity($customer, ['birth_date' => Date::createFromFormat('d/m/Y', $this->request->getData('birth_date'))->format("Y-m-d")]));
        }

        $credit_card = $this->Moip->creditCard($this->request->getSession()->read('orders_id'), $this->request->getData());

        if ($credit_card) {
            $data = [
                'status' => true,
                'redirect' => Router::url(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')], true)
            ];
        } else {
            $data = [
                'status' => false,
                'message' => 'Pagamento não autorizado. Entre em contato com o banco emissor do seu cartão para mais informações.'
            ];
        }
        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
    }

    public function onlineDebit()
    {
        $online_debit = $this->Cielo->onlineDebit($this->request->getSession()->read('orders_id'), $this->request->getData());

        if ($online_debit) {
            $data = [
                'status' => true,
                'redirect' => $online_debit
            ];
        } else {
            $data = [
                'status' => false,
                'message' => 'Pagamento não autorizado. Entre em contato com o banco emissor do seu cartão para mais informações.'
            ];
        }

        $this->set(compact('data'));
        $this->set('_serialize', ['data']);
    }

    public function discount()
    {
        $discount = $this->Cielo->discount($this->request->getSession()->read('orders_id'), $this->request->getData('method'));

        $this->set(compact('discount'));
        $this->set('_serialize', ['discount']);
    }

    /**
     * @param null $token
     */
    public function consultWaitingOrders($token = null)
    {
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $store_config = $Stores->findConfig('garrula');

        if (!$token || $token != $store_config->api_token) {
            throw new Exception(__('Token inválido. Você não tem permissão para acessar esse metódo.'));
        }

        $json = [
            'status' => true,
            'message' => ''
        ];

        $Orders = TableRegistry::getTableLocator()->get('Checkout.Orders');

        $orders = $Orders->find()
            ->where(['Orders.orders_statuses_id' => 1])
            ->contain(['Products'])
            ->toArray();

        if ($orders) {
            $orders_changed = 0;
            foreach ($orders as $order) {
                $moip_id = $this->Moip->splitId($order->payment_id);

                $status = $this->Moip->consultStatus($moip_id['moip_payment_id']);

                if ($status != $order->orders_statuses_id) {
                    $order = $Orders->patchEntity($order, ['orders_statuses_id' => $status]);
                    if ($Orders->save($order)) {
                        $history = $Orders->OrdersHistories->newEntity([
                            'orders_id' => $order->id,
                            'orders_statuses_id' => $status,
                            'comment' => 'O status do seu pedido foi alterado',
                            'notify_customer' => 1
                        ]);
                        if ($Orders->OrdersHistories->save($history)) {
                            $orders_changed++;
                        }
                    }
                }
            }
            $json['message'] = sprintf('Foram alterados %s pedidos', $orders_changed);
        } else {
            $json['status'] = false;
            $json['message'] = 'Nenhum pedido com pagamento pendente foi encontrado';
        }

        $this->set(compact('json'));
        $this->set('_serialize', ['json']);
    }
}