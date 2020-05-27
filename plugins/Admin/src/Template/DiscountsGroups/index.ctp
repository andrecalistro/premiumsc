<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Customer $customer
 */
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Grupos de descontos</h2>
        </div>

        <div class="navbarRightBtns">
            <a class="btn btn-primary btn-sm navbarBtn"
               href="<?= $this->Url->build(['controller' => 'discountsGroups', 'action' => 'add']) ?>">Adicionar</a>
        </div>
    </div>
<?= $this->element('pagination') ?>
    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('DiscountsGroups.name', 'Nome do grupo') ?></th>
                    <th>    </th>
                </tr>
                <tr>
                    <?= $this->Form->create('filter', ['autocomplete' => 'off', 'type' => 'get']) ?>
                    <th><?= $this->Form->control('name', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Nome', 'value' => $filter['name']]) ?></th>
                    <th>
                        <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary btn-sm', 'title' => 'Buscar']) ?>
                        <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'customers', 'action' => 'index'], ['class' => 'btn btn-default btn-sm', 'escape' => false, 'title' => 'Todos os grupos']) ?>
                    </th>
                    <?= $this->Form->end() ?>
                </tr>
                </thead>
                <tbody>
                <?php if ($discountsGroups): ?>
                    <?php foreach ($discountsGroups as $group): ?>
                        <tr>
                            <td><?= $group->name ?></td>

                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['action' => 'add_customer', $group->id, 'plugin' => 'admin']) ?>"
                                   title="Clientes"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                                <a class="btn btn-primary btn-sm"
                                   href="<?= $this->Url->build(['action' => 'edit', $group->id, 'plugin' => 'admin']) ?>"
                                   title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $group->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse grupo?', 'title' => 'Excluir', 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>