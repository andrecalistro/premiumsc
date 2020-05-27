<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Cadastrar Status do Produto</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($productsStatus) ?>
        <div class="form-group">
            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->control('purchase', ['label' => 'Esse status permite a compra do produto', 'type' => 'checkbox', 'value' => 1]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->control('view', ['label' => 'Esse status permite a visualização do produto', 'type' => 'checkbox', 'value' => 1]) ?>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>