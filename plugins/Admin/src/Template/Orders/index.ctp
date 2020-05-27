<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['Admin.sales/orders.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="navbarBtns">
    <div class="page-title">
        <h2>Minhas Vendas</h2>
    </div>

    <div class="navbarRightBtns">
        <a class="btn btn-primary btn-sm navbarBtn"
           href="<?= $this->Url->build(['controller' => 'orders', 'action' => 'add', 'plugin' => 'admin']) ?>">Nova venda</a>
    </div>
</div>

<div class="content">
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>Ref.</th>
                <th>Cliente</th>
                <th>Qtd</th>
                <th>Total</th>
                <th>Método Pgto</th>
                <th>Data</th>
                <th>Status</th>
                <th></th>
            </tr>
            <tr>
                <?= $this->Form->create('filter', ['autocomplete' => 'off', 'type' => 'get']) ?>
                <th><?= $this->Form->control('id', ['class' => 'form-control', 'label' => false, 'placeholder' => 'ID', 'value' => $filter['id']]) ?></th>
                <th><?= $this->Form->control('customer', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Cliente', 'value' => $filter['customer']]) ?></th>
                <th></th>
                <th></th>
                <th><?= $this->Form->control('payment_method', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Método de pagamento', 'options' => $payments_methods, 'value' => $filter['payment_method'], 'empty' => true]) ?></th>
                <th>
                    <?= $this->Form->control('created', ['class' => 'form-control input-datepicker', 'label' => false, 'placeholder' => 'Data', 'value' => $filter['created']]) ?>
                </th>
                <th><?= $this->Form->control('orders_statuses_id', ['class' => 'form-control', 'options' => $statuses, 'label' => false, 'placeholder' => 'Status', 'empty' => true, 'value' => $filter['orders_statuses_id']]) ?></th>
                <th>
                    <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary btn-sm', 'title' => 'Buscar']) ?>
                    <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'orders', 'action' => 'index'], ['class' => 'btn btn-default btn-sm', 'escape' => false, 'title' => 'Todos os pedidos']) ?>
                </th>
                <?= $this->Form->end() ?>
            </tr>
            </thead>
            <tbody>
            <?php if ($orders): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order->id ?></td>
                        <td>
                            <span><?= $order->customer->name ?></span>
                        </td>
                        <td><?= count($order->orders_products) ?></td>
                        <td><?= $order->total_format ?></td>
                        <td>
                            <?php if ($order->payments_method): ?>
								<?= $this->Html->image($order->payments_method->image_link, ['style' => 'border-radius:0', 'width' => 50, 'alt' => $order->payments_method->name]) ?>
                                <?= $order->payments_method->name ?>
                            <?php endif; ?>
                        </td>
                        <td><?= $order->created->format("d/m/Y") ?></td>
                        <td id="order-status-name-<?= $order->id ?>" style="background: <?= $order->orders_status->background_color ?>; color: <?= $order->orders_status->font_color ?>">
                            <?= $order->orders_status->name ?>
                        </td>
                        <td>
                            <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>', ['controller' => 'orders', 'action' => 'view', $order->id], ['escape' => false, 'class' => 'btn btn-sm btn-primary', 'title' => 'Visualizar Pedido']) ?>
                            <?= $this->Html->link('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', ['controller' => 'orders', 'action' => 'export-pdf', $order->id], ['escape' => false, 'class' => 'btn btn-sm btn-default', 'title' => 'Gerar PDF', 'target' => '_blank']) ?>
                            <?= $this->Html->link('<i class="fa fa-tag" aria-hidden="true"></i>', ['controller' => 'orders', 'action' => 'generate-tag-shipping', $order->id], ['escape' => false, 'class' => 'btn btn-sm btn-default', 'title' => 'Gerar Etiqueta para Envio', 'target' => '_blank']) ?>
                            <?= $this->Html->link('<i class="fa fa-truck" aria-hidden="true"></i>', '#', ['escape' => false, 'class' => 'btn btn-sm btn-default btn-register-tracking', 'title' => 'Cadastrar codigo/link de rastreio', 'data-orders-id' => $order->id, 'data-orders-status' => $order->orders_status->name]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->element('pagination') ?>

<div class="modal fade" id="modal-register-tracking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create('') ?>
            <?= $this->Form->hidden('orders_id') ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Cadastrar codigo/link de rastreio do pedido</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= $this->Form->control('orders_statuses_id', ['label' => 'Alterar status para', 'class' => 'form-control', 'options' => $statuses, 'empty' => 'Selecione...', 'required', 'val' => 4]) ?>
                </div>
                <div class="form-group">
                    <label>Notificar o cliente</label>
                    <?= $this->Form->control('notify_customer', ['label' => false, 'options' => [0 => 'Não', 1 => 'Sim'], 'type' => 'radio', 'value' => 0]) ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('tracking', ['label' => 'Codigo ou link para rastreio', 'class' => 'form-control', 'required']) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('shipping_sent_date', ['label' => 'Data em que o pedido foi enviado', 'class' => 'form-control input-date', 'required', 'placeholder' => 'dd/mm/aaaa']) ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>