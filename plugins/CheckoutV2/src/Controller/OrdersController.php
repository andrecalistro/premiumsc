<?php

namespace CheckoutV2\Controller;

use Admin\Model\Table\EmailQueuesTable;
use Admin\Model\Table\EmailTemplatesTable;
use Admin\Model\Table\StoresTable;
use Cake\Http\Response;
use Cake\Http\Session;
use Cake\Log\Log;
use Cake\Network\Exception\UnauthorizedException;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Checkout\Model\Entity\Order;
use Checkout\Model\Table\OrdersTable;
use mysql_xdevapi\Exception;

/**
 * Class OrdersController
 * @package Checkout\Controller
 * @property \Checkout\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['waitingPayment', 'sendProductsRatings']);
    }

    /**
     * @param null $token
     * @throws UnauthorizedException
     */
    public function waitingPayment($token = null)
    {
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $main_config = $Stores->findConfig('main');

        if (!$token || $token != $main_config->api_token) {
            throw UnauthorizedException(__('Token inválido. Você não tem permissão para acessar esse metódo.'));
        }
        $due_days = $Stores->getByKeyword('store_due_days');

        $json = [
            'status' => false,
            'message' => ''
        ];

        $orders = $this->Orders->verifyStatus($due_days, 1, 6, 'up');

        if ($orders) {
            $json['message'] = sprintf('Foram alterados %s pedidos', count($orders));
            $json['status'] = true;
        } else {
            $json['message'] = 'Nenhum pedido foi alterado';
        }


        $this->set(compact('json'));
        $this->set('_serialize', ['json']);
    }

    /**
     * @param $token
     * @return Response
     */
    public function sendProductsRatings($token = null)
    {
        try {
            $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
            $store_config = $Stores->findConfig('main');
            if (!$token || $token != $store_config->api_token) {
                throw new \Exception(__('Token inválido. Você não tem permissão para acessar esse metódo.'), 403);
            }

            /** @var StoresTable $Stores */
            $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
            $config = $Stores->findConfig('product_rating');

            if (!$config->status) {
                throw new \Exception('Avaliações de produtos não habilitado', 403);
            }

            $interval = sprintf('P%sD', $config->days);
            $dateFilter = (new \DateTime())->sub(new \DateInterval($interval))->format('Y-m-d');

            $orders = $this->Orders->find()
                ->contain([
                    'Customers'
                ])
                ->where([
                    'Orders.orders_statuses_id' => $config->orders_statuses_id,
                    'DATE(Orders.created)' => $dateFilter
                ])
                ->toArray();

            if (!$orders) {
                throw new \Exception('Não foram encontrados pedidos para solicitar avaliações.', 404);
            }

            /** @var EmailTemplatesTable $EmailTemplates */
            $EmailTemplates = TableRegistry::getTableLocator()->get('Admin.EmailTemplates');

            /** @var EmailQueuesTable $EmailQueues */
            $EmailQueues = TableRegistry::getTableLocator()->get('Admin.EmailQueues');

            $template = $EmailTemplates->find()
                ->where(['slug' => 'avaliacao-de-produtos'])
                ->first();

            if (!$template) {
                throw new \Exception('Template de e-mail não encontrado', 404);
            }

            $store = (new Session())->read('Store');
            $avaliations = '';

            /** @var Order $order */
            foreach ($orders as $order) {
                $data = [
                    'name' => $order->customer->name,
                    'order' => $order->id,
                    'link' => $this->Orders->generateLink($order)
                ];

                $html = $EmailTemplates->buildHtml($template, $data);

                $email = $EmailQueues->newEntity([
                    'from_name' => $store->name,
                    'from_email' => $store->email_contact,
                    'subject' => $template->subject,
                    'content' => $html,
                    'to_name' => $order->customer->name,
                    'to_email' => $order->customer->email,
                    'email_statuses_id' => 1,
                ]);

                if (!$EmailQueues->save($email)) {
                    Log::error(sprintf('Erro ao salvar email de avaliações do pedido %s', $order->id));
                }
                $avaliations .= sprintf('E-mail enviado, pedido: %s<br>', $order->id);
            }

            return new Response([
                'statusCode' => 200,
                'body' => $avaliations
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return new Response([
                'statusCode' => $e->getCode(),
                'body' => $e->getMessage()
            ]);
        }
    }
}