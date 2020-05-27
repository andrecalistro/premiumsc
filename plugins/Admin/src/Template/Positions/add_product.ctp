<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Adicionar Produto</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($product_position, ['type' => 'file']) ?>
        <div class="form-group">
            <label>Posição</label><br>
            <?= $position->name ?>
            <?= $this->Form->hidden("positions_id", ['value' => $position->id]) ?>
        </div>
        <div class="form-group">
			<label for="products-id">Produto</label>
			<select name="products_id" id="products-id" class="form-control input-select2" required>
				<option value="">Selecione...</option>
				<?php foreach ($products as $product) : ?>
					<option <?= isset($product->products_images[0]->thumb_image_link) ? 'data-image="'. $product->products_images[0]->thumb_image_link .'"' : '' ?> value="<?= $product->id ?>"><?= $product->code . ' - ' . $product->name ?></option>
				<?php endforeach; ?>
			</select>

        </div>
        <div class="form-group">
            <?= $this->Form->control('order_show', ['label' => 'Posição', 'class' => 'form-control']) ?>
        </div>
        
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'positions', 'action' => 'view', $position->id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
