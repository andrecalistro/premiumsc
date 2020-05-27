<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="form-group">
	<label for="">Página</label>
	<select class="form-control" name="url">
		<?php foreach ($pages as $page) : ?>
			<option <?= ($current == $page->full_link) ? 'selected' : '' ?> value="<?= $page->full_link ?>"><?= $page->name ?></option>
		<?php endforeach; ?>
	</select>
</div>