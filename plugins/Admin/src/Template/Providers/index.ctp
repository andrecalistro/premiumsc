<?php
/**
 * @var \App\View\AppView $this
 */
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Fornecedores</h2>
        </div>

        <div class="navbarRightBtns">
            <a class="btn btn-primary btn-sm navbarBtn"
               href="<?= $this->Url->build(['controller' => 'providers', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar
                Fornecedor</a>
        </div>
    </div>
    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Banco</th>
                    <th>Agência</th>
                    <th>Conta</th>
                    <th width="145"></th>
                </tr>
                <tr>
                    <?= $this->Form->create('', ['type' => 'get']) ?>
                    <th><?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nome', 'value' => $filter['name']]) ?></th>
                    <th><?= $this->Form->control('email', ['label' => false, 'class' => 'form-control', 'placeholder' => 'E-mail', 'value' => $filter['email']]) ?></th>
                    <th><?= $this->Form->control('telephone', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Telefone', 'value' => $filter['telephone']]) ?></th>
                    <th><?= $this->Form->control('bank', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Banco', 'value' => $filter['bank']]) ?></th>
                    <th><?= $this->Form->control('agency', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Agência', 'value' => $filter['agency']]) ?></th>
                    <th><?= $this->Form->control('account', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Conta', 'value' => $filter['account']]) ?></th>
                    <th>
                        <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary', 'title' => 'Buscar']) ?>
                        <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'providers', 'action' => 'index'], ['class' => 'btn btn-default', 'escape' => false, 'title' => 'Todos os fornecedores']) ?>
                    </th>
                    <?= $this->Form->end() ?>
                </tr>
                </thead>
                <tbody>
                <?php if ($providers): ?>
                    <?php foreach ($providers as $provider): ?>
                        <tr>
                            <td><?= isset($provider->thumb_image_link) ? $this->Html->image($provider->thumb_image_link, ['align' => 'left', 'width' => '55', 'class' => 'hidden-xs']) : '' ?> <?= $provider->name ?>
                            <td><?= $provider->email ?></td>
                            <td><?= $provider->telephone ?></td>
                            <td><?= $provider->bank ?></td>
                            <td><?= $provider->agency?></td>
                            <td><?= $provider->account ?></td>
                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'providers', 'action' => 'view', $provider->id, 'plugin' => 'admin']) ?>"
                                   title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-primary btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'providers', 'action' => 'edit', $provider->id, 'plugin' => 'admin']) ?>"
                                   title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'providers', 'action' => 'delete', $provider->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>