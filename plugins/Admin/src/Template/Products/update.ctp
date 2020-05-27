<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Atualizar produtos</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create('', ['type' => 'file']) ?>
        <?php /*
        <div class="form-group">
            <label>Atualizar quantidade em estoque</label><br>
            <?= $this->Form->radio('update_stock', [0 => 'Não', 1 => 'Sim'], ['hiddenField' => false, 'label' => 'Status', 'required']) ?>
        </div>
        <div class="form-group">
            <label>Atualizar preço normal</label><br>
            <?= $this->Form->radio('update_price', [0 => 'Não', 1 => 'Sim'], ['hiddenField' => false, 'label' => 'Status', 'required']) ?>
        </div>
 */ ?>
        <div class="form-group">
            <?= $this->Form->control('file', ['type' => 'file', 'class' => 'form-control', 'label' => 'Arquivo CSV', 'required']) ?>
        </div>

        <?= $this->Form->submit('Enviar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'payments-methods'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>