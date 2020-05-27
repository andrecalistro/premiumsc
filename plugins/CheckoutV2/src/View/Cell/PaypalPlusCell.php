<?php

namespace CheckoutV2\View\Cell;

use Cake\Controller\ComponentRegistry;
use Cake\View\Cell;
use Checkout\Controller\Component\OrderComponent;
use Checkout\Controller\Component\PaypalPlusComponent;

/**
 * Class PaypalPlusCell
 * @package Checkout\View\Cell
 */
class PaypalPlusCell extends Cell
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
        $PaypalPlus = new PaypalPlusComponent(new ComponentRegistry(), ['payment_config' => $payment_config, 'store' => $store]);
        $approval_url = $PaypalPlus->beforePay($this->request->getSession()->read('orders_id'));
        $mode = $PaypalPlus->getMode();

        $customer_name = explode(" ", $customer['name']);
        $first_name = $customer_name[0];
        $last_name = str_replace($customer_name[0] . ' ', '', $customer['name']);
        $email = $customer['email'];

        if ($mode === 'sandbox') {
            $email = $PaypalPlus->getConfig('email_sandbox');
        }

        $this->set(compact('approval_url', 'customer', 'mode', 'first_name', 'last_name', 'email'));
        $this->viewBuilder()->setTemplatePath('Cell/Payment')->setTemplate('paypal_plus');
    }
}
