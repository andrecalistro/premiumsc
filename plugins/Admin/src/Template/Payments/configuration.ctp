<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar parcelamento e desconto</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($payment, ['type' => 'file']) ?>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#debit-card" aria-controls="debit-card" role="tab" data-toggle="tab">Cartão de
                    Débito</a>
            </li>
            <li role="presentation"><a href="#credit-card" aria-controls="credit-card" role="tab" data-toggle="tab">Cartão de
                    Crédito</a>
            </li>
            <li role="presentation"><a href="#ticket" aria-controls="ticket" role="tab" data-toggle="tab">Boleto</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="debit-card">
                <div class="row">
                    <div class="form-group col-md-4">
                        <?= $this->Form->control('debit_discount', ['class' => 'form-control', 'label' => 'Desconto (%)', 'value' => $payment->debit_discount, 'type' => 'number']) ?>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade in" id="credit-card">
                <div class="row">

                    <div class="form-group col-md-3">
                        <?= $this->Form->control('installment_min', ['class' => 'form-control input-price', 'label' => 'Valor minínimo da parcela', 'value' => $payment->installment_min]) ?>
                    </div>

                    <div class="form-group col-md-3">
                        <?= $this->Form->control('installment_free', ['class' => 'form-control', 'label' => 'Parcelas sem juros', 'type' => 'number', 'value' => $payment->installment_free]) ?>
                    </div>

                    <div class="form-group col-md-3">
                        <?= $this->Form->control('installment', ['class' => 'form-control', 'label' => 'Parcelas com juros', 'type' => 'number', 'value' => $payment->installment]) ?>
                    </div>

                    <div class="form-group col-md-3">
                        <?= $this->Form->control('interest', ['class' => 'form-control input-price', 'label' => 'Taxa de juros', 'value' => $payment->interest]) ?>
                    </div>

                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade in" id="ticket">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('ticket_expiration_date', ['class' => 'form-control', 'label' => 'Vencimento do boleto em dias', 'value' => $payment->ticket_expiration_date, 'type' => 'number']) ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('ticket_discount', ['class' => 'form-control', 'label' => 'Desconto (%)', 'value' => $payment->ticket_discount, 'type' => 'number']) ?>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('ticket_demonstrative', ['class' => 'form-control', 'label' => 'Demonstrativo', 'value' => $payment->ticket_demonstrative, 'type' => 'textarea']) ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('ticket_instructions', ['class' => 'form-control', 'label' => 'Instruções', 'value' => $payment->ticket_instructions, 'type' => 'textarea']) ?>
                    </div>

                </div>
            </div>

        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>