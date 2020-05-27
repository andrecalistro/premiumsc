<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Modulo Lista de Desejos</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($entity, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $entity->status]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Qtde. de dias para cancelar automaticamente a lista</label>
                    <?= $this->Form->control('expiration_days', ['class' => 'form-control', 'label' => false, 'value' => $entity->expiration_days]) ?>
                </div>
            </div>
        </div>

        <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['class' => 'btn btn-success btn-sm', 'escape' => false, 'type' => 'submit']) ?>
        <?= $this->Html->link('<i class="fa fa-arrow-circle-left"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>