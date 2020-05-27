<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Grupo</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <p><b>Nome:</b> <?= $filtersGroup->name ?></p>
        <p><b>Data do Cadastro:</b> <?= $filtersGroup->created->format("d/m/Y") ?></p>
        <hr>
        <h3>Filtros</h3>
        <p><?= $this->Html->link('<i class="fa fa-plus"></i> Adicionar filtro', ['controller' => 'filters-groups', 'action' => 'add-filter', $filtersGroup->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false]) ?></p>
        <div class="table-responsive">
            <table class="table table-hover" id="list-filters">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($filtersGroup->filters as $filter): ?>
                    <tr>
                        <td>
                            <?= $filter->name ?>
                        </td>
                        <td align="right">
                            <?= $this->Html->link('<i class="fa fa-edit"></i>', ['controller' => 'filters-groups', 'action' => 'edit-filter', $filter->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false, 'title' => 'Editar Filtro']) ?>
                            <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'filters-groups', 'action' => 'delete-filter', $filter->id], ['class' => 'btn btn-sm btn-danger', 'escape' => false, 'title' => 'Excluir Filtro', 'confirm' => 'Tem certeza que deseja excluir esse item?']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
    </div>
</div>