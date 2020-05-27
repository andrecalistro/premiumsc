<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="page-title">
	<h2>Nova Pergunta</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<?= $this->Form->create($faqQuestion) ?>
		<?= $this->Form->control('faq_categories_id', ['type' => 'hidden', 'label' => false, 'value' => $faqCategoryId]) ?>
		<div class="row">
			<div class="col-lg-3 col-sm-4 col-md-6 col-xs-12 form-group">
				<?= $this->Form->control('position', ['type' => 'number', 'class' => 'form-control', 'label' => 'Posição', 'value' => 1]) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 form-group">
				<?= $this->Form->control('question', ['type' => 'textarea', 'class' => 'form-control', 'label' => 'Pergunta']) ?>
			</div>
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 form-group">
				<?= $this->Form->control('answer', ['type' => 'textarea', 'class' => 'form-control', 'label' => 'Resposta']) ?>
			</div>
		</div>

		<?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
		<?= $this->Html->link('Voltar', ['controller' => 'FaqQuestions', 'action' => 'category', $faqCategoryId], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>
