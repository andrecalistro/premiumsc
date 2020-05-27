<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Modulo Grupos de Descontos</h2>
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
        </div>

        <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['class' => 'btn btn-success btn-sm', 'escape' => false, 'type' => 'submit']) ?>
        <?= $this->Html->link('<i class="fa fa-arrow-circle-left"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>