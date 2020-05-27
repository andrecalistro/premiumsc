<?php

namespace CheckoutV2\View\Cell;

use Cake\Core\Configure;
use Cake\View\Cell;

/**
 * Shipment cell
 */
class MoipTicketCell extends Cell
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
     * @param $customer
     * @param $store
     */
    public function getPaymentHtml($order, $payment_config, $customer, $store)
    {
        $this->viewBuilder()->setTemplatePath('Cell/Payment')->setTemplate('moip_ticket');
        $this->set(compact('customer'));
    }
}
