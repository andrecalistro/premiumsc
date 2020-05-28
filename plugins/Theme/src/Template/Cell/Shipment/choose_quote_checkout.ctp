<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
	<?php if ($quote['image']): ?>
		<div class="col-md-3">
			<?= $this->Html->image($quote['image']) ?>
		</div>
		<div class="col-md-3">
			<?= $quote['title'] ?>
		</div>
	<?php else: ?>
		<div class="col-md-6">
			<?= $quote['title'] ?>
		</div>
	<?php endif; ?>
	<div class="col-md-3">
		<?= $quote['text'] ?>
	</div>
	<div class="col-md-3 text-right">
		<?= $this->Form->postLink("<i class=\"fa fa-check\" aria-hidden=\"true\"></i>", '', ['escape' => false, 'class' => 'btn btn-sm btn-accent', 'data' => $quote['data']]) ?>
	</div>
</div>
<hr>