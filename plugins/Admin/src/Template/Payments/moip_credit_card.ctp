<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Moip Cartão de Crédito</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($moip, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-6 form-group">
                <?= $this->Form->control('label', ['label' => 'Nome para exibição', 'value' => $moip->label, 'class' => 'form-control']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('email', ['class' => 'form-control', 'label' => ['text' => 'E-mail <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="E-mail da conta do Moip."></span>', 'escape' => false], 'value' => $moip->email]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Ambiente</label>
                    <?= $this->Form->control('environment', ['label' => false, 'empty' => 0, 'options' => $environments, 'type' => 'radio', 'value' => $moip->environment]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $moip->status]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                    <?= $this->Form->control('token', ['class' => 'form-control', 'label' => ['text' => 'Token', 'escape' => false], 'value' => $moip->token]) ?>
                </div>
            </div>

            <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                    <?= $this->Form->control('key', ['class' => 'form-control', 'label' => ['text' => 'Key', 'escape' => false], 'value' => $moip->key]) ?>
                </div>
            </div>

            <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                    <?= $this->Form->control('public_key', ['class' => 'form-control', 'label' => ['text' => 'Chave pública', 'escape' => false], 'value' => $moip->public_key, 'type' => 'textarea']) ?>
                </div>
            </div>
        </div>

        <hr>
        <h4>Status do pedido</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_waiting', ['class' => 'form-control', 'label' => ['text' => 'Aguardando Pagamento', 'escape' => false], 'value' => $moip->status_waiting, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_in_analysis', ['class' => 'form-control', 'label' => ['text' => 'Pagamento em análise', 'escape' => false], 'value' => $moip->status_in_analysis, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_approved_payment', ['class' => 'form-control', 'label' => ['text' => 'O valor do pagamento está reservado', 'escape' => false], 'value' => $moip->status_pre_authorized, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_authorized', ['class' => 'form-control', 'label' => ['text' => 'Pagamento autorizado', 'escape' => false], 'value' => $moip->status_authorized, 'options' => $ordersStatuses]) ?>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_cancelled', ['class' => 'form-control', 'label' => ['text' => 'Pagamento cancelado', 'escape' => false], 'value' => $moip->status_cancelled, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_refunded', ['class' => 'form-control', 'label' => ['text' => 'Pagamento reembolsado', 'escape' => false], 'value' => $moip->status_refunded, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_reversed', ['class' => 'form-control', 'label' => ['text' => 'Pagamento revertido', 'escape' => false], 'value' => $moip->status_reversed, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_settled', ['class' => 'form-control', 'label' => ['text' => 'Pagamento liquidado', 'escape' => false], 'value' => $moip->status_settled, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>