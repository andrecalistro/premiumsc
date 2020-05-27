<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="navbarBtns">
    <div class="page-title">
        <h2>Grupos de variações do produto</h2>
    </div>

    <div class="navbarRightBtns">
        <a class="btn btn-primary btn-sm navbarBtn"
           href="<?= $this->Url->build(['controller' => 'variations-groups', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar Grupo</a>
    </div>
</div>
<div class="content">
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome do grupo</th>
                <th>Apelido</th>
                <th>Tipo do campo auxiliar</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($variationsGroups): ?>
                <?php foreach ($variationsGroups as $variationsGroup): ?>
                    <tr>
                        <td><?= $variationsGroup->id ?></td>
                        <td><?= $variationsGroup->name ?></td>
                        <td><?= $variationsGroup->slug ?></td>
                        <td><?= $variationsGroup->auxiliary_field_type_formatted ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['controller' => 'variations-groups', 'action' => 'view', $variationsGroup->id]) ?>" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['controller' => 'variations-groups', 'action' => 'edit', $variationsGroup->id]) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'variations-groups', 'action' => 'delete', $variationsGroup->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>