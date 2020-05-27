<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Editar Usuário</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($user) ?>
        <div class="form-group">
            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('email', ['class' => 'form-control', 'label' => 'E-mail']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('password', ['type' => 'password', 'class' => 'form-control', 'label' => 'Senha']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('rules_id', ['label' => 'Grupo', 'class' => 'form-control', 'empty' => '-- Selecione --', 'options' => $rules]) ?>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>