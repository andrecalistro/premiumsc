<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Importar emails</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create('', ['type' => 'file']) ?>
        <div class="form-group">
            <?= $this->Form->control('file', ['type' => 'file', 'class' => 'form-control', 'label' => 'Arquivo CSV', 'required']) ?>
        </div>

        <?= $this->Form->submit('Enviar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'emails-marketings'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>