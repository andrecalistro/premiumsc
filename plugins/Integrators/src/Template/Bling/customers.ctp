<?php
/**
 * @var \App\View\AppView $this
 */
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Bling Clientes</h2>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid mar-bottom-20">
            <?= $this->Html->link('<i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar', ['controller' => 'bling', 'action' => 'index'], ['class' => 'btn btn-sm btn-default', 'escape' => false]) ?>
        </div>

        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Celular</th>
                    <th>Status Bling</th>
                    <th></th>
                </tr>
                <tr>
                    <?= $this->Form->create('', ['type' => 'get']) ?>
                    <th><?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nome', 'value' => $filter['name']]) ?></th>
                    <th><?= $this->Form->control('email', ['label' => false, 'class' => 'form-control', 'placeholder' => 'E-mail', 'value' => $filter['email']]) ?></th>
                    <th><?= $this->Form->control('telephone', ['label' => false, 'class' => 'form-control mask-telephone', 'placeholder' => 'Telefone', 'value' => $filter['telephone']]) ?></th>
                    <th><?= $this->Form->control('telephone', ['label' => false, 'class' => 'form-control mask-telephone', 'placeholder' => 'Celular', 'value' => $filter['cellphone']]) ?></th>
                    <th></th>
                    <th>
                        <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary', 'title' => 'Buscar']) ?>
                        <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'providers', 'action' => 'index'], ['class' => 'btn btn-default', 'escape' => false, 'title' => 'Todos os fornecedores']) ?>
                    </th>
                    <?= $this->Form->end() ?>
                </tr>
                </thead>
                <tbody>
                <?php if ($customers): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= $customer->name ?></td>
                            <td><?= $customer->email ?></td>
                            <td><?= $customer->telephone ?></td>
                            <td><?= $customer->telephone ?></td>
                            <td><?= $customer->bling_status ?></td>
                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'view', $customer->id, 'plugin' => 'admin']) ?>"
                                   title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a href="<?= $this->Url->build(['controller' => 'bling', 'action' => 'synchronize-customer', $customer->id]) ?>"
                                   class="btn btn-sm btn-success"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>