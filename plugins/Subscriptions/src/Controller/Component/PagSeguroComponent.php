<?php

namespace Subscriptions\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Exception\Exception;
use Cake\I18n\Date;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Checkout\Model\Entity\Customer;
use Checkout\Model\Entity\CustomersAddress;
use Checkout\Model\Entity\Order;
use PagSeguro\Domains\Requests\DirectPreApproval\Cancel;
use Subscriptions\Model\Entity\Plan;
use Subscriptions\Model\Entity\Subscription;

/**
 * Class PagseguroComponent
 * @package Checkout\Controller\Component
 *
 * @property \Checkout\Model\Table\PaymentsTable $Payments
 */
class PagSeguroComponent extends Component
{
    public $Payments;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Payments = TableRegistry::getTableLocator()->get('Checkout.Payments');

        foreach ($this->Payments->findConfig('pagseguro_credit_card') as $key => $value) {
            $this->setConfig($key, $value);
        }

        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");
        \PagSeguro\Configuration\Configure::setEnvironment($this->getConfig('environment'));
        \PagSeguro\Configuration\Configure::setAccountCredentials(
            $this->getConfig('email'),
            $this->getConfig('token')
        );
        \PagSeguro\Configuration\Configure::setCharset('UTF-8');
        \PagSeguro\Configuration\Configure::setLog(false, WWW_ROOT . 'logs/pagseguro.log');
    }

    /**
     * @param $data
     * @param Plan $plan
     * @param Customer $customer
     * @param CustomersAddress $customersAddress
     * @param $dataShipment
     * @param $ip
     * @return array
     */
    public function creditCard($data, Plan $plan, Customer $customer, CustomersAddress $customersAddress, $dataShipment, $ip)
    {
        $telephone = explode(" ", $data['telephone']);
        $customerEmail = $this->getConfig('environment') === 'sandbox' ? $this->getConfig('sandbox_email') : $customer->email;
        $reference = sprintf('assinatura-%s-%s', $plan->id, $customer->id);

        $preApproval = new \PagSeguro\Domains\Requests\DirectPreApproval\Accession();
        $preApproval->setPlan($plan->pagseguro_reference);
        $preApproval->setReference($reference);
        $preApproval->setSender()->setName($customer->name);
        $preApproval->setSender()->setEmail($customerEmail);
        $preApproval->setSender()->setIp($ip);
        $preApproval->setSender()->setAddress()->withParameters($customersAddress->address, $customersAddress->number, $customersAddress->neighborhood, $customersAddress->zipcode, $customersAddress->city, $customersAddress->state, 'BRA');

        $document = new \PagSeguro\Domains\DirectPreApproval\Document();
        $document->withParameters('CPF', $customer->document_clean); //assinante
        $preApproval->setSender()->setDocuments($document);
        $preApproval->setSender()->setPhone()->withParameters($customer->telephone_separated['area_code'], $customer->telephone_separated['number']); //assinante
        $preApproval->setPaymentMethod()->setCreditCard()->setToken($data['token']); //token do cartão de crédito gerado via javascript
        $preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setName($data['card_name']); //nome do titular do cartão de crédito
        $preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setBirthDate($data['birth_date']); //data de nascimento do titular do cartão de crédito
        $document = new \PagSeguro\Domains\DirectPreApproval\Document();
        $document->withParameters('CPF', preg_replace('/\D/', '', $data['document'])); //cpf do titular do cartão de crédito
        $preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setDocuments($document);
        $preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setPhone()->withParameters(preg_replace('/\D/', '', $telephone[0]), preg_replace('/\D/', '', $telephone[1])); //telefone do titular do cartão de crédito
        $preApproval->setPaymentMethod()->setCreditCard()->setHolder()->setBillingAddress()->withParameters($customersAddress->address, $customersAddress->number, $customersAddress->neighborhood, $customersAddress->zipcode, $customersAddress->city, $customersAddress->state, 'BRA'); //endereço do titular do cartão de crédito
        $response = $preApproval->register(
            new \PagSeguro\Domains\AccountCredentials($this->getConfig('email'), $this->getConfig('token')) // credencias do vendedor no pagseguro
        );

        $subscriptionPayment = new \PagSeguro\Domains\Requests\DirectPreApproval\Payment();
        $subscriptionPayment->setPreApprovalCode($response->code);
        $subscriptionPayment->setReference(sprintf('%s-1', $reference));
        $subscriptionPayment->setSenderIp($ip);
        $item = new \PagSeguro\Domains\DirectPreApproval\Item();
        $item->withParameters(
            $plan->id,
            $plan->name,
            1,
            $plan->price
        );
        if ($plan->shipping_required) {
            $item->weight = $plan->weight;
            $item->shippingCost = (float)$dataShipment['shipping_total'];
        }

        $subscriptionPayment->addItems($item);
        $responsePayment = $subscriptionPayment->register(
            new \PagSeguro\Domains\AccountCredentials($this->getConfig('email'), $this->getConfig('token'))
        );

        return [
            'code' => $response->code,
            'paymentCode' => $responsePayment->transactionCode
        ];
    }

    /**
     * @param string $paymentCode
     * @return mixed
     * @throws \Exception
     *
     * 1    Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
     * 2    Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
     * 3    Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
     * 4    Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
     * 5    Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
     * 6    Devolvida: o valor da transação foi devolvido para o comprador.
     * 7    Cancelada: a transação foi cancelada sem ter sido finalizada.
     * 8    Debitado: o valor da transação foi devolvido para o comprador.
     * 9    Retenção temporária: o comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.
     */
    public function checkStatus(string $paymentCode)
    {
        $response = \PagSeguro\Services\Transactions\Search\Code::search(
            \PagSeguro\Configuration\Configure::getAccountCredentials(),
            $paymentCode
        );

        $status = (int)$response->getStatus();

        if ($status !== 3) {
            throw new \Exception('Pagamento nao aprovado');
        }
        return $status;
    }

    /**
     * @param $ip
     * @param Subscription $subscription
     * @return mixed
     * @throws \Exception
     */
    public function processNextPayment($ip, Subscription $subscription)
    {
        try {
            $reference = sprintf('assinatura-%s-%s-%s-%s', $subscription->plan->id, $subscription->customers_id, $subscription->id, time());
            $subscriptionPayment = new \PagSeguro\Domains\Requests\DirectPreApproval\Payment();
            $subscriptionPayment->setPreApprovalCode($subscription->code);
            $subscriptionPayment->setReference($reference);
            $subscriptionPayment->setSenderIp($ip);
            $item = new \PagSeguro\Domains\DirectPreApproval\Item();
            $item->withParameters(
                $subscription->plan->id,
                $subscription->plan->name,
                1,
                $subscription->price
            );
            if ($subscription->plan->shipping_required) {
                $item->weight = $subscription->plan->weight;
                $item->shippingCost = $subscription->price_shipping;
            }

            $subscriptionPayment->addItems($item);
            return $subscriptionPayment->register(
                new \PagSeguro\Domains\AccountCredentials($this->getConfig('email'), $this->getConfig('token'))
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 400);
        }
    }

    /**
     * @param Subscription $subscription
     * @return mixed
     * @throws \Exception
     */
    public function cancel(Subscription $subscription)
    {
        try {
            $status = new Cancel();
            $status->setPreApprovalCode($subscription->code);

            return $status->register(
                new \PagSeguro\Domains\AccountCredentials($this->getConfig('email'), $this->getConfig('token'))
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 400);
        }
    }
}