<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['shipments/correios.functions.js'], ['fullBase' => true, 'block' => 'scriptBottom']);
?>
<div class="page-title">
    <h2>Configurar Entrega Correios</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($correios, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('zipcode_origin', ['class' => 'form-control', 'label' => 'Cep de Origem', 'value' => $correios->zipcode_origin]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('additional_days', ['class' => 'form-control', 'label' => 'Prazo de entrega adicional (em dias)', 'value' => $correios->additional_days]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => 'Status', 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $correios->status, 'label' => false]) ?>
                </div>
            </div>
        </div>

        <h4>Contrato com Correios</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('contract_code', ['class' => 'form-control', 'label' => 'Código', 'value' => $correios->contract_code]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('contract_password', ['class' => 'form-control', 'label' => 'Senha', 'value' => $correios->contract_password]) ?>
                </div>
            </div>
        </div>

        <h4>Serviços</h4>
        <div class="row">
            <div class="col-md-6">
                <?php $count = 1;
                foreach ($services as $key => $service): ?>
                    <?= $this->Form->control($key, ['type' => 'checkbox', 'label' => $service, 'hiddenField' => false, 'default' => $correios->$key]) ?>
                    <?= $count % 11 == 0 ? "</div><div class=\"col-md-6\">" : ''; ?>
                    <?php $count++; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>