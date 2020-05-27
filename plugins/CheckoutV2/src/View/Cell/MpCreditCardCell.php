<?php

namespace CheckoutV2\View\Cell;

use Cake\Controller\ComponentRegistry;
use Cake\I18n\Time;
use Cake\View\Cell;
use Checkout\Controller\Component\MpCreditCardComponent;

/**
 * Class MpCreditCardCell
 * @package Checkout\View\Cell
 */
class MpCreditCardCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     *
     */
    public function getPaymentHtml($order, $payment_config, $customer, $store)
    {
        $MpCreditCard = new MpCreditCardComponent(new ComponentRegistry(), ['payment_config' => $payment_config, 'store' => $store]);
        $public_key = $MpCreditCard->getConfig('public_key');

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
        $document = $customer['document'];
        $name = $customer['name'];
        if (!$customer['birth_date']) {
            $birth_date = false;
        } else {
            $birth_date = $customer['birth_date']->format('d/m/Y');
        }
        $order_total = $order->subtotal - $order->coupon_discount;

        $this->viewBuilder()->setTemplatePath('Cell/Payment')->setTemplate('mp_credit_card');
        $this->set(compact('months', 'years', 'public_key', 'name', 'document', 'birth_date', 'order_total'));
    }
}
