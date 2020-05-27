<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Página estática</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <p><b>Título:</b> <?= $page->name ?></p>
        <p><b>Status:</b> <?= $page->status_name ?></p>
        <p><b>Data do Cadastro:</b> <?= $page->created->format("d/m/Y") ?></p>
        <p>
            <b>Conteúdo:</b><br>
            <?= $page->content ?>
        </p>

        <p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
    </div>
</div>