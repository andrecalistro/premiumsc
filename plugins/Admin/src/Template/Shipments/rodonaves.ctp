<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Rodonaves</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($rodonaves, ['id' => 'form-interval']) ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $rodonaves->status]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('zipcode', ['class' => 'form-control input-zipcode', 'label' => 'CEP de origem', 'value' => $rodonaves->zipcode]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('additional_days', ['class' => 'form-control', 'label' => 'Prazo de entrega', 'value' => $rodonaves->additional_days, 'placeholder' => 'Ex: 15 dias úteis']) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('user', ['class' => 'form-control', 'label' => 'Usuário Webservice', 'value' => $rodonaves->user]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('password', ['type' => 'text', 'class' => 'form-control', 'label' => 'Senha Webservice', 'value' => $rodonaves->password]) ?>
                </div>
            </div>
        </div>
        <hr>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
