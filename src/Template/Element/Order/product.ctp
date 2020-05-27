<table cellspacing="0" cellpadding="0" border="0" align="center" width="600">
	<tbody>
		<tr>
			<td style="background-color: #f4f4f4; padding: 15px;" colspan="2">
				<p style="font-weight: 700;font-size: 16px;">Itens do Pedido</p>
			</td>
			<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
				<p style="font-weight: 700;font-size: 16px;">Qtd</p>
			</td>
			<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
				<p style="font-weight: 700;font-size: 16px;">Valor Unitário</p>
			</td>
			<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
				<p style="font-weight: 700; font-size: 16px;">Subtotal</p>
			</td>
		</tr>
		<tr><td style="padding: 1px;"></td></tr>

		<?php foreach ($products as $product) : ?>
			<tr style="font-size: 14px;">
				<td style="background-color: #f4f4f4; padding: 15px;">
					<img src="<?= $product->image_thumb ?>" alt="" style="display: block">
				</td>
				<td style="background-color: #f4f4f4; padding: 15px;">
					<p><b><?= $product->name ?></b></p>
                    <?php if($product->orders_products_variations): ?>
                        <small>Código <?= $product->product->code ?> - <?= $product->orders_products_variations[0]->variations_sku ?></small>
                        <br><?= $product->orders_products_variations[0]->variation->variations_group->name ?>: <?= $product->orders_products_variations[0]->variation->name ?>
                    <?php else: ?>
                        <small>Código <?= $product->product->code ?></small>
                    <?php endif; ?>
				</td>
				<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
					<p><?= $product->quantity ?></p>
				</td>
				<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
					<p><?= $product->price_format ?></p>
				</td>
				<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
					<p><?= $product->price_total_format ?></p>
				</td>
			</tr>
			<tr><td style="padding: 1px;"></td></tr>
		<?php endforeach; ?>
	</tbody>
</table>