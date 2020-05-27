<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Status do Produto</h2>
</div>
<div class="content">
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Habilita Compra</th>
                <th>Habilita Visualização na loja</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($productsStatuses): ?>
                <?php foreach ($productsStatuses as $productsStatus): ?>
                    <tr>
                        <td><?= $productsStatus->id ?></td>
                        <td><?= $productsStatus->name ?></td>
                        <td><?= $productsStatus->purchase_name ?></td>
                        <td><?= $productsStatus->view_name ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['action' => 'view', $productsStatus->id, 'plugin' => 'admin']) ?>"
                               title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['action' => 'edit', $productsStatus->id, 'plugin' => 'admin']) ?>"
                               title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>