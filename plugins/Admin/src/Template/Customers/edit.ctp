<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Customer $customer
 */
$this->Html->script('Admin.customers.functions', ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="page-title">
    <h2>Editar Cliente</h2>
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
                    <?= $this->Form->control('birth_date', ['class' => 'form-control input-date', 'label' => 'Data de nascimento', 'type' => 'text', 'value' => $customer->birth_date_format]) ?>
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
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", $referer, ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>


        <h3>Endereços</h3>
        <hr>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <p><?= $this->Html->link('Adicionar Endereço', ['controller' => 'customers-addresses', 'action' => 'add', 'plugin' => 'admin', $customer->id], ['class' => 'btn btn-primary btn-sm']) ?></p>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>CEP</th>
                        <th>Logradouro</th>
                        <th>Número / Complemento</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($customer->customers_addresses): ?>
                        <?php foreach ($customer->customers_addresses as $customers_address): ?>
                            <tr>
                                <td><?= $customers_address->zipcode ?></td>
                                <td><?= $customers_address->address ?></td>
                                <td><?= $customers_address->number ?> / <?= $customers_address->complement ?></td>
                                <td><?= $customers_address->neighborhood ?></td>
                                <td><?= $customers_address->city ?></td>
                                <td><?= $customers_address->state ?></td>
                                <td><?= $customers_address->description ?></td>
                                <td>
                                    <a class="btn btn-primary btn-sm"
                                       href="<?= $this->Url->build(['controller' => 'customers-addresses', 'action' => 'edit', $customers_address->id, $customer->id, 'plugin' => 'admin']) ?>"
                                       title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'customers-addresses', 'action' => 'delete', $customers_address->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>