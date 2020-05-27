<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="form-group">
	<label for="">Produto</label>
	<select class="form-control" name="url">
		<?php foreach ($products as $product) : ?>
			<option <?= ($current == $product->full_link) ? 'selected' : '' ?> value="<?= $product->full_link ?>"><?= $product->name ?></option>
		<?php endforeach; ?>
	</select>
</div>