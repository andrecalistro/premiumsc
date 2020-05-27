<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Alterar senha</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($user) ?>
        <div class="form-group">
            <?= $this->Form->control('password', ['class' => 'form-control', 'label' => 'Senha nova']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('password_confirm', ['class' => 'form-control', 'label' => 'Repita senha nova', 'type' => 'password']) ?>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'stores', 'action' => 'dashboard'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>