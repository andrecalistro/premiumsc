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
					<?= $this->Form->control('subject', ['class' => 'form-control', 'label' => 'Assunto do E-mail']) ?>
				</div>
			</div>
            <div class="col-md-6 form-group">
                <?= $this->Form->control('who_receives', ['class' => 'form-control', 'label' => 'Quem recebe esse e-mail', 'options' => $who_receives, 'empty' => true]) ?>
            </div>
		</div>
		<div class="row">
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
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('reply_name', ['class' => 'form-control', 'label' => 'Nome de quem recebe se o e-mail for respondido']) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('reply_email', ['class' => 'form-control', 'label' => 'E-mail de quem recebe se o e-mail for respondido']) ?>
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
			<div class="col-md-12" style="margin: 30px 0;">
				<p><strong>Tags Disponíveis</strong></p>
				<div class="row">
					<?php
					if ($emailTemplate->tags) {
						foreach (json_decode($emailTemplate->tags) as $tag) {
							echo '<div class="col-md-3">' . $tag . '</div>';
						}
					}
					?>
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