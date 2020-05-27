<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Editar Grupo de Filtro</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($filtersGroup) ?>
        <div class="form-group">
            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome do Grupo']) ?>
        </div>
        <hr>
        <h3>Filtros</h3>
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
                            <?= $this->Form->control('filters.' . $filter->id . '.id', ['type' => 'hidden', 'value' => $filter->id]) ?>
                            <?= $this->Form->control('filters.' . $filter->id . '.name', ['class' => 'form-control', 'required' => true, 'label' => false, 'value' => $filter->name]) ?>
                        </td>
                        <td align="right"><?= $this->Html->link('<i class="fa fa-trash-o"></i>', 'javascript:void(0)', ['class' => 'btn btn-sm btn-danger remove-filter-item', 'escape' => false, 'title' => 'Excluir Filtro']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', 'javascript:void(0)', ['class' => 'btn btn-sm btn-primary add-filter-item', 'escape' => false, 'title' => 'Adicionar Filtro']) ?>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>