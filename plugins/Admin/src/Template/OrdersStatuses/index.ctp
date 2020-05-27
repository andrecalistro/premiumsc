<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css(['Admin.bootstrap-colorpicker.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->script(['Admin.catalog/product.functions.js', 'Admin.bootstrap-colorpicker.min.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
$this->Html->scriptBlock('
$(function() {
    $(\'.input-colorpicker\').colorpicker();
});
', ['block' => 'scriptBottom']);
?>
<div class="navbarBtns">
    <div class="page-title">
        <h2>Status do Pedido</h2>
    </div>
</div>
<div class="content">
    <?= $this->Form->create() ?>
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Cor de fundo</th>
                <th>Cor do texto</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($ordersStatuses): ?>
                <?php foreach ($ordersStatuses as $ordersStatus): ?>
                    <tr>
                        <td>
                            <?= $ordersStatus->id ?>
                            <?= $this->Form->hidden('orders_statuses.' . $ordersStatus->id . '.id', ['value' => $ordersStatus->id]) ?>
                        </td>
                        <td><?= $ordersStatus->name ?></td>
                        <td>
                            <div class="input-group colorpicker-component input-colorpicker">
                                <input type="text" value="<?= $ordersStatus->background_color ?>" class="form-control" name="orders_statuses[<?= $ordersStatus->id ?>][background_color]" />
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </td>
                        <td>
                            <div class="input-group colorpicker-component input-colorpicker">
                                <input type="text" value="<?= $ordersStatus->font_color ?>" class="form-control" name="orders_statuses[<?= $ordersStatus->id ?>][font_color]" />
                                <span class="input-group-addon"><i></i></span>
                            </div>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <hr>
    <div class="container-fluid pad-bottom-20">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>