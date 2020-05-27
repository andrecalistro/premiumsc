<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Depósito Bancário</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($deposit, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $deposit->status]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-xs-12">
                <div class="form-group">
                    <?= $this->Form->control('instructions', ['class' => 'form-control', 'label' => ['text' => 'Instruções de pagamento (informe o banco, agencia e conta e para onde deve ser enviado o comprovante de pagamento)', 'escape' => false], 'value' => $deposit->instructions, 'type' => 'textarea']) ?>
                </div>
            </div>
        </div>

        <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['class' => 'btn btn-success btn-sm', 'escape' => false, 'type' => 'submit']) ?>
        <?= $this->Html->link('<i class="fa fa-arrow-circle-left"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>