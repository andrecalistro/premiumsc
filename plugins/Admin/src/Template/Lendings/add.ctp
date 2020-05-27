<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['catalog/lending.functions.js'], ['block' => 'scriptBottom', 'fullLink' => true]);
?>
<div class="page-title">
	<h2>Cadastrar Comodato</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<?= $this->Form->create($lending) ?>
		<div class="form-group">
			<?= $this->Form->control('customer_name', ['class' => 'form-control', 'label' => 'Nome do Cliente']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('customer_email', ['class' => 'form-control', 'label' => 'Email do Cliente']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('customer_document', ['class' => 'form-control input-cpf', 'label' => 'CPF do Cliente']) ?>
		</div>
		<div class="form-group">
			<label>Produtos</label>
			<div class="input-group">
				<select name="product" class="form-control input-select2" id="products-ids" tabindex="-1" aria-hidden="true">
					<?php foreach ($products as $product): ?>
						<option <?= isset($product->products_images[0]->thumb_image_link) ? 'data-image="' . $product->products_images[0]->thumb_image_link . '"' : '' ?>
								value="<?= $product->id ?>"><?= $product->code . ' - ' . $product->name ?></option>
					<?php endforeach; ?>
				</select>
				<span class="input-group-btn">
					<button class="btn btn-primary js-add-product" type="button">Adicionar Produto</button>
				</span>
			</div>
		</div>
		<div class="table-responsive list-products mar-bottom-20 js-products-list">
			<table>
				<thead>
					<tr>
						<th>Produto</th>
						<th>Valor</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
		<?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>

<?= $this->element('Lending/modal_products') ?>
