<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Editar Posição</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($position, ['type' => 'file']) ?>
        <div class="form-group">
            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('positions_pages_id', ['class' => 'form-control', 'label' => 'Página', 'empty' => 'Selecione...', 'options' => $positions_pages]) ?>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'positions'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
