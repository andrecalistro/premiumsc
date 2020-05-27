<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['variations/variations.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="page-title">
    <h2>Editar Grupo de Variações</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($variationsGroup, ['id' => 'variations-groups-form']) ?>
        <div class="row">
            <div class="col-md-4 form-group">
                <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome do Grupo']) ?>
            </div>
            <div class="col-md-4 form-group">
                <?= $this->Form->control('auxiliary_field_type', ['options' => $auxiliary_field_types, 'class' => 'form-control', 'label' => 'Tipo do campo auxiliar:']) ?>
            </div>
        </div>
        <hr>
        <h3>Variações</h3>
        <div class="table-responsive">
            <table class="table table-hover" id="list-variations">
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
                            <?= $this->Form->control('variations.' . $variation->id . '.id', ['type' => 'hidden', 'value' => $variation->id]) ?>
                            <?= $this->Form->control('variations.' . $variation->id . '.name', ['class' => 'form-control', 'required' => true, 'label' => false, 'value' => $variation->name]) ?>
                        </td>
                        <td align="right"><?= $this->Html->link('<i class="fa fa-trash-o"></i>', 'javascript:void(0)', ['class' => 'btn btn-sm btn-danger remove-variation-item', 'escape' => false, 'title' => 'Excluir Variação', 'data-variation-id' => $variation->id]) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', 'javascript:void(0)', ['class' => 'btn btn-sm btn-primary add-variation-item', 'escape' => false, 'title' => 'Adicionar Variação']) ?>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <?= $this->Html->link("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Cancelar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
            </div>
            <div class="col-md-6 col-xs-12 text-right">
                <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>