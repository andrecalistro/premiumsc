<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script('Admin.banners.functions.js', ['block' => 'scriptBottom']);
?>
<div class="page-title">
    <h2>Editar Banner</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($banner) ?>
        <div class="form-group">
            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Posição']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('description', ['class' => 'form-control', 'label' => 'Descrição', 'type' => 'textarea']) ?>
        </div>

        <div class="row">
            <div class="col-md-3 col-xs-12 form-group">
                <?= $this->Form->control('image_width', ['class' => 'form-control', 'label' => 'Largura da imagem']) ?>
            </div>

            <div class="col-md-3 col-xs-12 form-group">
                <?= $this->Form->control('image_height', ['class' => 'form-control', 'label' => 'Altura da imagem']) ?>
            </div>

            <div class="col-md-3 col-xs-12 form-group">
                <?= $this->Form->control('background_width', ['class' => 'form-control', 'label' => 'Largura do background']) ?>
            </div>

            <div class="col-md-3 col-xs-12 form-group">
                <?= $this->Form->control('background_height', ['class' => 'form-control', 'label' => 'Altura do background']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-xs-12 form-group">
                <?= $this->Form->control('image_mobile_width', ['class' => 'form-control', 'label' => 'Largura da imagem mobile']) ?>
            </div>

            <div class="col-md-3 col-xs-12 form-group">
                <?= $this->Form->control('image_mobile_height', ['class' => 'form-control', 'label' => 'Altura da imagem mobile']) ?>
            </div>

            <div class="col-md-3 col-xs-12 form-group">
                <?= $this->Form->control('background_mobile_width', ['class' => 'form-control', 'label' => 'Largura do background mobile']) ?>
            </div>

            <div class="col-md-3 col-xs-12 form-group">
                <?= $this->Form->control('background_mobile_height', ['class' => 'form-control', 'label' => 'Altura do background mobile']) ?>
            </div>
        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>