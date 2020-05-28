<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['category.functions.js'], ['fullBase' => true, 'block' => 'scriptBottom']);
?>
<div id="content" class="pad-top-25 pad-bottom-95">
	<div class="container">
		<div class="tp-breadcrumbs mar-bottom-30">
			<a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a>
			<span class="sep"><i class="fa fa-angle-right"></i></span>
			<?= $_pageTitle ?>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12">
				<?= $this->element('box-filters') ?>
			</div>
			<div class="col-md-9 col-sm-12">
				<div class="categories-title">
					<?= $_pageTitle ?>
                    
					<span class="categories-total">
						<span>Resultado:</span> <?= $this->Paginator->counter('{{count}}'); ?> <?= ($this->Paginator->counter('{{count}}') == 1) ? 'Item' : 'Itens' ?>
					</span>
				</div>

				<div class="categories-filter">
					<?= $this->element('pagination') ?>
				</div>
				<div class="row space-60 category-content grid flex-wrap">
					<?php if ($this->Paginator->total() > 0): ?>
						<?php foreach ($products as $product): ?>
							<div class="col-md-4 col-sm-6">
								<?= $this->element('product_home', ['product' => $product]) ?>
							</div>
						<?php endforeach; ?>
					<?php else: ?>
						<p>Não há resultados para a sua pesquisa</p>
					<?php endif; ?>
				</div>
				<div class="categories-filter filter-bottom">
					<?= $this->element('pagination') ?>
				</div>
			</div>
		</div>
	</div>
</div>

