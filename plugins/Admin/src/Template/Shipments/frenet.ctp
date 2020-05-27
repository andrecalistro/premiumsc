<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Frenet</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($frenet, ['id' => 'form-interval']) ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $frenet->status, 'required']) ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('zipcode', ['class' => 'form-control input-zipcode', 'label' => 'CEP de origem', 'value' => $frenet->zipcode, 'required']) ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('additional_days',
                        ['type' => 'number', 'class' => 'form-control', 'label' => 'Prazo adicional de entrega (em dias)', 'value' => $frenet->additional_days, 'placeholder' => 'Ex: 3']) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <?= $this->Form->control('token', ['class' => 'form-control', 'label' => 'Token Frenet', 'value' => $frenet->token, 'required']) ?>
            </div>
            <div class="col-md-4 form-group">
                <?= $this->Form->control('key', ['class' => 'form-control', 'label' => 'Chave Frenet', 'value' => $frenet->key, 'required']) ?>
            </div>
            <div class="col-md-4 form-group">
                <?= $this->Form->control('password', ['class' => 'form-control', 'type' => 'text', 'label' => 'Senha Frenet', 'value' => $frenet->password, 'required']) ?>
            </div>
        </div>
        <hr>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
