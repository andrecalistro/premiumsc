<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Customer $customer
 */
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Clientes</h2>
        </div>

        <div class="navbarRightBtns">
            <a class="btn btn-primary btn-sm navbarBtn"
               href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'add']) ?>">Adicionar
                Cliente</a>
        </div>
    </div>
<?= $this->element('pagination') ?>
    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Customers.name', 'Cliente') ?></th>
                    <th><?= $this->Paginator->sort('Customers.document', 'CPF') ?></th>
                    <?php if ($company_register): ?>
                        <th><?= $this->Paginator->sort('Customers.company_document', 'CNPJ') ?></th>
                    <?php endif; ?>
                    <th><?= $this->Paginator->sort('Customers.email', 'E-mail') ?></th>
                    <th>Vendas</th>
                    <th>Total em Vendas</th>
                    <th><?= $this->Paginator->sort('Customers.created', 'Cadastrado em') ?></th>
                    <th></th>
                </tr>
                <tr>
                    <?= $this->Form->create('filter', ['autocomplete' => 'off', 'type' => 'get']) ?>
                    <th><?= $this->Form->control('name', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Nome', 'value' => $filter['name']]) ?></th>
                    <th><?= $this->Form->control('document', ['class' => 'form-control input-cpf', 'label' => false, 'placeholder' => 'CPF', 'value' => $filter['document']]) ?></th>
                    <?php if ($company_register): ?>
                        <th><?= $this->Form->control('company_document', ['class' => 'form-control input-cnpj', 'label' => false, 'placeholder' => 'CNPJ', 'value' => $filter['company_document']]) ?></th>
                    <?php endif; ?>
                    <th><?= $this->Form->control('email', ['class' => 'form-control', 'label' => false, 'placeholder' => 'E-mail', 'value' => $filter['email']]) ?></th>
                    <th></th>
                    <th></th>
                    <th><?= $this->Form->control('created', ['class' => 'form-control input-date', 'label' => false, 'placeholder' => 'Cadastrado em: xx/xx/xxxx', 'value' => $filter['created']]) ?></th>
                    <th>
                        <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary btn-sm', 'title' => 'Buscar']) ?>
                        <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'customers', 'action' => 'index'], ['class' => 'btn btn-default btn-sm', 'escape' => false, 'title' => 'Todos os pedidos']) ?>
                    </th>
                    <?= $this->Form->end() ?>
                </tr>
                </thead>
                <tbody>
                <?php if ($customers): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= $customer->name ?></td>
                            <td><?= $customer->document ?></td>
                            <?php if ($company_register): ?>
                                <td><?= $customer->company_document ?></td>
                            <?php endif; ?>
                            <td><?= $customer->email ?></td>
                            <td><?= $customer->count_total_orders ?></td>
                            <td><?= $customer->total_orders ?></td>
                            <td><?= $customer->created->format('d/m/Y') ?></td>
                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['action' => 'view', $customer->id, 'plugin' => 'admin']) ?>"
                                   title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-primary btn-sm"
                                   href="<?= $this->Url->build(['action' => 'edit', $customer->id, 'plugin' => 'admin']) ?>"
                                   title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $customer->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>