<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Status de Pedido</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <p><b>Nome:</b> <?= $productsStatus->name ?></p>
        <p><b>Esse status permite a compra do produto?</b> <?= $productsStatus->purchase_name ?></p>
        <p><b>Esse status permite a visualização do produto?</b> <?= $productsStatus->view_name ?></p>
        <p><b>Data do Cadastro:</b> <?= $productsStatus->created->format("d/m/Y") ?></p>

        <p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
    </div>
</div>
