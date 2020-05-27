<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Editar depoimento</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($testimonial, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 form-group">
                <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
            </div>

            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 form-group">
                <?= $this->Form->control('company', ['class' => 'form-control', 'label' => 'Empresa']) ?>
            </div>

            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 form-group btn-file">
                <label>Avatar</label>
                <p class="icon-upload-file <?= !empty($testimonial->avatar) ? 'hidden-element' : '' ?>">
                    <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                </p>
                <?= $this->Form->control('avatar', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false, 'disabled' => !empty($testimonial->avatar) ? true : false]) ?>
                <?= $this->Form->control('avatar', ['class' => 'input-text-file', 'type' => 'hidden', 'label' => false, 'div' => false, 'value' => $testimonial->avatar, 'disabled' => empty($store->logo) ? true : false]) ?>
                <?= $this->Html->image(!empty($testimonial->avatar) ? $testimonial->thumb_avatar_link : 'Admin.icon-upload.png', ['class' => empty($testimonial->avatar) ? 'hidden-element img-thumbnail img-upload' : 'img-thumbnail img-upload']) ?>
                <p class="btn-del-file <?= empty($testimonial->avatar) ? 'hidden-element' : '' ?>">
                    <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger btn-sm']) ?>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 form-group">
                <?= $this->Form->control('message', ['class' => 'form-control input-editor', 'label' => 'Depoimento', 'type' => 'textarea']) ?>
            </div>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'testimonials'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
