<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Modulo Desconto Primeira Compra</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($entity, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $entity->status]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Tipo de desconto</label>
                    <?= $this->Form->control('discount_type', ['class' => 'form-control', 'label' => false, 'value' => $entity->discount_type, 'options' => $types]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Desconto</label>
                    <?= $this->Form->control('discount', ['label' => false, 'class' => 'form-control input-price', 'value' => $entity->discount]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Valor minimo para ativar o desconto</label>
                    <?= $this->Form->control('min', ['label' => false, 'class' => 'form-control input-price', 'value' => $entity->min]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Valor máximo para ativar o desconto</label>
                    <?= $this->Form->control('max', ['label' => false, 'class' => 'form-control input-price', 'value' => $entity->max]) ?>
                </div>
            </div>
        </div>

        <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['class' => 'btn btn-success btn-sm', 'escape' => false, 'type' => 'submit']) ?>
        <?= $this->Html->link('<i class="fa fa-arrow-circle-left"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>