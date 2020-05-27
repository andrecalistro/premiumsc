<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Mercado Pago Cartão de Crédito</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($mp_ticket, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-4 form-group">
                <?= $this->Form->control('label', ['label' => 'Nome para exibição', 'value' => $mp_ticket->label, 'class' => 'form-control']) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('additional_days', ['label' => 'Dias adicionais para vencimento', 'value' => $mp_ticket->additional_days, 'class' => 'form-control', 'type' => 'number']) ?>
            </div>

            <div class="col-md-4 form-group">
                <label>Status</label>
                <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $mp_ticket->status]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <?= $this->Form->control('public_key', ['class' => 'form-control', 'label' => 'Chave pública', 'value' => $mp_ticket->public_key]) ?>
            </div>

            <div class="col-md-6 form-group">
                <?= $this->Form->control('access_token', ['class' => 'form-control', 'label' => 'Token', 'value' => $mp_ticket->access_token]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('status_pending', ['class' => 'form-control', 'label' => ['text' => 'Aguardando Pagamento', 'escape' => false], 'value' => $mp_ticket->status_pending, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('status_approved', ['class' => 'form-control', 'label' => ['text' => 'Pagamento aprovado', 'escape' => false], 'value' => $mp_ticket->status_approved, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('status_cancelled', ['class' => 'form-control', 'label' => ['text' => 'Pagamento cancelado', 'escape' => false], 'value' => $mp_ticket->status_cancelled, 'options' => $ordersStatuses]) ?>
                </div>
            </div>
        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>