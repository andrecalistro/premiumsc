<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Grupo de Variações</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <p><b>Nome:</b> <?= $variationsGroup->name ?></p>
        <p><b>Data do Cadastro:</b> <?= $variationsGroup->created->format("d/m/Y") ?></p>
        <hr>
        <h3>Variações</h3>
        <p><?= $this->Html->link('<i class="fa fa-plus"></i> Adicionar variação', 'javascript:void(0)', ['class' => 'btn btn-sm btn-primary add-variation-view', 'escape' => false]) ?></p>
        <div class="table-responsive">
            <table class="table table-hover" id="list-filters">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($variationsGroup->variations as $variation): ?>
                    <tr>
                        <td>
                            <?= $variation->name ?>
                        </td>
                        <td align="right">
                            <?= $this->Html->link('<i class="fa fa-edit"></i>', ['controller' => 'filters-groups', 'action' => 'edit', $variationsGroup->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false, 'title' => 'Editar Filtro']) ?>
                            <?= $this->Html->link('<i class="fa fa-trash-o"></i>', 'javascript:void(0)', ['class' => 'btn btn-sm btn-danger remove-variation-item', 'escape' => false, 'title' => 'Excluir Variação', 'data-variation-id' => $variation->id]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <p><?= $this->Html->link("<i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i> Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?></p>
    </div>
</div>