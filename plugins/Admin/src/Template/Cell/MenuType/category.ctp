<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="form-group">
	<label for="">Categoria</label>
	<select class="form-control" name="url">
		<?php foreach ($categories as $category) : ?>
			<option <?= ($current == $category->full_link) ? 'selected' : '' ?> value="<?= $category->full_link ?>"><?= $category->title ?></option>
		<?php endforeach; ?>
	</select>
</div>