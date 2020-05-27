<?php

namespace CheckoutV2\View\Cell;

use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
use Checkout\Controller\Component\OrderComponent;
use Checkout\Model\Table\PaymentsTable;

/**
 * Shipment cell
 *
 * @var PaymentsTable $Payments
 */
class MoipCreditCardCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * @param $order
     * @param $payment_config
     * @param $user
     */
    public function getPaymentHtml($order, $payment_config, $user)
    {
        $this->viewBuilder()->setTemplatePath('Cell/Payment')->setTemplate('moip_credit_card');

        $Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');
        $public_key = $Payments->getConfig('moip_credit_card_public_key');

        $Customers = TableRegistry::getTableLocator()->get('CheckoutV2.Customers');
        $customer = $Customers->get($user['id']);
        $document = $customer->document;
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

        $Order = new OrderComponent(new ComponentRegistry());
        $installments = $Order->installments($payment_config, $order->total);

        $this->set(compact('public_key', 'document', 'name', 'birth_date', 'months', 'years', 'installments'));
    }
}
