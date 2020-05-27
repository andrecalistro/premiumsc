<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="page-title">
	<h2>Cadastrar Item de Menu</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<?= $this->Form->create($storesMenusItem, ['type' => 'file']) ?>
		<input type="hidden" name="stores_menus_groups_id" value="<?= $stores_menus_groups_id ?>">

		<div class="form-group">
			<?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('menu_type', ['id' => 'js-change-menu-type', 'class' => 'form-control', 'options' => $menu_types, 'label' => 'Tipo de Menu', 'empty' => true]) ?>
		</div>
		<div id="js-menu-type-html">

		</div>
		<div class="form-group">
			<?= $this->Form->control('target', ['class' => 'form-control', 'options' => $targets, 'label' => 'Ação', 'empty' => true]) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('icon_class', ['class' => 'form-control', 'label' => 'Classe do Ícone']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('icon_image', ['type' => 'file', 'class' => 'form-control', 'label' => 'Imagem do Ícone']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('parent_id', ['class' => 'form-control', 'options' => $parentStoresMenusItems, 'label' => 'Menu Pai', 'empty' => true]) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('position', ['class' => 'form-control', 'label' => 'Posição']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('status', ['class' => 'form-control', 'options' => $statuses, 'label' => 'Status']) ?>
		</div>
		<?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
		<?= $this->Html->link("Voltar", ['controller' => 'stores-menus-groups', 'action' => 'view', $stores_menus_groups_id], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>