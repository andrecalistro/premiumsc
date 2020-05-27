<table width="600" cellspacing="0" cellpadding="0" border="0" align="center">
	<tbody>
		<tr>
			<td style="background-color: #f4f4f4; padding: 15px;" colspan="2">
				<p style="font-weight: 700;font-size: 16px;">Produto</p>
			</td>
			<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
				<p style="font-weight: 700;font-size: 16px;">Preço</p>
			</td>
			<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;" width="120">
				<p style="font-weight: 700; font-size: 16px;">Valor do Fornecedor</p>
			</td>
		</tr>

		<?php foreach ($products as $product) : ?>
			<tr><td style="padding: 1px;"></td></tr>
			<tr style="font-size: 14px;">
				<td style="background-color: #f4f4f4; padding: 15px;">
					<img src="<?= $product->thumb_main_image ?>" alt="" style="display: block; max-width: 70px;">
				</td>
				<td style="background-color: #f4f4f4; padding: 15px;">
					<p><?= $product->name ?></p>
				</td>
				<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
					<p><?= $product->price_final['formatted'] ?></p>
				</td>
				<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
					<p><?= $product->commission['formatted'] ?></p>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>