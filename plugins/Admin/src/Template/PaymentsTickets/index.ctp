<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script('Admin.payments/payments-tickets.functions.js', ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Boletos Gerados</h2>
        </div>
    </div>
<?= $this->element('pagination') ?>
    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('orders_id', 'Pedido') ?></th>
                    <th><?= $this->Paginator->sort('ticket_code', 'Nosso número') ?></th>
                    <th><?= $this->Paginator->sort('amount', 'Valor') ?></th>
                    <th><?= $this->Paginator->sort('amount_paid', 'Valor Pago') ?></th>
                    <th><?= $this->Paginator->sort('payment_date', 'Data do pgto.') ?></th>
                    <th><?= $this->Paginator->sort('return_link', 'Remessa') ?></th>
                    <th><?= $this->Paginator->sort('payments_tickets_returns_id', 'Retorno') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Criado em') ?></th>
                    <th></th>
                </tr>

                </thead>
                <tbody>
                <?php if ($tickets): ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <tr>
                            <td><?= $ticket->orders_id ?></td>
                            <td><?= $ticket->ticket_code ?></td>
                            <td><?= $ticket->amount_format ?></td>
                            <td><?= $ticket->amount_paid_format ?></td>
                            <td><?= $ticket->payment_date ?></td>
                            <td><a href="<?= \Cake\Routing\Router::url($ticket->send_file, true) ?>" target="_blank">Remessa</a></td>
                            <td><?= $ticket->payments_tickets_returns_id ?></td>
                            <td><?= $ticket->created->format('d/m/Y H:i') ?></td>
                            <td>
                                <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>', $ticket->ticket_link, ['escape' => false, 'class' => 'btn btn-sm btn-primary', 'title' => 'Visualizar Boleto', 'target' => '_blank']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>