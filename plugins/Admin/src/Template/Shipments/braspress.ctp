<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar Braspress</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($braspress, ['id' => 'form-interval']) ?>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Status</label>
						<?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $braspress->status]) ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<?= $this->Form->control('cnpj', ['class' => 'form-control input-cnpj', 'label' => 'CNPJ', 'value' => $braspress->cnpj]) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<?= $this->Form->control('zipcode', ['class' => 'form-control input-zipcode', 'label' => 'CEP de origem', 'value' => $braspress->zipcode]) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<?= $this->Form->control('additional_days',
							['type' => 'number', 'class' => 'form-control', 'label' => 'Prazo adicional de entrega (em dias)', 'value' => $braspress->additional_days, 'placeholder' => 'Ex: 3']) ?>
					</div>
				</div>
			</div>
			<hr>

			<?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
			<?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
