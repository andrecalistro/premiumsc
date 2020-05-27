<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.FaqQuestion[]|\Cake\Collection\CollectionInterface $faqQuestions
  */
?>
<div class="page-title">
	<h2><?= $faqCategory->name ?></h2>
</div>
<div class="content">
	<div class="container-fluid">
		<p><a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['action' => 'add', $faqCategory->id]) ?>">Adicionar</a></p>
	</div>
	<div class="table-responsive">
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Pergunta</th>
					<th>Posição</th>
					<th>Cadastrado em</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($faqQuestions): ?>
					<?php foreach ($faqQuestions as $faqQuestion): ?>
						<tr>
							<td><?= $faqQuestion->id ?></td>
							<td><?= $faqQuestion->question ?></td>
							<td><?= $faqQuestion->position ?></td>
							<td><?= $faqQuestion->created->format('d/m/Y') ?></td>
							<td>
								<a class="btn btn-default btn-sm"
								   href="<?= $this->Url->build(['action' => 'view', $faqQuestion->id]) ?>" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a class="btn btn-primary btn-sm"
								   href="<?= $this->Url->build(['action' => 'edit', $faqQuestion->id]) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>',
									['action' => 'delete', $faqQuestion->id],
									['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<div class="container-fluid">
		<p><a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'FaqCategories', 'action' => 'index']) ?>">Voltar para lista de tipos de perguntas</a></p>
	</div>
</div>

<?= $this->element('pagination') ?>

