<?php

namespace CheckoutV2\View\Cell;

use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
use CheckoutV2\Controller\Component\PagseguroTicketComponent;
use CheckoutV2\Model\Table\PaymentsTable;

/**
 * Shipment cell
 */
class PagseguroTicketCell extends Cell
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
     * @throws \Exception
     */
    public function getPaymentHtml($order, $payment_config, $customer, $store)
    {
        /** @var PaymentsTable $Payments */
        $Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');
        $ambient = $Payments->getConfig('pagseguro_ticket_environment');

        if ($ambient === 'sandbox') {
            $js = "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";
        } else {
            $js = "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";
        }

        $showLogo = $Payments->getConfig('pagseguro_ticket_show_logo');

        $PagseguroTicket = new PagseguroTicketComponent(new ComponentRegistry());
        $session_id = $PagseguroTicket->getSessionCode();

        $this->set(compact('js', 'session_id', 'customer', 'showLogo'));
        $this->viewBuilder()->setTemplatePath('Cell/Payment')->setTemplate('pagseguro_ticket');
    }
}