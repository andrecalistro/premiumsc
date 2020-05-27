<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.StoresMenusGroup[]|\Cake\Collection\CollectionInterface $storesMenusGroups
  */
?>
<div class="page-title">
	<h2>Menus da Loja</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid">
		<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'stores-menus-groups', 'action' => 'add', 'plugin' => 'admin']) ?>">
			Adicionar Menu
		</a>
	</div>
	<div class="table-responsive">
		<table class="mar-bottom-20">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th>Nome</th>
					<th>Ativo</th>
					<th width="150">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($storesMenusGroups): ?>
					<?php foreach ($storesMenusGroups as $storesMenusGroup): ?>
						<tr>
							<td><?= $storesMenusGroup->id ?></td>
							<td><?= $storesMenusGroup->name ?></td>
							<td><?= ($storesMenusGroup->status) ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>' ?></td>
							<td>
								<a class="btn btn-default btn-sm" href="<?= $this->Url->build(['controller' => 'stores-menus-groups', 'action' => 'view', $storesMenusGroup->id]) ?>" title="Visualizar">
									<i class="fa fa-eye" aria-hidden="true"></i>
								</a>
								<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'stores-menus-groups', 'action' => 'edit', $storesMenusGroup->id]) ?>" title="Editar">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>
								<?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>',
									['controller' => 'stores-menus-groups', 'action' => 'delete', $storesMenusGroup->id],
									['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false]) ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<?= $this->element('pagination') ?>
