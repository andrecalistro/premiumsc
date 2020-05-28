<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="box-produto">
	<div class="bg-cor-3 w-100 py-3 d-flex justify-content-center">
		<a href="<?= $product->full_link ?>">
			<?= $this->Html->image($product->main_image, ['class' => 'img-fluid']) ?>
		</a>
	</div>
	<div class="box-produtos-info text-center mt-2">
		<h3><?= $product->name ?></h3>
		<p class="valor">
			<?php if ($product->price_special): ?>
				de
				<del><?= $product->old_price ?></del><br>
				por <?= $product->price_format['formatted'] ?>
			<?php else: ?>
				<?= $product->price_format['formatted'] ?>
			<?php endif; ?>
		</p>
		<!--
		<div class="estrelas txt-laranja">
			<i class="far fa-star fa-lg"></i>
			<i class="far fa-star fa-lg"></i>
			<i class="far fa-star fa-lg"></i>
			<i class="far fa-star fa-lg"></i>
			<i class="far fa-star fa-lg"></i>
		</div>
		-->
		<input type="hidden" id="input-product-id" value="<?= $product->id ?>">
        <input type="hidden" name="quantity" data-quantity-product-id="<?= $product->id ?>" value="1">
		<button class="btn btn-block btn-padrao btn-add-cart-out"
				data-product-id="<?= $product->id ?>" data-product-link="<?= $product->full_link ?>">
			adicionar no carrinho
		</button>
	</div>
</div>