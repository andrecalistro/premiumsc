<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Store $store
 */
?>
<div class="page-title">
    <h2>Configurar Bling</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($bling) ?>
        <div class="row">
            <div class="col-md-6 form-group">
                <?= $this->Form->control('api_key', ['label' => 'API Key', 'value' => $bling->api_key, 'class' => 'form-control']) ?>
            </div>
            <div class="col-md-4 form-group">
                <label>Status</label>
                <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $bling->status]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <?= $this->Form->control('synchronize_providers', ['label' => 'Sincronzar fornecedores automaticamente ao cadastrar ou editar', 'value' => 1, 'type' => 'checkbox', 'default' => $bling->synchronize_providers]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <?= $this->Form->control('synchronize_customers', ['label' => 'Sincronzar clientes automaticamente ao cadastrar ou editar', 'value' => 1, 'type' => 'checkbox', 'default' => $bling->synchronize_customers]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <?= $this->Form->control('synchronize_products', ['label' => 'Sincronzar produtos automaticamente ao cadastrar, editar ou excluir', 'value' => 1, 'type' => 'checkbox', 'default' => $bling->synchronize_products]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                <?= $this->Form->control('synchronize_orders', ['label' => 'Sincronzar pedidos automaticamente', 'value' => 1, 'type' => 'checkbox', 'default' => $bling->synchronize_orders]) ?>
            </div>
            <div class="col-md-4 form-group">
                <?= $this->Form->control('synchronize_orders_statuses_id', ['label' => 'Com qual status o pedido deve ser sincronizado', 'options' => $orders_statuses, 'class' => 'form-control', 'value' => $bling->synchronize_orders_statuses_id, 'empty' => true]) ?>
            </div>
        </div>
        <hr>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'bling', 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>