<?php

namespace Admin\Controller;

use Admin\Model\Table\PaymentsTicketsTable;

/**
 * Class PaymentsTicketsController
 * @package Admin\Controller\Payments
 *
 * @property PaymentsTicketsTable $PaymentsTickets
 */
class PaymentsTicketsController extends AppController
{
    public function index()
    {
        $tickets = $this->paginate($this->PaymentsTickets->find()
            ->order([
                'PaymentsTickets.id' => 'desc'
            ]));

        $this->set(compact('tickets'));
    }
}