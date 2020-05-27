<?php

namespace CheckoutV2\Controller;

use Cake\ORM\TableRegistry;
use Subscriptions\Model\Table\SubscriptionsTable;

class CustomerSubscriptionsController extends AppController
{

    /** @var SubscriptionsTable */
    private $subscriptionsTable;

    public function initialize()
    {
        parent::initialize();
        $this->subscriptionsTable = TableRegistry::getTableLocator()->get('Subscriptions.Subscriptions');
    }

    public function index()
    {
        $subscriptions = $this->paginate($this->subscriptionsTable->find()
            ->where([
                'Subscriptions.customers_id' => $this->Auth->user('id')
            ])
            ->contain([
                'Plans'
            ])
            ->orderDesc('Subscriptions.id'));

        $this->pageTitle = "Minhas Assinaturas";

        $this->set(compact('subscriptions'));
    }

    public function view($subscriptionId)
    {
        try {
            $subscription = $this->subscriptionsTable->getSubscription($subscriptionId);
            $this->pageTitle = 'Detalhes da sua assinatura';
            $this->set(compact('subscription'));
        } catch (\Exception $e) {
            $this->Flash->error('Assinatura não encontrada');
            return $this->redirect(['_name' => 'customerSubscriptions']);
        }
    }
}