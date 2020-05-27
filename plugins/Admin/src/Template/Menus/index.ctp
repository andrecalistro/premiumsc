<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.Menu[]|\Cake\Collection\CollectionInterface $menus
  */
?>
<div class="page-title">
	<h2>Menus</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid">
		<p><a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'menus', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar Menu</a></p>
	</div>
	<div class="table-responsive">
		<table class="mar-bottom-20">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nome</th>
					<th>Plugin/Controller/Action</th>
                    <th>Menu pai</th>
					<th>Possui submenus?</th>
					<th>Ordem</th>
					<th>Ativo</th>
					<th width="150">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($menus): ?>
					<?php foreach ($menus as $menu): ?>
						<tr>
							<td><?= $menu->id ?></td>
							<td><?= $menu->name ?></td>
							<td><?= $menu->plugin . '/' . $menu->controller . '/' . $menu->action ?></td>
                            <td><?= $menu->has('parent_menu') ? $menu->parent_menu->name : '' ?></td>
							<td><?= (count($menu->child_menus) > 0) ? 'Sim' : 'Não' ?></td>
							<td><?= $menu->position ?></td>
							<td><?= ($menu->status) ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>' ?></td>
							<td>
								<a class="btn btn-default btn-sm" href="<?= $this->Url->build(['controller' => 'menus', 'action' => 'view', $menu->id]) ?>" title="Visualizar">
									<i class="fa fa-eye" aria-hidden="true"></i>
								</a>
								<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'menus', 'action' => 'edit', $menu->id]) ?>" title="Editar">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>
								<?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>',
									['controller' => 'menus', 'action' => 'delete', $menu->id],
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