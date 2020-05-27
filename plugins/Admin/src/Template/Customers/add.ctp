<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script('Admin.customers.functions', ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="page-title">
    <h2>Cadastrar Cliente</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($customer) ?>
        <?php if ($company_register): ?>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label><h3>Tipo de conta</h3></label>
                    <?= $this->Form->control('customers_types_id', [
                        'type' => 'radio',
                        'options' => $customersTypes,
                        'label' => false,
                        'required' => true,
                        'hiddenField' => false,
                        'class' => 'input-type-customer',
                        'labelOptions' => [
                            'style' => 'margin-right: 10px;',
                        ]
                    ]) ?>
                </div>
            </div>
            <?= $this->element('Admin.Customers/form-block-person') ?>
            <?= $this->element('Admin.Customers/form-block-company') ?>
        <?php else: ?>
            <?= $this->element('Admin.Customers/form-block-person') ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('password', ['class' => 'form-control', 'label' => 'Senha']) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('birth_date', ['class' => 'form-control input-date', 'label' => 'Data de nascimento', 'type' => 'text']) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('cellphone', ['class' => 'form-control input-phone', 'label' => 'Celular']) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status', ['class' => 'form-control', 'label' => 'Status', 'empty' => '-- Selecione --', 'options' => $statuses]) ?>
                </div>
            </div>
        </div>

        <h3>Endereço</h3>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('customers_addresses.0.zipcode', ['label' => 'CEP', 'class' => 'form-control input-cep', 'maxlength' => 9]) ?>
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <?= $this->Form->control('customers_addresses.0.address', ['label' => 'Logradouro', 'class' => 'form-control input-address']) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <?= $this->Form->control('customers_addresses.0.number', ['label' => 'Número', 'class' => 'form-control input-number']) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <?= $this->Form->control('customers_addresses.0.complement', ['label' => 'Complemento', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('customers_addresses.0.neighborhood', ['label' => 'Bairro', 'class' => 'form-control input-neighborhood']) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('customers_addresses.0.city', ['label' => 'Cidade', 'class' => 'form-control input-city']) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('customers_addresses.0.state', ['label' => 'Estado', 'class' => 'form-control input-state']) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('customers_addresses.0.description', ['label' => 'Descrição', 'placeholder' => 'Ex: casa, trabalho', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", $referer, ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>