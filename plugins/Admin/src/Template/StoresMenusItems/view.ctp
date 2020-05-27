<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.StoresMenusItem $storesMenusItem
  */
?>
<div class="page-title">
	<h2>Item de Menu "<?= $storesMenusItem->name ?>"</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid mar-bottom-20">
		<p><b>Nome:</b> <?= $storesMenusItem->name ?></p>
		<p><b>Slug:</b> <?= $storesMenusItem->slug ?></p>
		<p><b>Tipo de Menu:</b> <?= ($storesMenusItem->menu_type) ? $menu_types[$storesMenusItem->menu_type] : '' ?></p>
		<p><b>URL:</b> <?= $storesMenusItem->url ?></p>
		<p><b>Ação:</b> <?= ($storesMenusItem->target) ? $targets[$storesMenusItem->target] : '' ?></p>
		<p><b>Ícone:</b> <?= $storesMenusItem->icon ?></p>
		<p><b>Tipo de Ícone</b> <?= $storesMenusItem->icon_type ?></p>

		<p><b>Ordem</b> <?= $storesMenusItem->position ?></p>
		<p><b>Status:</b> <?= ($storesMenusItem->status) ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>' ?></p>
		<p><b>Data do Cadastro:</b> <?= $storesMenusItem->created->format("d/m/Y") ?></p>
<!--
		<tr>
			<th scope="row"><?= __('Parent Stores Menus Item') ?></th>
			<td><?= $storesMenusItem->has('parent_stores_menus_item') ? $this->Html->link($storesMenusItem->parent_stores_menus_item->name, ['controller' => 'StoresMenusItems', 'action' => 'view', $storesMenusItem->parent_stores_menus_item->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Stores Menus Group') ?></th>
			<td><?= $storesMenusItem->has('stores_menus_group') ? $this->Html->link($storesMenusItem->stores_menus_group->name, ['controller' => 'StoresMenusGroups', 'action' => 'view', $storesMenusItem->stores_menus_group->id]) : '' ?></td>
		</tr>
-->

		<hr>

		<div style="display: flex; align-items: center; justify-content: space-between;">
			<h4>Itens de Menu Filhos</h4>
		</div>
		<?php if (!empty($storesMenusItem->child_stores_menus_items)): ?>
			<div class="table-responsive">
				<table class="mar-bottom-20">
					<thead>
						<tr>
							<th width="50">ID</th>
							<th>Nome</th>
							<th>Tipo de Menu</th>
							<th>URL</th>
							<th>Menu Pai</th>
							<th width="100">Ordem</th>
							<th width="100">Ativo</th>
							<th width="150">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($storesMenusItem->child_stores_menus_items as $menuItem): ?>
							<tr>
								<td><?= $menuItem->id ?></td>
								<td><?= $menuItem->name ?></td>
								<td><?= ($menuItem->menu_type) ? $menu_types[$menuItem->menu_type] : '' ?></td>
								<td><?= $menuItem->url ?></td>
								<td><?= $menuItem->has('parent_stores_menus_item') ? $menuItem->parent_stores_menus_item->name : '-' ?></td>
								<td><?= $menuItem->position ?></td>
								<td><?= ($menuItem->status) ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>' ?></td>
								<td>
									<a class="btn btn-default btn-sm" href="<?= $this->Url->build(['controller' => 'stores-menus-items', 'action' => 'view', $menuItem->id]) ?>" title="Visualizar">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</a>
									<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'stores-menus-items', 'action' => 'edit', $menuItem->id]) ?>" title="Editar">
										<i class="fa fa-pencil" aria-hidden="true"></i>
									</a>
									<?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>',
										['controller' => 'stores-menus-items', 'action' => 'delete', $menuItem->id],
										['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false]) ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php else: ?>
			<p class="text-center">Nenhum item de menu filho.</p>
		<?php endif; ?>

		<?= $this->Html->link("Voltar", ['controller' => 'stores-menus-groups', 'action' => 'view', $storesMenusItem->stores_menus_groups_id], ['class' => 'btn btn-primary btn-sm']) ?>
	</div>
</div>
