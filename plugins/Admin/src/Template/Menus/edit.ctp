<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="page-title">
	<h2>Editar Menu</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<?= $this->Form->create($menu) ?>
		<div class="form-group">
			<?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('icon', ['class' => 'form-control', 'label' => 'Ícone']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('parent_id', ['class' => 'form-control', 'options' => $parentMenus, 'empty' => 'Nenhum', 'label' => 'Menu Pai']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('plugin', ['class' => 'form-control', 'label' => 'Plugin']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('controller', ['class' => 'form-control', 'label' => 'Controller']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('action', ['class' => 'form-control', 'label' => 'Action']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('params', ['class' => 'form-control', 'label' => 'Parâmetros']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('status', ['class' => 'form-control', 'options' => $statuses, 'label' => 'Status']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('position', ['class' => 'form-control', 'label' => 'Ordem']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('rules._ids', ['class' => 'form-control input-select2-filters-dynamic', 'options' => $rules, 'label' => 'Grupos']) ?>
		</div>
		<?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
		<?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>

