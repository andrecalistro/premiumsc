<?php

namespace CheckoutV2\Controller;

use Cake\Core\Configure;
use Cake\I18n\Date;
use Cake\Network\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Checkout\Controller\AppController;
use Checkout\Controller\Component\OrderComponent;
use mysql_xdevapi\Exception;

/**
 * Class CieloController
 * @package App\Controller
 *
 * @property \Checkout\Controller\Component\MoipTicketComponent $MoipTicket
 * @property OrderComponent Order
 */
class MoipTicketController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Checkout.MoipTicket', [
            'payment_config' => $this->payment_config,
            'store' => $this->store
        ]);
        $this->loadComponent('Checkout.Order', [
            'payment_config' => $this->payment_config
        ]);
        $this->Auth->allow(['consultWaitingOrders']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function process()
    {
        $Customers = TableRegistry::getTableLocator()->get('Checkout.Customers');
        $customer = $Customers->get($this->Auth->user('id'));
        $data_customer = [];
        if ($this->request->getData('document')) {
            $data_customer['document'] = $this->request->getData('document');
        }
        if ($this->request->getData('telephone')) {
            $data_customer['telephone'] = $this->request->getData('telephone');
        }
        if ($this->request->getData('birth_date')) {
            $data_customer['birth_date'] = $this->request->getData('birth_date');
        }
        if($data_customer){
            $Customers->patchEntity($customer, $data_customer);
            $Customers->save($customer);
        }
        $ticket = $this->MoipTicket->process($this->request->getSession()->read('orders_id'));

        if ($ticket) {
            $this->Order->finalizeOrder();
            return $this->redirect(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')]);
        } else {
            $this->Flash->error(__('Ocorreu um problema ao processar seu pagamento. Por favor, tente novamente.'));
            return $this->redirect(['controller' => 'checkout', 'action' => 'payment']);
        }
    }

    /**
     * @param null $token
     * @throws \Exception
     */
    public function consultWaitingOrders($token = null)
    {
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $store_config = $Stores->findConfig('garrula');

        if (!$token || $token != $store_config->api_token) {
            throw new \Exception(__('Token inválido. Você não tem permissão para acessar esse metódo.'));
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
                $moip_id = $this->MoipTicket->splitId($order->payment_id);

                $status = $this->MoipTicket->consultStatus($moip_id['moip_payment_id']);

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