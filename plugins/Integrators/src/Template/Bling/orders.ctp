<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['Admin.sales/orders.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="page-title">
    <h2>Minhas Vendas</h2>
</div>
<div class="content">
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>Ref.</th>
                <th>Cliente</th>
                <th>$ Total</th>
                <th>Metodo de Pagamento</th>
                <th>Data</th>
                <th>Status</th>
                <th>Bling Status</th>
                <th></th>
            </tr>
            <tr>
                <?= $this->Form->create('filter', ['autocomplete' => 'off', 'type' => 'get']) ?>
                <th><?= $this->Form->control('id', ['class' => 'form-control', 'label' => false, 'placeholder' => 'ID', 'value' => $filter['id']]) ?></th>
                <th><?= $this->Form->control('customer', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Cliente', 'value' => $filter['customer']]) ?></th>
                <th></th>
                <th><?= $this->Form->control('payment_method', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Método de pagamento', 'options' => $payments_methods, 'value' => $filter['payment_method'], 'empty' => true]) ?></th>
                <th>
                    <?= $this->Form->control('created', ['class' => 'form-control input-datepicker', 'label' => false, 'placeholder' => 'Data', 'value' => $filter['created']]) ?>
                </th>
                <th><?= $this->Form->control('orders_statuses_id', ['class' => 'form-control', 'options' => $statuses, 'label' => false, 'placeholder' => 'Status', 'empty' => true, 'value' => $filter['orders_statuses_id']]) ?></th>
                <th></th>
                <th>
                    <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary', 'title' => 'Buscar']) ?>
                    <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'bling', 'action' => 'orders'], ['class' => 'btn btn-default', 'escape' => false, 'title' => 'Todos os pedidos']) ?>
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
                        <td><?= $order->total_format ?></td>
                        <td>
                            <?php if ($order->payments_method): ?>
                                <div class="row">
                                    <div class="col-md-3 col-xs-3">
                                        <?= $this->Html->image($order->payments_method->image_link, ['width' => 30]) ?>
                                    </div>
                                    <div class="col-md-9 col-xs-9">
                                        <?= $order->payments_method->name ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><?= $order->created->format("d/m/Y") ?></td>
                        <td id="order-status-name-<?= $order->id ?>"><?= $order->orders_status->name ?></td>
                        <td><?= $order->bling_status ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>', ['controller' => 'orders', 'action' => 'view', $order->id], ['escape' => false, 'class' => 'btn btn-sm btn-primary', 'title' => 'Visualizar Pedido']) ?>
                            <a class="btn btn-success btn-sm"
                               href="<?= $this->Url->build(['controller' => 'bling', 'action' => 'synchronize-order', $order->id]) ?>"
                               title="Sincronizar"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->element('pagination') ?>