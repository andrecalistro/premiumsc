<?php
/**
 * @var \Admin\View\AppView $this
 * @var \Admin\Model\Entity\VariationsGroup $variations_group
 */
?>
<div class="variation-content" id="variation-content-<?= $variations_group->id ?>" data-id="variation-content-<?= $variations_group->id ?>">
	<h3><?= $variations_group->name ?></h3>
	<div class="table-responsive">
		<table>
			<thead>
				<tr>
					<th>Nome</th>
					<th>Estoque</th>
					<th>Código</th>
					<th>Campo Auxiliar</th>
					<th>Imagem</th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5"></td>
					<td align="center">
						<button class="btn btn-sm btn-primary btn-add-variation" data-variations-groups-id="<?= $variations_group->id ?>" type="button">
							<i class="fa fa-plus" aria-hidden="true"></i>
						</button>
					</td>
				</tr>
			</tfoot>
			<tbody>
			</tbody>
		</table>
	</div>
</div>