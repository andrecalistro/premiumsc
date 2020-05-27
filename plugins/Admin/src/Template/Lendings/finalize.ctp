<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
	<h2>Finalizar Comodato #<?= $lending->id ?></h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<?= $this->Form->create($lending) ?>
		<?= $this->Form->control('status', ['type' => 'hidden', 'value' => 1]) ?>

		<p><b>Nome do Cliente:</b> <?= $lending->customer_name ?></p>
		<p><b>Email do Cliente:</b> <?= $lending->customer_email ?></p>
		<p><b>Status:</b> <?= ($lending->status) ? '<span class="label label-success">Finalizado</span>' : '<span class="label label-warning">Pendente</span>' ?></p>
		<p><b>Status de Envio:</b> <?= ($lending->send_status) ? '<span class="label label-success">Enviado em '. $lending->send_date->format("d/m/Y") .'</span>' : '<span class="label label-danger">Não enviado</span>' ?></p>
		<p><b>Usuário Responsável:</b> <?= $lending->user->name ?></p>
		<p><b>Data do Cadastro:</b> <?= $lending->created->format("d/m/Y") ?></p>

		<hr>

		<h4>Selecione os produtos que o cliente adquiriu:</h4>
		<?php if (!empty($lending->products)): ?>
			<div class="table-responsive">
				<table class="mar-bottom-20">
					<thead>
						<tr>
							<th width="60"></th>
							<th width="80">ID</th>
							<th width="120">Código</th>
							<th>Nome</th>
                            <th>Preço</th>
							<th width="80">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 0;
						foreach ($lending->products as $product): ?>
							<tr>
								<td>
									<input type="hidden" name="products[<?= $i ?>][id]" value="<?= $product->id ?>">

									<input type="hidden" name="products[<?= $i ?>][_joinData][status]" value="0">
									<input type="checkbox" name="products[<?= $i ?>][_joinData][status]" value="1">
								</td>
								<td><?= $product->id ?></td>
								<td><?= $product->code ?></td>
								<td><?= isset($product->products_images[0]->thumb_image_link) ? $this->Html->image($product->products_images[0]->thumb_image_link, ['align' => 'left', 'width' => '55', 'class' => 'hidden-xs']) : '' ?> <?= $product->name ?></td>
                                <td><?= $product->price_final['formatted'] ?></td>
								<td>
									<a class="btn btn-default btn-sm" href="<?= $this->Url->build(['controller' => 'products', 'action' => 'view', $product->id]) ?>" title="Visualizar">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</a>
								</td>
							</tr>
							<?php
							$i++;
						endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php else: ?>
			<p class="text-center">Nenhum produto.</p>
		<?php endif; ?>

		<?= $this->Form->submit('Finalizar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
		<?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>