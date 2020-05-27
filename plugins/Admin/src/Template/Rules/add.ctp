<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="page-title">
	<h2>Cadastrar Grupo</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<?= $this->Form->create($rule) ?>
		<div class="form-group">
			<?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('public', ['class' => 'form-control', 'options' => $public, 'label' => 'Público']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('menus._ids', ['class' => 'form-control input-select2-filters-dynamic', 'options' => $menus, 'label' => 'Menus Habilitados']) ?>
		</div>
		<?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
		<?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>