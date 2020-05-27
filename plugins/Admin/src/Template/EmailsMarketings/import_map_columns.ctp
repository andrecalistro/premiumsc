<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Mapear colunas para importar os emails</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create('', ['class' => 'form-horizontal']) ?>

        <?php foreach ($columns as $key => $column): ?>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?= trim($column) ?></label>
                <div class="col-sm-10">
                    <?= $this->Form->control('map.' . $key, ['class' => 'form-control', 'options' => $fields, 'label' => false]) ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="row">
            <div class="col-md-6 col-xs-12"><?= $this->Html->link("<i class='fa fa-arrow-left'></i> Voltar",
					['controller' => 'emails-marketings', 'action' => 'import'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?></div>
            <div class="col-md-6 col-xs-12"><?= $this->Form->button("<i class='fa fa-floppy-o'></i> Atualizar", ['type' => 'submit', 'class' => 'btn btn-success btn-sm pull-right', 'escape' => false]) ?></div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>