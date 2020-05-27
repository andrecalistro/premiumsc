<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.Rule[]|\Cake\Collection\CollectionInterface $rules
  */
?>
<div class="page-title">
	<h2>Grupos</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid">
		<p><a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'rules', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar Grupo</a></p>
	</div>
	<div class="table-responsive">
		<table class="mar-bottom-20">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nome</th>
					<th>Público</th>
					<th width="150">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($rules): ?>
					<?php foreach ($rules as $rule): ?>
						<tr>
							<td><?= $rule->id ?></td>
							<td><?= $rule->name ?></td>
							<td><?= ($rule->public) ? 'Sim' : 'Não' ?></td>
							<td>
								<a class="btn btn-default btn-sm" href="<?= $this->Url->build(['controller' => 'rules', 'action' => 'view', $rule->id]) ?>" title="Visualizar">
									<i class="fa fa-eye" aria-hidden="true"></i>
								</a>
								<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'rules', 'action' => 'edit', $rule->id]) ?>" title="Editar">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>
								<?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>',
									['controller' => 'rules', 'action' => 'delete', $rule->id],
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
