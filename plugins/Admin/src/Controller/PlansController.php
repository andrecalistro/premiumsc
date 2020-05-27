<?php

namespace Admin\Controller;

use Admin\Model\Table\StoresTable;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Integrators\Controller\Component\BlingComponent;
use Subscriptions\Model\Entity\SubscriptionShipment;
use Subscriptions\Model\Table\PlansTable;
use Subscriptions\Service\Email;

/**
 * Products Controller
 *
 * @property \Admin\Model\Table\ProductsTable $Products
 * @property BlingComponent $Bling
 */
class PlansController extends AppController
{
    /** @var object */
    public $garrula;

    /** @var PlansTable $plansTable */
    public $plansTable;

    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        /** @var StoresTable $Garrula */
        $Garrula = TableRegistry::getTableLocator()->get("Admin.Stores");
        $this->garrula = $Garrula->findConfig('garrula');

        $this->plansTable = TableRegistry::getTableLocator()->get('Subscriptions.Plans');

        $this->viewBuilder()->setTemplatePath('Subscriptions/Plans');
    }

    /**
     *
     */
    public function index()
    {
        $conditions = [];
        $filter = [
            'description' => '',
            'price' => '',
            'id' => '',
        ];

        if ($this->request->getQuery('description')) {
            $conditions[] = ['Plans.description LIKE' => "%{$this->request->getQuery('description')}%"];
            $filter['description'] = $this->request->getQuery('description');
        }

        if ($this->request->getQuery('price')) {
            $price = str_replace(',', '.', str_replace('.', '', $this->request->getQuery('price')));
            $conditions[] = ['Products.price' => $price];
            $this->set('price', $this->request->getQuery('price'));
            $filter['price'] = $this->request->getQuery('price');
        }

        if ($this->request->getQuery('id')) {
            $conditions[] = ['Plans.id' => $this->request->getQuery('id')];
            $filter['id'] = $this->request->getQuery('id');
        }

        $query = $this->plansTable->find()
            ->contain([
                'PlanBillingFrequencies',
                'PlanDeliveryFrequencies'
            ])
            ->where($conditions);

        $plans = $this->paginate($query);
        $this->set(compact('plans', 'filter'));
    }

    /**
     * @param $planId
     * @return \Cake\Http\Response|null
     */
    public function view($planId)
    {
        try {
            $plan = $this->plansTable->get($planId, [
                'contain' => [
                    'PlanBillingFrequencies',
                    'PlanDeliveryFrequencies',
                    'PlansImages'
                ]
            ]);
        } catch (\Exception $e) {
            $this->Flash->error('Plano não encontrado');
            return $this->redirect([
                'controller' => 'plans',
                'action' => 'index'
            ]);
        }

        $this->set(compact('plan'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function add()
    {
        $plan = $this->plansTable->newEntity();

        if ($this->request->is('post')) {
            $plan = $this->plansTable->patchEntity($plan, $this->request->getData());
            if ($this->plansTable->save($plan)) {
                $this->plansTable->saveImages($this->request->getData('plans_images'), $plan->id);

                $this->Flash->success(__('O plano foi salvo.'));

                if (!$this->request->getData('stay')) {
                    return $this->redirect(['controller' => 'plans', 'action' => 'index']);
                }

                return $this->redirect(['controller' => 'plans', 'action' => 'edit', $plan->id]);
            }
            $this->Flash->error(__('O plano não foi salvo. Por favor, revise o formulário e tente novamente.'));
        }

        $billingFrequencies = $this->plansTable->PlanBillingFrequencies->find('list')
            ->toArray();

        $deliveryFrequencies = $this->plansTable->PlanDeliveryFrequencies->find('list')
            ->toArray();

        $statuses = [1 => 'Habilitado', 0 => 'Desabilitado'];

        $this->set(compact('plan', 'billingFrequencies', 'deliveryFrequencies', 'statuses'));
    }

    /**
     * @param $planId
     * @return \Cake\Http\Response|null
     */
    public function edit($planId)
    {
        try {
            $plan = $this->plansTable->get($planId, [
                'contain' => [
                    'PlanBillingFrequencies',
                    'PlanDeliveryFrequencies',
                    'PlansImages'
                ]
            ]);
        } catch (\Exception $e) {
            $this->Flash->error('Plano não encontrado');
            return $this->redirect([
                'controller' => 'plans',
                'action' => 'index'
            ]);
        }

        if ($this->request->is(['post', 'put'])) {
            $plan = $this->plansTable->patchEntity($plan, $this->request->getData());
            if ($this->plansTable->save($plan)) {
                $this->plansTable->saveImages($this->request->getData('plans_images'), $plan->id);

                $this->Flash->success(__('O plano foi salvo.'));

                if (!$this->request->getData('stay')) {
                    return $this->redirect(['controller' => 'plans', 'action' => 'index']);
                }

                return $this->redirect(['controller' => 'plans', 'action' => 'edit', $plan->id]);
            }
        }

        $billingFrequencies = $this->plansTable->PlanBillingFrequencies->find('list')
            ->toArray();

        $deliveryFrequencies = $this->plansTable->PlanDeliveryFrequencies->find('list')
            ->toArray();

        $statuses = [1 => 'Habilitado', 0 => 'Desabilitado'];

        isset($plan->plans_images) ? $countImages = 5 - count($plan->plans_images) : $countImages = 5;

        $this->set(compact('plan', 'billingFrequencies', 'deliveryFrequencies', 'statuses', 'countImages'));
    }

    /**
     * @param $id
     * @param $plansId
     * @return \Cake\Http\Response|null
     */
    public function setImageMain($id, $plansId)
    {
        $image = $this->plansTable->PlansImages->get($id);
        $this->plansTable->PlansImages->updateAll(
            ['main' => 0],
            ['plans_id' => $plansId]
        );
        if ($image && $this->plansTable->PlansImages->save($this->plansTable->PlansImages->patchEntity($image, ['main' => 1]))) {
            $this->Flash->success(__("Imagem definida como principal"));
        } else {
            $this->Flash->error(__("Não foi possível definir a imagem como principal. Por favor tente novamente."));
        }

        return $this->redirect(['action' => 'edit', $plansId]);
    }

    /**
     * @param null $id
     * @param null $planId
     * @return \Cake\Http\Response|null
     */
    public function deleteImage($id = null, $planId = null)
    {
        if (!$id && !$planId) {
            return $this->redirect(['controller' => 'plans', 'action' => 'index']);
        }
        $image = $this->plansTable->PlansImages->get($id);
        if ($image && $this->plansTable->PlansImages->delete($image)) {
            $this->Flash->success(__('A imagem foi excluída.'));
        } else {
            $this->Flash->error(__('A imagem não foi excluída. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'edit', $planId]);
    }

    /**
     *
     */
    public function status()
    {
        $this->request->allowMethod(['post']);

        $json = [
            'status' => false,
            'message' => 'Plano não encontrado'
        ];

        $status_name = [1 => 'habilitado', 2 => 'desabilitado'];

        $plan = $this->plansTable->get($this->request->getData('plan_id'));

        if ($plan) {
            if ($this->request->getData('status')) {
                $status = $this->request->getData('status');
            } else {
                $status = $plan->status === 1 ? 2 : 1;
            }
            $plan = $this->plansTable->patchEntity($plan, ['status' => $status]);
            if ($this->plansTable->save($plan)) {
                $json = [
                    'status' => true,
                    'message' => 'O status do plano <strong>' . $plan->name . '</strong> foi alterado'
                ];
            } else {
                $json['message'] = 'O status do plano <strong>' . $plan->name . '</strong> não foi alterado. Por favor, tente novamente.';
            }
        }

        $this->set(compact('json'));
    }

    /**
     *
     */
    public function subscriptions()
    {
        $conditions = [];
        $filter = [
            'plans_id' => ''
        ];

        if ($this->request->getQuery('plans_id')) {
            $conditions[] = ['Subscriptions.plans_id' => $this->request->getQuery('plans_id')];
            $filter['plans_id'] = $this->request->getQuery('plans_id');
        }


        $plans = $this->plansTable->find('list')
            ->orderAsc('Plans.name')
            ->toArray();

        $query = $this->plansTable->Subscriptions->find()
            ->contain([
                'Customers',
                'Plans'
            ])
            ->where($conditions)
            ->orderDesc('Subscriptions.created');

        $subscriptions = $this->paginate($query);

        $this->set(compact('plans', 'subscriptions', 'filter'));
    }

    public function subscriptionView($subscriptionId)
    {
        try {
            $subscription = $this->plansTable->Subscriptions->getSubscription($subscriptionId);

            $subscription_shipping_status = $this->plansTable->Subscriptions->SubscriptionShipments->SubscriptionShippingStatus->find('list')
                ->toArray();

            $this->set(compact('subscription', 'subscription_shipping_status'));
        } catch (\Exception $e) {
            $this->Flash->error('Assinatura não encontrada');
            return $this->redirect(['controller' => 'plans', 'action' => 'subscriptions']);
        }
    }

    public function shipmentStatus()
    {
        try {
            if (!$this->request->is(['post'])) {
                throw new \Exception('Metodo nao permitido', 400);
            }

            $data = $this->request->getData();

            $table = $this->plansTable->Subscriptions->SubscriptionShipments;

            /** @var SubscriptionShipment $shipment */
            $shipment = $table->get($data['subscriptionShipmentId'], [
                'contain' => [
                    'SubscriptionShippingStatus'
                ]
            ]);
            $subscription = $this->plansTable->Subscriptions->getSubscription($shipment->subscriptions_id);
            $shipment->status_id = $data['statusId'];
            if ($data['tracking']) {
                $shipment->status_text = $data['tracking'];

                /** @var Email $serviceEmail */
                $serviceEmail = new Email();
                $serviceEmail->sendProductShipping($subscription, $shipment);
            }
            $table->save($shipment);

            $status = $table->SubscriptionShippingStatus->get($data['statusId']);
            $response = \GuzzleHttp\json_encode(['statusName' => $status->name]);

            return new Response([
                'body' => $response,
                'status' => 202
            ]);
        } catch (\Exception $e) {
            return new Response([
                'body' => $e->getMessage(),
                'status' => 400
            ]);
        }
    }

    public function subscriptionCancel($subscriptionId)
    {
        try {
            if (!$this->request->is(['post'])) {
                throw new \Exception('Método não permitido', 403);
            }

            $subscription = $this->plansTable->Subscriptions->getSubscription($subscriptionId);
            $componentPayment = $subscription->payment_component;

            $this->loadComponent(sprintf('Subscriptions.%s', $componentPayment));

            $this->$componentPayment->cancel($subscription);

            $subscription = $this->plansTable->Subscriptions->patchEntity($subscription, [
                'status' => 0
            ]);

            if ($this->plansTable->Subscriptions->save($subscription)) {
                /** @var Email $serviceEmail */
                $serviceEmail = new Email();
                $serviceEmail->sendSubscriptionCancel($subscription);

                $this->Flash->success('Assinatura cancelada');
                return $this->redirect($this->referer());
            }

            throw new \Exception('Ocorreu um erro ao cancelar a assinatura, tente novamente', 400);
        } catch (\Exception $e) {
            $this->Flash->error($e->getMessage());
            return $this->redirect($this->referer());
        }
    }
}
