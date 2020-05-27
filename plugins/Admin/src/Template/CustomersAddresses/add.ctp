<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Cadastrar Endereço</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($customersAddress) ?>
        <?= $this->Form->control('customers_id', ['type' => 'hidden', 'value' => $customer->id]) ?>
        <p><strong>Cliente:</strong> <?= $customer->name ?></p>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('zipcode', ['label' => 'CEP', 'class' => 'form-control input-cep', 'maxlength' => 9]) ?>
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
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('neighborhood', ['label' => 'Bairro', 'class' => 'form-control input-neighborhood']) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('city', ['label' => 'Cidade', 'class' => 'form-control input-city']) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('state', ['label' => 'Estado', 'class' => 'form-control input-state']) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('description', ['label' => 'Descrição', 'placeholder' => 'Ex: casa, trabalho', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'customers', 'action' => 'edit', $customer->id, 'plugin' => 'admin'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
