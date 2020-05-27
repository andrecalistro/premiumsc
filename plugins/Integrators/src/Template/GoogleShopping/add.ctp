<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Cadastrar Feed do Google Shopping</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create() ?>
        <div class="form-group">
            <?= $this->Form->control('categories', ['class' => 'form-control input-select2', 'options' => $categories, 'label' => 'Categorias', 'multiple' => true, 'required' => true]) ?>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
