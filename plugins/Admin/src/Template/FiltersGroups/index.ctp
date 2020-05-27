<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Grupos de Filtros</h2>
</div>
<div class="content">
    <div class="container-fluid">
        <p><a class="btn btn-primary btn-sm"
              href="<?= $this->Url->build(['controller' => 'filters-groups', 'action' => 'add']) ?>">Adicionar
                grupo de filtros</a></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome do grupo</th>
                <th>Apelido</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($filtersGroups): ?>
                <?php foreach ($filtersGroups as $filtersGroup): ?>
                    <tr>
                        <td><?= $filtersGroup->id ?></td>
                        <td><?= $filtersGroup->name ?></td>
                        <td><?= $filtersGroup->slug ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['controller' => 'filters-groups', 'action' => 'view', $filtersGroup->id]) ?>" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['controller' => 'filters-groups', 'action' => 'edit', $filtersGroup->id]) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'filters-groups', 'action' => 'delete', $filtersGroup->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('pagination') ?>