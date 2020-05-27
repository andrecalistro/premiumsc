<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.Rule $rule
  */
?>
<div class="page-title">
	<h2>Grupo</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid mar-bottom-20">
		<p><b>Nome:</b> <?= $rule->name ?></p>
		<p><b>Público:</b>  <?= ($rule->public) ? 'Sim' : 'Não' ?></p>
		<p><b>Data do Cadastro:</b> <?= $rule->created->format("d/m/Y") ?></p>

		<hr>

		<h4>Menus Relacionados</h4>
		<?php if (!empty($rule->menus)): ?>
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
						<?php foreach ($rule->menus as $menu): ?>
							<tr>
								<td><?= $menu->id ?></td>
								<td><?= $menu->name ?></td>
								<td><?= $menu->plugin . '/' . $menu->controller . '/' . $menu->action ?></td>
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
					</tbody>
				</table>
			</div>
		<?php else: ?>
			<p class="text-center">Nenhum menu relacionado.</p>
		<?php endif; ?>

		<p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
	</div>
</div>