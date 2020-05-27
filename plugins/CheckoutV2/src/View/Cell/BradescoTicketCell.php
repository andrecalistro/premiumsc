<?php

namespace CheckoutV2\View\Cell;

use Cake\View\Cell;

/**
 * BradescoTicketCell cell
 */
class BradescoTicketCell extends Cell
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
        $this->set(compact('customer'));
        $this->viewBuilder()->setTemplatePath('Cell/Payment')->setTemplate('bradesco_ticket');
    }
}