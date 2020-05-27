<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.EmailTemplate $emailTemplate
  */
?>
<div class="page-title">
	<h2>Template de E-mail - <?= $emailTemplate->name ?></h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<div class="row">
			<div class="col-md-4">
				<p><strong>Nome</strong></p>
				<?= $emailTemplate->name ?>
			</div>
			<div class="col-md-4">
				<p><strong>Slug</strong></p>
				<?= $emailTemplate->slug ?>
			</div>
			<div class="col-md-4">
				<p><strong>Assunto do E-mail</strong></p>
				<?= $emailTemplate->subject ?>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-4">
				<p><strong>Nome do Remetente</strong></p>
				<?= $emailTemplate->reply_name ?>
			</div>
			<div class="col-md-4">
				<p><strong>E-mail de quem recebe se o e-mail for respondido</strong></p>
				<?= $emailTemplate->reply_email ?>
			</div>
		</div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <p><strong>Nome de quem recebe se o e-mail for respondido</strong></p>
                <?= $emailTemplate->from_name ?>
            </div>
            <div class="col-md-4">
                <p><strong>E-mail do Remetente</strong></p>
                <?= $emailTemplate->from_email ?>
            </div>
        </div>
		<hr>
		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<p><strong>Header</strong></p>
				<?= !empty($emailTemplate->header_thumb_link) ? "<p>" . $this->Html->image($emailTemplate->header_thumb_link, ['class' => 'thumbnail']) . "</p>" : '' ?>
			</div>
			<div class="col-md-4">
				<p><strong>Footer</strong></p>
				<?= !empty($emailTemplate->footer_thumb_link) ? "<p>" . $this->Html->image($emailTemplate->footer_thumb_link, ['class' => 'thumbnail']) . "</p>" : '' ?>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<p><strong>Tags Disponíveis</strong></p>
				<p>
				<?php
				if ($emailTemplate->tags) {
					foreach (json_decode($emailTemplate->tags) as $tag) {
						echo $tag . '<br>';
					}
				}
				?>
				</p>
			</div>
			<div class="col-md-6">
				<p><strong>Conteúdo</strong></p>
				<?= $emailTemplate->content ?>
			</div>
		</div>
		<?= $this->Html->link("Voltar", ['action' => 'index', 'plugin' => 'admin'], ['class' => 'btn btn-primary btn-sm']) ?>
	</div>
</div>
