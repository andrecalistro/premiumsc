<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="page-title">
	<h2>Nova Categoria de Perguntas Frequentes</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<?= $this->Form->create($faqCategory) ?>
		<div class="row">
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 form-group">
				<?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Título']) ?>
			</div>
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 form-group">
				<?= $this->Form->control('pages', ['class' => 'form-control', 'label' => 'Páginas']) ?>
			</div>
		</div>

		<?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
		<?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>