<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Atributo</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <p><b>Nome:</b> <?= $attribute->nome ?></p>
        <p><b>Data do Cadastro:</b> <?= $attribute->created->format("d/m/Y") ?></p>

        <p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
    </div>
</div>