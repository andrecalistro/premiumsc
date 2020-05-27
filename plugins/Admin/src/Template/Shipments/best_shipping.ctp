<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Melhor Envio</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($bestShipping, ['id' => 'form-interval']) ?>
        <div class="row">
            <div class="col-md-3 form-group">
                <label>Ambiente</label>
                <?= $this->Form->control('environment', ['label' => false, 'empty' => '', 'options' => $environments, 'type' => 'radio', 'value' => $bestShipping->environment, 'required']) ?>
            </div>
            <div class="col-md-3 form-group">
                <label>Status</label>
                <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $bestShipping->status, 'required']) ?>
            </div>
            <div class="col-md-3 form-group">
                <?= $this->Form->control('zipcode', ['class' => 'form-control input-zipcode', 'label' => 'CEP de origem', 'value' => $bestShipping->zipcode, 'required']) ?>
            </div>
            <div class="col-md-3 form-group">
                <?= $this->Form->control('additional_days',
                    ['type' => 'number', 'class' => 'form-control', 'label' => 'Prazo adicional de entrega (em dias)', 'value' => $bestShipping->additional_days, 'placeholder' => 'Ex: 3']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 form-group">
                <?= $this->Form->control('token', ['type' => 'textarea', 'class' => 'form-control', 'label' => 'Token', 'value' => $bestShipping->token, 'required']) ?>
            </div>
        </div>
        <hr>
        <h4>Metodos de envio</h4>
        <?php if (!$bestShipping->token): ?>
            <p>Configure o modulo para consultar os metodos de envios disponiveis pelo Melhor Envio</p>
        <?php else: ?>
            <?php foreach ($servicesList as $service): ?>
                <?= $this->Form->control('services[]', [
                    'hiddenField' => false,
                    'label' => $service->company->name . ' ' . $service->name,
                    'value' => $service->id,
                    'type' => 'checkbox',
                    'templates' => [
                        'label' => '<label>{{text}}</label>',
                        'nestingLabel' => '{{hidden}}<label>{{input}}{{text}}</label>',
                    ]
                ]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <hr>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
