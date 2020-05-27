<table cellspacing="0" cellpadding="0" border="0" align="center" width="600">
	<tbody>
		<tr>
			<td style="background-color: #f4f4f4; padding: 15px;" colspan="2">
				<p style="font-weight: 700;font-size: 16px;">Itens do Comodato</p>
			</td>
			<td style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
				<p style="font-weight: 700;font-size: 16px;">Valor</p>
			</td>
		</tr>
		<tr><td style="padding: 1px;"></td></tr>

		<?php foreach ($products as $product) : ?>
			<tr style="font-size: 14px;">
				<td width="55" style="background-color: #f4f4f4; padding: 15px;">
					<a target="_blank" href="<?= $product->full_link ?>">
						<?= isset($product->products_images[0]->thumb_image_link) ?
							$this->Html->image($product->products_images[0]->thumb_image_link, ['width' => '55']) : '' ?>
					</a>
				</td>
				<td style="background-color: #f4f4f4; padding: 15px;">
					<p><?= $product->name ?></p>
				</td>
				<td width="150" style="background-color: #f4f4f4; padding: 15px; border-left: 2px solid #fff;">
					<p><?= $product->price_final['formatted'] ?></p>
				</td>
			</tr>
			<tr><td style="padding: 1px;"></td></tr>
		<?php endforeach; ?>
	</tbody>
</table>