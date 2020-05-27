<?php
/**
 * @var \App\View\AppView $this
 */
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Minhas Vendas com Melhor Envio</h2>
        </div>
    </div>

    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th>Ref.</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Valor do Frete</th>
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
                            <td><?= $order->total_format ?></td>
                            <td><?= $order->shipping_total_format ?></td>
                            <td><?= $order->created->format("d/m/Y") ?></td>
                            <td id="order-status-name-<?= $order->id ?>"
                                style="background: <?= $order->orders_status->background_color ?>; color: <?= $order->orders_status->font_color ?>">
                                <?= $order->orders_status->name ?>
                            </td>
                            <td>
                                <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>', ['controller' => 'orders', 'action' => 'view', $order->id], ['escape' => false, 'class' => 'btn btn-sm btn-primary', 'title' => 'Visualizar Pedido', 'target' => '_blank']) ?>
                                <?= $this->Html->link('<i class="fa fa-truck" aria-hidden="true"></i>', ['controller' => 'api-best-shipping', 'action' => 'buy-shipping', 'plugin' => 'integrators', $order->id], ['escape' => false, 'class' => 'btn btn-sm btn-default', 'title' => 'Comprar Frete do Melhor Envio']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>