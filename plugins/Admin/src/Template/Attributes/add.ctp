<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Novo atributo</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($attribute) ?>
        <div class="row">
            <div class="col-md-6 col-xs-2 form-group">
                <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
            </div>

            <div class="col-md-6 col-xs-2 form-group">
                <?= $this->Form->control('type', ['class' => 'form-control', 'label' => 'Tipo de atributo', 'options' => $types]) ?>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <?= $this->Html->link("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Cancelar", ['controller' => 'attributes', 'plugin' => 'admin'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
            </div>
            <div class="col-md-6 col-xs-12 text-right">
                <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
