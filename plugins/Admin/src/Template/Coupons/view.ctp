<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.Coupon $coupon
  */
?>
<div class="page-title">
	<h2>Cupom de Desconto "<?= $coupon->code ?>"</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid mar-bottom-20">
		<div class="row">
			<div class="col-md-4">
				<p><b>Nome:</b> <?= $coupon->name ?></p>
				<p><b>Descrição:</b> <?= $coupon->description ?></p>
				<p><b>Código:</b> <?= $coupon->code ?></p>
				<p><b>Tipo:</b> <?= $coupon_types[$coupon->type] ?></p>
				<p><b>Valor:</b> <?= $coupon->value_formatted ?></p>
				<?php /*<p><b>Frete grátis?</b> <?= ($coupon->free_shipping) ? 'Sim' : 'Não' ?></p> */ ?>
				<p><b>Data de lançamento:</b> <?= ($coupon->release_date) ? $coupon->release_date->format('d/m/Y H:i') : '-' ?></p>
				<p><b>Data de expiração:</b> <?= ($coupon->expiration_date) ? $coupon->expiration_date->format('d/m/Y H:i') : '-' ?></p>
			</div>
			<div class="col-md-4">
				<p><b>Valor mínimo da compra:</b> <?= $coupon->min_value_formatted ?></p>
				<p><b>Valor máximo da compra:</b> <?= $coupon->max_value_formatted ?></p>
				<?php /*<p><b>Apenas uso individual?</b> <?= ($coupon->only_individual_use) ? 'Sim' : 'Não' ?></p>
				<p><b>Excluir itens em oferta?</b> <?= ($coupon->exclude_promotional_items) ? 'Sim' : 'Não' ?></p>*/ ?>
			</div>
			<div class="col-md-4">
				<p><b>Limite de uso do cupom:</b> <?= $coupon->use_limit ?></p>
				<p><b>Limite usado:</b> <?= $coupon->used_limit ?></p>
				<?php /*<p><b>Limite de uso por cliente:</b> <?= $coupon->customer_use_limit ?></p>*/ ?>
			</div>
		</div>
		<?php /*<hr>
		<div class="row">
			<div class="col-md-4">
				<p>
					<b>Produtos</b><br>
					<?php
					if ($coupon->products_ids_array) {
						foreach ($coupon->products_ids_array as $item) {
							echo '&emsp;' . $products[$item] . '<br>';
						}
					} else {
						echo '&emsp;-';
					}
					?>
				</p>
				<br>
				<p>
					<b>Excluir Produtos</b><br>
					<?php
					if ($coupon->excluded_products_ids_array) {
						foreach ($coupon->excluded_products_ids_array as $item) {
							echo '&emsp;' . $products[$item] . '<br>';
						}
					} else {
						echo '&emsp;-';
					}
					?>
				</p>
			</div>
			<div class="col-md-4">
				<p>
					<b>Categorias</b><br>
					<?php
					if ($coupon->categories_ids_array) {
						foreach ($coupon->categories_ids_array as $item) {
							echo '&emsp;' . $categories[$item] . '<br>';
						}
					} else {
						echo '&emsp;-';
					}
					?>
				</p>
				<br>
				<p>
					<b>Excluir Categorias</b><br>
					<?php
					if ($coupon->excluded_categories_ids_array) {
						foreach ($coupon->excluded_categories_ids_array as $item) {
							echo '&emsp;' . $categories[$item] . '<br>';
						}
					} else {
						echo '&emsp;-';
					}
					?>
				</p>
			</div>
			<div class="col-md-4">
				<b>Restringir aos e-mails</b><br>
				<?= nl2br($coupon->restricted_emails_list) ?>
			</div>
		</div>*/ ?>

		<hr>
		<?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
	</div>
</div>