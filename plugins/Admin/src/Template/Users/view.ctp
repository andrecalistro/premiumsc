<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Usuário</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid mar-bottom-20">
        <p><b>Nome:</b> <?= $user->name ?></p>
        <p><b>E-mail:</b> <?= $user->email ?></p>
        <p><b>Grupo:</b> <?= $user->rule->name ?></p>
        <p><b>Data do Cadastro:</b> <?= $user->created->format("d/m/Y") ?></p>

        <p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
    </div>
</div>
