<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.Menu $menu
  */
?>
<div class="page-title">
	<h2>Menu</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid mar-bottom-20">
		<p><b>Nome:</b> <?= $menu->name ?></p>
		<p><b>Ícone:</b> <i class="fa <?= $menu->icon ?>"></i> <?= $menu->icon ?></p>
		<p><b>Menu Pai:</b> <?= $menu->has('parent_menu') ? $this->Html->link($menu->parent_menu->name, ['controller' => 'Menus', 'action' => 'view', $menu->parent_menu->id]) : '' ?></p>
		<p><b>Plugin/Controller/Action:</b> <?= $menu->plugin . '/' . $menu->controller . '/' .$menu->action ?></p>
		<p><b>Parâmetros:</b> <?= $menu->params ?></p>
		<p><b>Status:</b> <?= $menu->status ?></p>
		<p><b>Ordem:</b> <?= $menu->position ?></p>
		<p><b>Data do Cadastro:</b> <?= $menu->created->format("d/m/Y") ?></p>

		<hr>

		<h4>Menus Relacionados</h4>
		<?php if (!empty($menu->child_menus)): ?>
			<div class="table-responsive">
				<table class="mar-bottom-20">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th>Plugin/Controller/Action</th>
							<th>Ativo</th>
							<th width="150">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($menu->child_menus as $childMenu): ?>
							<tr>
								<td><?= $childMenu->id ?></td>
								<td><?= $childMenu->name ?></td>
								<td><?= $childMenu->plugin . '/' . $childMenu->controller . '/' . $childMenu->action ?></td>
								<td><?= ($childMenu->status) ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>' ?></td>
								<td>
									<a class="btn btn-default btn-sm" href="<?= $this->Url->build(['controller' => 'menus', 'action' => 'view', $childMenu->id]) ?>" title="Visualizar">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</a>
									<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'menus', 'action' => 'edit', $childMenu->id]) ?>" title="Editar">
										<i class="fa fa-pencil" aria-hidden="true"></i>
									</a>
									<?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>',
										['controller' => 'menus', 'action' => 'delete', $childMenu->id],
										['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false]) ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php else: ?>
			<p class="text-center">Nenhum menu relacionado.</p>
		<?php endif; ?>

		<hr>

		<h4>Grupos Relacionados</h4>
		<?php if (!empty($menu->rules)): ?>
			<div class="table-responsive">
				<table class="mar-bottom-20">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th width="150">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($menu->rules as $rules): ?>
							<tr>
								<td><?= $rules->id ?></td>
								<td><?= $rules->name ?></td>
								<td>
									<a class="btn btn-default btn-sm" href="<?= $this->Url->build(['controller' => 'Rules', 'action' => 'view', $rules->id]) ?>" title="Visualizar">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</a>
									<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'Rules', 'action' => 'edit', $rules->id]) ?>" title="Editar">
										<i class="fa fa-pencil" aria-hidden="true"></i>
									</a>
									<?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>',
										['controller' => 'Rules', 'action' => 'delete', $rules->id],
										['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false]) ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php else: ?>
			<p class="text-center">Nenhum grupo relacionado.</p>
		<?php endif; ?>

		<p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
	</div>
</div>