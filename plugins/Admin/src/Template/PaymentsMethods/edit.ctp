<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Editar Metodo de Pagamento</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($paymentsMethod, ['type' => 'file']) ?>
        <div class="form-group">
            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('slug', ['class' => 'form-control', 'label' => 'Apelido']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('image', ['type' => 'file', 'class' => 'form-control', 'label' => 'Imagem']) ?>
            <?php if ($paymentsMethod->thumb_image_link): ?>
                <?= $this->Html->image($paymentsMethod->thumb_image_link, ['class' => 'thumbnail', 'width' => 50]) ?>
            <?php endif; ?>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'payments-methods'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>