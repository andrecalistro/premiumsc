<?php
/**
 * @var App\View\AppView $this
 */
?>
<p>Olá fornecedor <?= $data['name'] ?>, aqui estão as informações dos seus produtos na loja Desapegar:</p>

<p style="font-size: 16px;">Produtos a vender:</p>
<?php if (count($data['toReceive']['products']) > 0) : ?>
	<table border="1" cellpadding="5" cellspacing="0" style="margin-bottom: 50px;">
		<thead>
			<tr>
				<th></th>
				<th>Produto</th>
				<th>Preço</th>
				<th>Valor do Fornecedor</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data['toReceive']['products'] as $product) { ?>
				<tr>
					<td></td>
					<td><?= $product->name ?></td>
					<td><?= $product->price_special_format ?></td>
					<td><?= number_format($product->commission, 2, ',', '') ?></td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th>Totais</th>
				<th><?= count($data['toReceive']['products']) ?></th>
				<th><?= $data['toReceive']['total'] ?></th>
				<th><?= number_format($data['toReceive']['commission'], 2, ',', '') ?></th>
			</tr>
		</tfoot>
	</table>
<?php else: ?>
	<p>Nenhum produto.</p>
<?php endif; ?>

<p style="font-size: 16px;">Produtos vendidos</p>
<?php if (count($data['received']['products']) > 0) : ?>
	<table border="1" cellpadding="5" cellspacing="0">
		<thead>
			<tr>
				<th></th>
				<th>Produto</th>
				<th>Preço</th>
				<th>Valor do Fornecedor</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data['received']['products'] as $product) { ?>
				<tr>
					<td></td>
					<td><?= $product->name ?></td>
					<td><?= $product->price_special_format ?></td>
					<td><?= number_format($product->commission, 2, ',', '') ?></td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th>Totais</th>
				<th><?= count($data['received']['products']) ?></th>
				<th><?= $data['received']['total'] ?></th>
				<th><?= number_format($data['received']['commission'], 2, ',', '') ?></th>
			</tr>
		</tfoot>
	</table>
<?php else: ?>
	<p>Nenhum produto.</p>
<?php endif; ?>
