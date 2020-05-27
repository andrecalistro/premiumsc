<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Depoimento</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= !empty($testimonial->thumb_avatar_link) ? "<p>" . $this->Html->image($testimonial->thumb_avatar_link, ['class' => 'thumbnail']) . "</p>" : '' ?>
        <p><b>Nome:</b> <?= $testimonial->nome ?></p>
        <p><b>Empresa:</b> <?= $testimonial->company ?></p>
        <p><b>Data do Cadastro:</b> <?= $testimonial->created->format("d/m/Y") ?></p>
        <p>
            <b>Depoimento:</b><br>
            <?= nl2br($testimonial->message) ?>
        </p>

        <p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
    </div>
</div>