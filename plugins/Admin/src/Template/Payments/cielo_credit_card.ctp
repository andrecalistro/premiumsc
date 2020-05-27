<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Cielo Cartão de Crédito</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($cielo_credit_card, ['type' => 'file']) ?>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#data" aria-controls="data" role="tab" data-toggle="tab">Dados</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="data">
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <?= $this->Form->control('label', ['label' => 'Nome para exibição', 'value' => $cielo_credit_card->label, 'class' => 'form-control']) ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('merchant_id', ['class' => 'form-control', 'label' => 'Cliente ID', 'value' => $cielo_credit_card->merchant_id, 'type' => 'text']) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('merchant_key', ['class' => 'form-control', 'label' => 'Cliente Key', 'value' => $cielo_credit_card->merchant_key]) ?>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Ambiente</label>
                            <?= $this->Form->control('environment', ['label' => false, 'empty' => 0, 'options' => $environments, 'type' => 'radio', 'value' => $cielo_credit_card->environment]) ?>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status</label>
                            <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $cielo_credit_card->status]) ?>
                        </div>
                    </div>
                </div>
                <hr>
                <h4>Status do pedido</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('status_waiting_payment', ['class' => 'form-control', 'label' => ['text' => 'Aguardando Pagamento <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o pagamento ainda não foi confirmado."></span>', 'escape' => false], 'value' => $cielo_credit_card->status_waiting_payment, 'options' => $ordersStatuses]) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('status_approved_payment', ['class' => 'form-control', 'label' => ['text' => 'Pagamento confirmado <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o pagamento ainda não foi confirmado."></span>', 'escape' => false], 'value' => $cielo_credit_card->status_approved_payment, 'options' => $ordersStatuses]) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('status_canceled_payment', ['class' => 'form-control', 'label' => ['text' => 'Pagamento em disputa <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o pedido for cancelado."></span>', 'escape' => false], 'value' => $cielo_credit_card->status_canceled_payment, 'options' => $ordersStatuses]) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('status_payment_analysis', ['class' => 'form-control', 'label' => ['text' => 'Pagamento em análise <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o comprador pagou mas a transação está sendo analisada."></span>', 'escape' => false], 'value' => $cielo_credit_card->status_payment_analysis, 'options' => $ordersStatuses]) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('status_not_approval_payment', ['class' => 'form-control', 'label' => ['text' => 'Pagamento não aprovado <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o pagamento anão foi aprovado."></span>', 'escape' => false], 'value' => $cielo_credit_card->status_not_approval_payment, 'options' => $ordersStatuses]) ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>