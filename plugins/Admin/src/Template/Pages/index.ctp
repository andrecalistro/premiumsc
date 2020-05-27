<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Páginas estáticas</h2>
</div>
<div class="content">
    <div class="container-fluid">
        <p><a class="btn btn-primary btn-sm"
              href="<?= $this->Url->build(['controller' => 'pages', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar</a></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Status</th>
                <th>Cadastrado em</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($pages): ?>
                <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><?= $page->id ?></td>
                        <td><?= $page->name ?></td>
                        <td><?= $page->status_name ?></td>
                        <td><?= $page->created->format('d/m/Y') ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['controller' => 'pages', 'action' => 'view', $page->id, 'plugin' => 'admin']) ?>" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['controller' => 'pages', 'action' => 'edit', $page->id, 'plugin' => 'admin']) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'pages', 'action' => 'delete', $page->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('pagination') ?>