<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Editar Status de Estoque</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($stocksStatus) ?>
        <div class="form-group">
            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>