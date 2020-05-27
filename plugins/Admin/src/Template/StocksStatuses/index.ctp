<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Status de Estoque</h2>
</div>
<div class="content">
    <div class="container-fluid">
        <p><a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['action' => 'add', 'plugin' => 'admin']) ?>">Adicionar
                Status</a></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-30">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($stocksStatuses): ?>
                <?php foreach ($stocksStatuses as $stocksStatus): ?>
                    <tr>
                        <td><?= $stocksStatus->id ?></td>
                        <td><?= $stocksStatus->name ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['action' => 'view', $stocksStatus->id, 'plugin' => 'admin']) ?>" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['action' => 'edit', $stocksStatus->id, 'plugin' => 'admin']) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $stocksStatus->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>