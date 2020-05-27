<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Exception\Exception;
use Cake\I18n\Date;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Utility\Text;
use Carbon\Carbon;
use Checkout\Model\Entity\Order;
use Eduardokum\LaravelBoleto\Boleto\Banco\Bradesco;
use Eduardokum\LaravelBoleto\Boleto\Render\Pdf;
use Eduardokum\LaravelBoleto\Util;

/**
 * Class BradescoTicketComponent
 * @package Checkout\Controller\Component
 *
 * @property \Checkout\Model\Table\PaymentsTable $Payments
 * @property OrderComponent $Order
 */
class BradescoTicketComponent extends Component
{
    public $Payments;
    public $Order;
    public $statuses;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Payments = TableRegistry::getTableLocator()->get('CheckoutV2.Payments');

        foreach ($this->Payments->findConfig('bradesco_ticket') as $key => $value) {
            $this->setConfig($key, $value);
        }

        $this->Order = new OrderComponent(new ComponentRegistry());
    }

    /**
     * @param array $data
     * @param null $orders_id
     * @return bool
     * @throws \Exception
     */
    public function process($data = [], $orders_id = null)
    {
        $order = $this->Order->getOrder($orders_id);

        $ticket = $this->generateTicket($order);
        $this->Order->update([
            'payment_url' => $ticket['payment_url'],
            'payment_code' => $ticket['payment_code'],
            'payment_method' => 'bradesco_ticket'
        ], $order->id);

        $this->Order->addHistory($order->id, $this->getConfig('status_awaiting_payment'), 'Boleto gerado<br><a href="' . $ticket['payment_url'] . '" target="_blank">Clique aqui para emitir a 2ª via</a>');

        return $ticket['payment_url'];
    }

    /**
     * @param Order $order
     * @return array
     * @throws \Exception
     */
    public function generateTicket(Order $order)
    {
        $recipient = new \Eduardokum\LaravelBoleto\Pessoa([
            'documento' => $this->getConfig('document'),
            'nome' => $this->getConfig('identification'),
            'cep' => $this->getConfig('zipcode'),
            'endereco' => $this->getConfig('address'),
            'bairro' => $this->getConfig('neighborhood'),
            'uf' => $this->getConfig('state'),
            'cidade' => $this->getConfig('city'),
        ]);
        $payer = new \Eduardokum\LaravelBoleto\Pessoa([
            'documento' => $order->customer->document,
            'nome' => $order->customer->name,
            'cep' => $order->zipcode,
            'endereco' => $order->address,
            'bairro' => $order->neighborhood,
            'uf' => $order->state,
            'cidade' => $order->city,
        ]);

        if ($this->getConfig('logo')) {
            $logo = Router::url('img' . DS . 'files' . DS . 'BradescoTickets' . DS . $this->getConfig('logo'), true);
        } else {
            $logo = $this->store->logo_link;
        }
        $due = Carbon::createFromFormat('Y-m-d H:i:s', $order->created->format('Y-m-d H:i:s'), 'America/Sao_Paulo')->addDays($this->getConfig('additional_days'));

        $ticket = new Bradesco([
            'logo' => $logo,
            'dataVencimento' => $due,
            'valor' => $order->total,
            'numero' => $order->id,
            'numeroDocumento' => $order->id,
            'pagador' => $payer,
            'beneficiario' => $recipient,
            'carteira' => $this->getConfig('account_wallet'),
            'agencia' => $this->getConfig('agency'),
            'conta' => $this->getConfig('account'),
            'descricaoDemonstrativo' => [$this->getConfig('demonstrative1'), $this->getConfig('demonstrative2'), $this->getConfig('demonstrative3')],
            'instrucoes' => [$this->getConfig('instructions1'), $this->getConfig('instructions2'), $this->getConfig('instructions3'), $this->getConfig('instructions4')],
        ]);
        $path_ticket = 'tickets' . DS . 'bradesco_ticket_' . Security::hash($order->id, 'sha1', true) . '.pdf';
        $pdf = new Pdf();
        $pdf->addBoleto($ticket);
        $pdf->hideInstrucoes();
        $pdf->gerarBoleto($pdf::OUTPUT_SAVE, WWW_ROOT . $path_ticket);

        $return = new \Eduardokum\LaravelBoleto\Cnab\Remessa\Cnab240\Banco\Bradesco([
            'idRemessa' => $order->id,
            'agencia' => $this->getConfig('agency'),
            'carteira' => $this->getConfig('account_wallet'),
            'conta' => $this->getConfig('account'),
            'contaDv' => $this->getConfig('account_digit'),
            'codigoCliente' => $order->customer->id,
            'beneficiario' => $recipient,
        ]);
        $return->addBoleto($ticket);
        $path_return = 'tickets' . DS . 'bradesco_return_' . $order->id . '.txt';
        $return->save(WWW_ROOT . $path_return);

        $this->saveTicket([
            'ticket_code' => $ticket->getNossoNumero(),
            'due' => $due,
            'orders_id' => $order->id,
            'amount' => $order->total,
            'payment_code' => 'bradesco_ticket',
            'send_file' => $path_return,
            'ticket_file' => $path_ticket
        ]);

        return [
            'payment_url' => Router::url($path_ticket, true),
            'payment_code' => $ticket->getNossoNumero()
        ];
    }

    /**
     * @param $data
     * @return mixed
     */
    public function saveTicket($data)
    {
        $PaymentsTickets = TableRegistry::getTableLocator()->get('Admin.PaymentsTickets');
        return $PaymentsTickets->saveTicket($data);
    }
}