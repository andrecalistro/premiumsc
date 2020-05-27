<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.FaqQuestion $faqQuestion
  */
?>
<div class="page-title">
	<h2>Pergunta Frequente</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<p>
			<b>Categoria:</b><br>
			<?= $faqQuestion->has('faq_category') ? $this->Html->link($faqQuestion->faq_category->name, ['controller' => 'FaqCategories', 'action' => 'view', $faqQuestion->faq_category->id]) : '' ?>
		</p>
		<p>
			<b>Pergunta:</b><br>
			<?= $this->Text->autoParagraph(h($faqQuestion->question)); ?>
		</p>
		<p>
			<b>Resposta:</b><br>
			<?= $this->Text->autoParagraph(h($faqQuestion->answer)); ?>
		</p>
		<p><b>Posição:</b> <?= $faqQuestion->position ?></p>
		<p><b>Data do Cadastro:</b> <?= $faqQuestion->created->format("d/m/Y") ?></p>

		<p><?= $this->Html->link('Voltar', $this->request->referer(), ['class' => 'btn btn-primary btn-sm']) ?></p>
	</div>
</div>