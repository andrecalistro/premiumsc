<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Avaliações de Produtos</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($config, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-4 form-group">
                <?= $this->Form->control('orders_statuses_id', ['class' => 'form-control', 'label' => 'Status do pedido que pode receber o e-mail de avaliação', 'value' => $config->orders_statuses_id, 'options' => $ordersStatuses]) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('days', ['class' => 'form-control', 'label' => 'Qtde. de dias após o pedido estar em determinado status para envio do e-mail de avaliação', 'value' => $config->days]) ?>
            </div>

            <div class="col-md-4 form-group">
                <label>Habilitar envio do e-mail de avaliação</label>
                <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $config->status]) ?>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <?= $this->Html->link("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Cancelar", ['controller' => 'products-ratings', 'plugin' => 'admin'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
            </div>
            <div class="col-md-6 col-xs-12 text-right">
                <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>