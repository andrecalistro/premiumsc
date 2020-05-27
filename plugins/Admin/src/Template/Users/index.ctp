<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Usuários</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid">
        <p><a class="btn btn-primary btn-sm"
              href="<?= $this->Url->build(['controller' => 'users', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar
                Usuário</a></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Grupo</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($users): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->name ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->rule->name ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['controller' => 'users', 'action' => 'view', $user->id]) ?>" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['controller' => 'users', 'action' => 'edit', $user->id]) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'users', 'action' => 'delete', $user->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('pagination') ?>