<?php

namespace Subscriptions\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Checkout\Model\Entity\Customer;
use Checkout\Model\Entity\CustomersAddress;
use Subscriptions\Model\Entity\Plan;
use Subscriptions\Model\Entity\Subscription;
use Subscriptions\Model\Table\PlansTable;
use Subscriptions\Model\Table\SubscriptionsTable;

/**
 * Class SubscriptionComponent
 * @package Subscriptions\Controller\Component
 */
class SubscriptionComponent extends Component
{
    /** @var SubscriptionsTable */
    public $subscriptionsTable;

    /** @var PlansTable */
    public $plansTable;

    public $components = ['Pagseguro'];

    /** @var object */
    public $payment_config;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->plansTable = TableRegistry::getTableLocator()->get('Subscriptions.Plans');
        $this->subscriptionsTable = TableRegistry::getTableLocator()->get('Subscriptions.Subscriptions');

        if (isset($config['payment_config'])) {
            $this->payment_config = $config['payment_config'];
        }
    }

    /**
     * @param Customer $customer
     * @param $planId
     * @return array|\Subscriptions\Model\Entity\Subscription
     * @throws \Exception
     */
    public function create(Customer $customer, $planId)
    {
        try {
            $plan = $this->plansTable->getPlan($planId);

            $subscription = [
                'customers_id' => $customer->id,
                'plans_id' => $plan->id,
                'plans_name' => $plan->name,
                'plans_image' => $plan->main_image,
                'status' => 0,
                'frequency_billing_days' => $plan->plan_billing_frequency->days,
                'frequency_delivery_days' => $plan->plan_delivery_frequency->days,
                'price' => $plan->price,
            ];
            $subscription = $this->subscriptionsTable->newEntity($subscription);

            if (!$this->subscriptionsTable->save($subscription)) {
                throw new \Exception(sprintf('Erro ao salvar inscrição: %s', \GuzzleHttp\json_encode($subscription->getErrors())), 400);
            }

            return $subscription;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Subscription $subscription
     * @param CustomersAddress $address
     * @return bool|Subscription
     */
    public function setCustomerAddress(Subscription $subscription, CustomersAddress $address)
    {
        $subscription = $this->subscriptionsTable->patchEntity($subscription, [
            'customers_addresses_id' => $address->id
        ]);
        return $this->subscriptionsTable->save($subscription);
    }

    /**
     * @param Subscription $subscription
     * @param $addresses_id
     * @param array $data
     * @return bool|Subscription
     */
    public function setPriceShipment(Subscription $subscription, $addresses_id, array $data)
    {
        $subscription = $this->subscriptionsTable->patchEntity($subscription, [
            'price_shipment' => $data['shipping_total'],
            'customers_addresses_id' => (int)$addresses_id
        ]);

        if($this->subscriptionsTable->save($subscription))
            return true;

        return false;
    }
}