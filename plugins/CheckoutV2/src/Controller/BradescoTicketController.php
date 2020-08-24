<?php

namespace CheckoutV2\Controller;

use Cake\I18n\Date;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Carbon\Carbon;
use CheckoutV2\Controller\Component\OrderComponent;
use Eduardokum\LaravelBoleto\Boleto\Banco\Bradesco;
use Eduardokum\LaravelBoleto\Boleto\Render\Pdf;

/**
 * Class BradescoTicketController
 * @package Checkout\Controller
 *
 * @property \CheckoutV2\Controller\Component\BradescoTicketComponent $BradescoTicket
 * @property OrderComponent $Order
 */
class BradescoTicketController extends AppController
{
    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('CheckoutV2.BradescoTicket', [
            'payment_config' => $this->payment_config,
            'store' => $this->store
        ]);
        $this->loadComponent('CheckoutV2.Order', [
            'payment_config' => $this->payment_config
        ]);
        $this->Auth->allow(['ticket', 'generateTicket']);
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
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
        if ($data_customer) {
            $Customers->patchEntity($customer, $data_customer);
            $Customers->save($customer);
        }
        $ticket = $this->BradescoTicket->process($this->request->getData(), $this->request->getSession()->read('orders_id'));

        if ($ticket) {
            $this->Order->finalizeOrder();
            return $this->redirect(['controller' => 'checkout', 'action' => 'success', $this->request->getSession()->read('orders_id')]);
        } else {
            $this->Flash->error(__('Ocorreu um problema ao processar seu pagamento. Por favor, tente novamente.'));
            return $this->redirect(['controller' => 'checkout', 'action' => 'payment']);
        }
    }

    /**
     * @param $order_id
     * @throws \Exception
     */
    public function ticket($order_id)
    {
        $ticket = $this->BradescoTicket->generateTicket($order_id);
        $pdf = new Pdf();
        $pdf->hideInstrucoes();
        $pdf->addBoleto($ticket);
        $pdf->gerarBoleto($dest = Pdf::OUTPUT_STANDARD, $save_path = null);
    }

    /**
     * @param $orders_id
     * @param $api_token
     * @throws \Exception
     */
    public function generateTicket($orders_id, $api_token)
    {
        $order = $this->Order->getOrder($orders_id);
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $main = $Stores->findConfig('main');

        if ($api_token !== $main->api_token) {
            throw new \Exception(__('Token da api inválido'));
        }

        if (!$order) {
            throw new \Exception(__('Pedido nao encontrado #' . $orders_id));
        }

        $ticket = $this->BradescoTicket->generateTicket($order);
        $this->set(compact('ticket'));
        $this->set('_serialize', 'ticket');
    }
}