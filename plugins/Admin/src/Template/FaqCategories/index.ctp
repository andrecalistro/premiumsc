<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.FaqCategory[]|\Cake\Collection\CollectionInterface $faqCategories
  */
?>
<div class="page-title">
	<h2>Perguntas Frequentes</h2>
</div>
<div class="content">
	<div class="container-fluid">
		<p><a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['action' => 'add']) ?>">Adicionar</a></p>
	</div>
	<div class="table-responsive">
		<table class="mar-bottom-20">
			<thead>
				<tr>
					<th>ID</th>
					<th>Título</th>
					<th>Páginas</th>
					<th>Cadastrado em</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($faqCategories): ?>
					<?php foreach ($faqCategories as $faqCategory): ?>
						<tr>
							<td><?= $faqCategory->id ?></td>
							<td><?= $faqCategory->name ?></td>
							<td><?= $faqCategory->pages ?></td>
							<td><?= $faqCategory->created->format('d/m/Y') ?></td>
							<td>
								<a class="btn btn-default btn-sm"
								   href="<?= $this->Url->build(['action' => 'view', $faqCategory->id]) ?>" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a class="btn btn-info btn-sm"
								   href="<?= $this->Url->build(['controller' => 'FaqQuestions', 'action' => 'category', $faqCategory->id]) ?>" title="Ver Perguntas"><i class="fa fa-list" aria-hidden="true"></i></a>
								<a class="btn btn-primary btn-sm"
								   href="<?= $this->Url->build(['action' => 'edit', $faqCategory->id]) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>',
									['action' => 'delete', $faqCategory->id],
									['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<?= $this->element('pagination') ?>
