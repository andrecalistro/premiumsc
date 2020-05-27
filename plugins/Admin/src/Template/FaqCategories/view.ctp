<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.FaqCategory $faqCategory
  */
?>
<div class="page-title">
	<h2>Categoria de Perguntas Frequentes</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<p><b>Título:</b> <?= $faqCategory->name ?></p>
		<p><b>Páginas:</b> <?= $faqCategory->pages ?></p>
		<p><b>Data do Cadastro:</b> <?= $faqCategory->created->format("d/m/Y") ?></p>

		<p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
	</div>
</div>
