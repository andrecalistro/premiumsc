<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar PayPal Express Checkout</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($paypal_express, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-6 form-group">
                <?= $this->Form->control('label', ['label' => 'Nome para exibição', 'value' => $paypal_express->label, 'class' => 'form-control']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $paypal_express->status]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('api_username', ['class' => 'form-control', 'label' => ['text' => 'API Username', 'escape' => false], 'value' => $paypal_express->api_username]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('api_password', ['class' => 'form-control', 'label' => ['text' => 'API Password', 'escape' => false], 'value' => $paypal_express->api_password]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('api_signature', ['class' => 'form-control', 'label' => ['text' => 'API Signature', 'escape' => false], 'value' => $paypal_express->api_signature]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <?= $this->Form->control('client_id', ['class' => 'form-control', 'label' => 'Client ID', 'value' => $paypal_express->client_id, 'type' => 'text']) ?>
            </div>

            <div class="col-md-6 form-group">
                <?= $this->Form->control('client_secret', ['class' => 'form-control', 'label' => 'Client Secret', 'value' => $paypal_express->client_secret]) ?>
            </div>
        </div>

        <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <label>Ativar ambiente de testes</label>
                    <?= $this->Form->control('test', ['label' => false, 'empty' => 0, 'options' => $tests, 'type' => 'radio', 'value' => $paypal_express->test]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_waiting', ['class' => 'form-control', 'label' => ['text' => 'Aguardando Pagamento', 'escape' => false], 'value' => $paypal_express->status_waiting, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_authorized', ['class' => 'form-control', 'label' => ['text' => 'Pagamento aprovado', 'escape' => false], 'value' => $paypal_express->status_authorized, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_cancelled', ['class' => 'form-control', 'label' => ['text' => 'Pagamento recusado/Não aprovado', 'escape' => false], 'value' => $paypal_express->status_cancelled, 'options' => $ordersStatuses]) ?>
                </div>
            </div>
        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>