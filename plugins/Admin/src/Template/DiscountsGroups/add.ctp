<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Cadastrar Grupo de Descontos</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($discountsGroups) ?>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Título']) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('description', ['class' => 'form-control', 'label' => 'Descrição']) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('type', ['class' => 'form-control', 'options' => $discounts_type, 'label' => 'Tipo de desconto', 'empty' => 'Selecione']) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('free_shipping', ['class' => 'form-control', 'options' => $free_shipping, 'label' => 'Frete Grátis', 'empty' => 'Selecione']) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('discount', ['class' => 'form-control input-price', 'label' => 'Valor do desconto', 'type' => 'text']) ?>
                </div>
            </div>
        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
