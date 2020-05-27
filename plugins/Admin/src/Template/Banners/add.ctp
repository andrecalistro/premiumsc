<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script('Admin.banners.functions.js', ['block' => 'scriptBottom']);
?>
<div class="page-title">
    <h2>Cadastrar Banner</h2>
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

<div class="modal modal-static fade" id="modal-form-banner" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->create('') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 btn-file">
                        <label>Imagem</label>
                        <p class="icon-upload-file">
                            <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                        </p>
                        <?= $this->Form->control('image', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false]) ?>
                        <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'hidden-element img-thumbnail img-upload', 'id' => 'img-preview-image']) ?>
                        <p class="btn-del-file <?= empty($store->logo) ? 'hidden-element' : '' ?>">
                            <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger btn-sm']) ?>
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 btn-file">
                        <label>Background</label>
                        <p class="icon-upload-file">
                            <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                        </p>
                        <?= $this->Form->control('background', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false]) ?>
                        <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'hidden-element img-thumbnail img-upload', 'id' => 'img-preview-background']) ?>
                        <p class="btn-del-file <?= empty($store->logo) ? 'hidden-element' : '' ?>">
                            <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger btn-sm']) ?>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <?= $this->Form->control('url', ['label' => 'URL/Link', 'class' => 'form-control']) ?>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <?= $this->Form->control('target', ['label' => 'Abrir em', 'class' => 'form-control', 'options' => $targets, 'type' => 'select']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <?= $this->Form->control('status', ['label' => 'Status', 'class' => 'form-control', 'options' => $statuses, 'type' => 'select']) ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <label>&nbsp;</label><br>
                        <label><?= $this->Form->control('always', ['label' => false, 'type' => 'checkbox']) ?>
                            Sempre exibir esse banner</label>
                    </div>
                </div>

                <div class="row">
                    <label class="center-block" style="padding-left: 15px;">Periodo</label>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <?= $this->Form->control('start_date', ['label' => false, 'class' => 'form-control input-date', 'placeholder' => 'Data inicial']) ?>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
                        <?= $this->Form->control('end_date', ['label' => false, 'class' => 'form-control input-date', 'placeholder' => 'Data final']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label>Dias da semana</label>
                        <div class="row">
                            <div class="col-md-4">
                                <?= $this->Form->control('sunday', ['label' => 'Domingo', 'type' => 'checkbox', 'hiddenField' => false]) ?>
                                <?= $this->Form->control('monday', ['label' => 'Segunda', 'type' => 'checkbox', 'hiddenField' => false]) ?>
                                <?= $this->Form->control('tuesday', ['label' => 'Terça', 'type' => 'checkbox', 'hiddenField' => false]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->Form->control('wednesday', ['label' => 'Quarta', 'type' => 'checkbox', 'hiddenField' => false]) ?>
                                <?= $this->Form->control('thursday', ['label' => 'Quinta', 'type' => 'checkbox', 'hiddenField' => false]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->Form->control('friday', ['label' => 'Sexta', 'type' => 'checkbox', 'hiddenField' => false]) ?>
                                <?= $this->Form->control('saturday', ['label' => 'Sábado', 'type' => 'checkbox', 'hiddenField' => false]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= $this->Form->submit('Salvar', ['class' => 'btn btn-sm btn-primary']) ?>
                <?= $this->Html->link('Fechar', 'javascript:void(0)', ['class' => 'btn btn-sm btn-default', 'data-dismiss' => 'modal']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>