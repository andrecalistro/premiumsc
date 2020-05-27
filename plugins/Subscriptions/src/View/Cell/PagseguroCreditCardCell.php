<?php

namespace Subscriptions\View\Cell;

use Cake\Controller\ComponentRegistry;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\View\Cell;
use Checkout\Controller\Component\PagseguroCreditCardComponent;
use Checkout\Model\Table\PaymentsTable;
use Subscriptions\Model\Entity\Plan;

/**
 * Shipment cell
 *
 * @var PaymentsTable $Payments
 * @var PagseguroCreditCardComponent $PagseguroCreditCard
 */
class PagseguroCreditCardCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * @param Plan $plan
     * @param $payment_config
     * @param $user
     */
    public function getPaymentHtml(Plan $plan, $payment_config, $user)
    {
        $this->viewBuilder()->setTemplatePath('Cell/Payment')->setTemplate('pagseguro_credit_card');

        /** @var PaymentsTable $Payments */
        $Payments = TableRegistry::getTableLocator()->get('Checkout.Payments');
        $ambient = $Payments->getConfig('pagseguro_credit_card_environment');

        if ($ambient === 'sandbox') {
            $js = "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";
        } else {
            $js = "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";
        }

        $Customers = TableRegistry::getTableLocator()->get('Checkout.Customers');
        $customer = $Customers->get($user['id']);
        $document = $customer->document;
        $telephone = $customer->telephone;
        $name = $customer->name;
        if (!$customer->birth_date) {
            $birth_date = false;
        } else {
            $birth_date = $customer->birth_date->format('d/m/Y');
        }

        $months = [
            "01" => "Janeiro (01)",
            "02" => "Fevereiro (02)",
            "03" => "Março (03)",
            "04" => "Abril (04)",
            "05" => "Maio (05)",
            "06" => "Junho (06)",
            "07" => "Julho (07)",
            "08" => "Agosto (08)",
            "09" => "Setembro (09)",
            "10" => "Outubro (10)",
            "11" => "Novembro (11)",
            "12" => "Dezembro (12)"
        ];

        $year_now = (int)Time::now('America/Sao_Paulo')->format("Y");
        $year_limit = $year_now + 15;
        for ($i = $year_now; $i <= $year_limit; $i++) {
            $years[$i] = $i;
        }

        $PagseguroCreditCard = new PagseguroCreditCardComponent(new ComponentRegistry());
        $session_id = $PagseguroCreditCard->getSessionCode();

        $total = $plan->price;

        $processPaymentUrl = Router::url(['_name' => 'planProcessPayment'], true);

        $this->set(compact('total', 'document', 'name', 'birth_date', 'months', 'years', 'telephone', 'js', 'session_id', 'processPaymentUrl'));
    }
}
