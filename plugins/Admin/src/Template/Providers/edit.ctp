<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Editar Fornecedor</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($provider, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-3 form-group">
                <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
            </div>
            <div class="col-md-3 form-group">
                <?= $this->Form->control('commission', ['class' => 'form-control', 'label' => 'Porcentagem do Fornecedor']) ?>
            </div>
            <div class="col-md-3 form-group">
                <label>Status</label><br>
                <?= $this->Form->radio('status', $statuses, ['hiddenField' => false, 'label' => 'Status']) ?>
            </div>
            <div class="col-md-3 form-group btn-file">
                <label>Imagem</label>
                <p class="icon-upload-file <?= !empty($provider->image) ? 'hidden-element' : '' ?>">
                    <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                </p>
                <?= $this->Form->control('image', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false, 'disabled' => !empty($provider->image) ? true : false]) ?>
                <?= $this->Form->control('image', ['class' => 'input-text-file', 'type' => 'hidden', 'label' => false, 'div' => false, 'value' => $provider->image, 'disabled' => empty($provider->image_background) ? true : false]) ?>
                <?= $this->Html->image(!empty($provider->image) ? $provider->thumb_image_link : 'Admin.icon-upload.png', ['class' => empty($provider->image) ? 'hidden-element img-thumbnail img-upload' : 'img-thumbnail img-upload']) ?>
                <p class="btn-del-file <?= empty($provider->image) ? 'hidden-element' : '' ?>">
                    <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger btn-sm']) ?>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <?= $this->Form->control('email', ['class' => 'form-control', 'label' => 'E-mail']) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('telephone', ['class' => 'form-control input-phone', 'label' => 'Telefone']) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('document', ['class' => 'form-control', 'label' => 'CPF ou CNPJ']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <?= $this->Form->control('bank', ['class' => 'form-control', 'label' => 'Banco']) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('agency', ['class' => 'form-control', 'label' => 'Número da agência']) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('account', ['class' => 'form-control', 'label' => 'Número da conta corrente']) ?>
            </div>
        </div>

        <h3>Endereço</h3>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('zipcode', ['label' => 'CEP', 'class' => 'form-control input-cep input-zipcode', 'maxlength' => 9]) ?>
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <?= $this->Form->control('address', ['label' => 'Logradouro', 'class' => 'form-control input-address']) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <?= $this->Form->control('number', ['label' => 'Número', 'class' => 'form-control input-number']) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <?= $this->Form->control('complement', ['label' => 'Complemento', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('neighborhood', ['label' => 'Bairro', 'class' => 'form-control input-neighborhood']) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('city', ['label' => 'Cidade', 'class' => 'form-control input-city']) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('state', ['label' => 'Estado', 'class' => 'form-control input-state']) ?>
                </div>
            </div>
        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'providers'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
