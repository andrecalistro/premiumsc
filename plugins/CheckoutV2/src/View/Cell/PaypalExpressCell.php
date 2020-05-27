<?php

namespace CheckoutV2\View\Cell;

use Cake\View\Cell;

/**
 * Shipment cell
 */
class PaypalExpressCell extends Cell
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
    public function getPaymentHtml()
    {
        $this->viewBuilder()->setTemplatePath('Cell/Payment')->setTemplate('paypal_express');
    }
}
