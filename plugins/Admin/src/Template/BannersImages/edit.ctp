<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Editar Banner</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($bannersImage, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 btn-file">
                <label>Imagem (<?= $banner->dimensions['image'] ?>)</label>
                <p class="icon-upload-file <?= !empty($bannersImage->image) ? 'hidden-element' : '' ?>">
                    <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                </p>
                <?= $this->Form->control('image', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false, 'disabled' => !empty($bannersImage->image) ? true : false]) ?>
                <?= $this->Form->control('image', ['class' => 'input-text-file', 'type' => 'hidden', 'label' => false, 'div' => false, 'value' => $bannersImage->image, 'disabled' => empty($bannersImage->image) ? true : false]) ?>
                <?= $this->Html->image(!empty($bannersImage->image) ? $bannersImage->thumb_image_link : 'Admin.icon-upload.png', ['class' => empty($bannersImage->image) ? 'hidden-element img-thumbnail img-upload' : 'img-thumbnail img-upload']) ?>
                <p class="btn-del-file <?= empty($bannersImage->image) ? 'hidden-element' : '' ?>">
                    <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger btn-sm']) ?>
                </p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 btn-file">
                <label>Imagem para Mobile (<?= $banner->dimensions['image_mobile'] ?>)</label>
                <p class="icon-upload-file <?= !empty($bannersImage->image_mobile) ? 'hidden-element' : '' ?>">
                    <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                </p>
                <?= $this->Form->control('image_mobile', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false, 'disabled' => !empty($bannersImage->image_mobile) ? true : false]) ?>
                <?= $this->Form->control('image_mobile', ['class' => 'input-text-file', 'type' => 'hidden', 'label' => false, 'div' => false, 'value' => $bannersImage->image_mobile, 'disabled' => empty($bannersImage->image_mobile) ? true : false]) ?>
                <?= $this->Html->image(!empty($bannersImage->image_mobile) ? $bannersImage->thumb_image_mobile_link : 'Admin.icon-upload.png', ['class' => empty($bannersImage->image_mobile) ? 'hidden-element img-thumbnail img-upload' : 'img-thumbnail img-upload']) ?>
                <p class="btn-del-file <?= empty($bannersImage->image_mobile) ? 'hidden-element' : '' ?>">
                    <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger btn-sm']) ?>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group">
                <?= $this->Form->control('title', ['label' => 'Título', 'class' => 'form-control']) ?>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group">
                <?= $this->Form->control('url', ['label' => 'URL/Link', 'class' => 'form-control']) ?>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group">
                <?= $this->Form->control('target', ['label' => 'Abrir em', 'class' => 'form-control', 'options' => $targets, 'type' => 'select']) ?>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group">
                <?= $this->Form->control('status', ['label' => 'Status', 'class' => 'form-control', 'options' => $statuses, 'type' => 'select']) ?>
            </div>
        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'banners', 'action' => 'view', $bannersImage->banners_id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
