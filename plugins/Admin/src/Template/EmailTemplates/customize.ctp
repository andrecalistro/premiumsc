<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
	<h2>Editar Template de E-mail</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<?= $this->Form->create($emailTemplate, ['type' => 'file']) ?>

		<h3 style="margin-top: 0;">Informações do Template</h3>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome do Template']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<?= $this->Form->control('subject', ['class' => 'form-control', 'label' => 'Assunto do E-mail']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<?= $this->Form->control('from_name', ['class' => 'form-control', 'label' => 'Nome do Remetente']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<?= $this->Form->control('from_email', ['class' => 'form-control', 'label' => 'E-mail do Remetente']) ?>
				</div>
			</div>
		</div>

		<h3>Conteúdo do Template</h3>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?= $this->Form->control('header', ['type' => 'file', 'class' => 'form-control', 'label' => 'Imagem do Header']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<?= $this->Form->control('footer', ['type' => 'file', 'class' => 'form-control', 'label' => 'Imagem do Footer']) ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?= $this->Form->control('tags', ['class' => 'form-control', 'label' => 'Tags Disponíveis']) ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?= $this->Form->control('content', ['class' => 'form-control input-editor-small', 'label' => 'Conteúdo do E-mail']) ?>
				</div>
			</div>
		</div>

		<?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
		<?= $this->Html->link("Voltar", ['action' => 'index', 'plugin' => 'admin'], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>