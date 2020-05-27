<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.StoresMenusGroup $storesMenusGroup
  */
?>
<div class="page-title">
	<h2>Menu "<?= $storesMenusGroup->name ?>"</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid mar-bottom-20">
		<p><b>Nome:</b> <?= $storesMenusGroup->name ?></p>
		<p><b>Slug:</b> <?= $storesMenusGroup->slug ?></p>
		<p><b>Status:</b> <?= ($storesMenusGroup->status) ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>' ?></p>
		<p><b>Data do Cadastro:</b> <?= $storesMenusGroup->created->format("d/m/Y") ?></p>

		<hr>

		<div style="display: flex; align-items: center; justify-content: space-between;">
			<h4>Itens do Menu</h4>
			<a style="float: right;" class="btn btn-primary btn-sm"
			   href="<?= $this->Url->build(['controller' => 'stores-menus-items', 'action' => 'add', 'plugin' => 'admin', $storesMenusGroup->id]) ?>">
				Adicionar Item de Menu
			</a>
		</div>
		<?php if (!empty($storesMenusGroup->stores_menus_items)): ?>
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
						<?php foreach ($storesMenusGroup->stores_menus_items as $menuItem): ?>
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
			<p class="text-center">Nenhum item de menu.</p>
		<?php endif; ?>

		<p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
	</div>
</div>