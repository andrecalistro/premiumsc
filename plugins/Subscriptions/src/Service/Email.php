<?php

namespace Subscriptions\Service;

use Admin\Model\Entity\EmailTemplate;
use Admin\Model\Table\EmailQueuesTable;
use Admin\Model\Table\EmailTemplatesTable;
use Admin\Model\Table\StoresTable;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Subscriptions\Model\Entity\Subscription;
use Subscriptions\Model\Entity\SubscriptionShipment;

final class Email
{
    /** @var EmailTemplatesTable */
    private $emailTemplateTable;

    /** @var EmailQueuesTable */
    private $emailQueueTable;

    /** @var \stdClass */
    private $store;

    public function __construct()
    {
        $this->emailTemplateTable = TableRegistry::getTableLocator()->get('Admin.EmailTemplates');
        $this->emailQueueTable = TableRegistry::getTableLocator()->get('Admin.EmailQueues');

        /** @var StoresTable $Stores */
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $this->store = $Stores->getConfig();
    }

    /**
     * @param string $slug
     * @return array|\Cake\Datasource\EntityInterface|null
     */
    private function getTemplate(string $slug)
    {
        return $this->emailTemplateTable->find()
            ->where(['slug' => $slug])
            ->first();
    }

    /**
     * @param Subscription $subscription
     * @param $template
     * @param array $data
     * @return bool
     */
    private function send(Subscription $subscription, $template, array $data)
    {
        $html = $this->emailTemplateTable->buildHtml($template, $data);

        $email = $this->emailQueueTable->newEntity([
            'from_name' => $template->from_name,
            'from_email' => $template->from_email,
            'subject' => $template->subject,
            'content' => $html,
            'to_name' => $subscription->customer->name,
            'to_email' => $subscription->customer->email,
            'email_statuses_id' => 1,
            'reply_name' => $template->reply_name,
            'reply_email' => $template->reply_email
        ]);

        $this->emailQueueTable->save($email);
        return true;
    }

    /**
     * @param Subscription $subscription
     * @return bool
     */
    public function sendNewSubscription(Subscription $subscription)
    {
        /** @var EmailTemplate $template */
        $template = $this->getTemplate('nova-assintaura');

        if (!$template) {
            return false;
        }

        $data = [
            'name' => $subscription->customer->name,
            'plan' => $subscription->plan->name,
            'payment_method' => $subscription->payment_component,
            'billing_frequency' => $subscription->frequency_billing_name,
            'delivery_frequency' => $subscription->frequency_delivery_name,
            'total_subscription' => $subscription->price_format,
            'total_shipment' => $subscription->price_shipping_format,
            'total' => $subscription->price_total_format,
            'link' => Router::url(['_name' => 'customerSubscriptionView', $subscription->id], true),
            'email_sac' => $this->store->email_contact
        ];

        return $this->send($subscription, $template, $data);
    }

    /**
     * @param Subscription $subscription
     * @param SubscriptionShipment $subscriptionShipment
     * @return bool
     */
    public function sendProductShipping(Subscription $subscription, SubscriptionShipment $subscriptionShipment)
    {
        /** @var EmailTemplate $template */
        $template = $this->getTemplate('produto-assinatura-enviado');

        if (!$template) {
            return false;
        }

        $data = [
            'name' => $subscription->customer->name,
            'plan' => $subscription->plan->name,
            'code' => $subscriptionShipment->status_text,
            'email_sac' => $this->store->email_contact
        ];

        return $this->send($subscription, $template, $data);
    }

    /**
     * @param Subscription $subscription
     * @return bool
     */
    public function sendPaymentFailure(Subscription $subscription)
    {
        /** @var EmailTemplate $template */
        $template = $this->getTemplate('produto-assinatura-enviado');

        if (!$template) {
            return false;
        }

        $data = [
            'name' => $subscription->customer->name,
            'link' => Router::url(['_name' => 'customerSubscriptionView', $subscription->id], true),
            'email_sac' => $this->store->email_contact
        ];

        return $this->send($subscription, $template, $data);
    }

    /**
     * @param Subscription $subscription
     * @return bool
     */
    public function sendNewPayment(Subscription $subscription)
    {
        /** @var EmailTemplate $template */
        $template = $this->getTemplate('nova-cobranca-assinatura');

        if (!$template) {
            return false;
        }

        $data = [
            'name' => $subscription->customer->name,
            'plan' => $subscription->plan->name,
            'total_subscription' => $subscription->price_format,
            'total_shipment' => $subscription->price_shipping_format,
            'total' => $subscription->price_total_format,
            'link' => Router::url(['_name' => 'customerSubscriptionView', $subscription->id], true),
            'email_sac' => $this->store->email_contact
        ];

        return $this->send($subscription, $template, $data);
    }

    /**
     * @param Subscription $subscription
     * @return bool
     */
    public function sendSubscriptionCancel(Subscription $subscription)
    {
        /** @var EmailTemplate $template */
        $template = $this->getTemplate('assinatura-cancelada');

        if (!$template) {
            return false;
        }

        $data = [
            'name' => $subscription->customer->name,
            'plan' => $subscription->plan->name,
            'link' => Router::url(['_name' => 'customerSubscriptionView', $subscription->id], true),
            'email_sac' => $this->store->email_contact
        ];

        return $this->send($subscription, $template, $data);
    }
}