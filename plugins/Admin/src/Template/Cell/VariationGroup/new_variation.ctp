<tr>
    <input type="hidden" name="products_variations[<?= $uniqid ?>][variations_groups_id]" value="<?= $variations_group->id ?>">
    <td>
        <select name="products_variations[<?= $uniqid ?>][variations_id]" class="form-control">
            <?php foreach($variations_group->variations as $variation): ?>
                <option value="<?= $variation->id ?>"><?= $variation->name ?></option>
            <?php endforeach; ?>
        </select>
    </td>
    <td>
        <input name="products_variations[<?= $uniqid ?>][stock]" class="form-control" type="text">
    </td>
    <td>
        <input name="products_variations[<?= $uniqid ?>][sku]" class="form-control" type="text">
    </td>
	<td>
		<input name="products_variations[<?= $uniqid ?>][auxiliary_field]" class="form-control" type="<?= $variations_group->auxiliary_field_type == 'text' ? 'text' : 'file' ?>">
	</td>
    <td>
        <input name="products_variations[<?= $uniqid ?>][image]" type="file" class="form-control">
    </td>
    <td>
        <button type="button" class="btn btn-danger btn-sm btn-delete-variation" title="Excluir"><i class="fa fa-trash"
                                                                 aria-hidden="true"></i>
        </button>
    </td>
</tr>