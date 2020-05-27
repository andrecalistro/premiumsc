<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.Coupon[]|\Cake\Collection\CollectionInterface $coupons
  */
?>
<div class="page-title">
	<h2>Cupons de Desconto</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid">
		<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'coupons', 'action' => 'add', 'plugin' => 'admin']) ?>">
			Adicionar Cupom
		</a>
	</div>
	<div class="table-responsive">
		<table class="mar-bottom-20">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th>Nome</th>
					<th>Código</th>
					<th>Valor</th>
					<th>Tipo de Desconto</th>
					<th>Utilizado / Limite</th>
					<th>Frete Grátis</th>
					<th>Expira em</th>
					<th width="150">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($coupons): ?>
					<?php foreach ($coupons as $coupon): ?>
						<tr>
							<td><?= $coupon->id ?></td>
							<td><?= $coupon->name ?></td>
							<td><?= $coupon->code ?></td>
							<td><?= $coupon->value_formatted ?></td>
							<td><?= $coupon_types[$coupon->type] ?></td>
							<td><?= $coupon->used_limit ?> / <?= ($coupon->use_limit) ? $coupon->use_limit : 'ilimitado' ?></td>
							<td><?= ($coupon->free_shipping) ? 'Sim' : 'Não' ?></td>
							<td><?= ($coupon->expiration_date) ? $coupon->expiration_date->format('d/m/Y H:i') : '-' ?></td>
							<td>
								<a class="btn btn-default btn-sm" href="<?= $this->Url->build(['controller' => 'coupons', 'action' => 'view', $coupon->id]) ?>" title="Visualizar">
									<i class="fa fa-eye" aria-hidden="true"></i>
								</a>
								<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'coupons', 'action' => 'edit', $coupon->id]) ?>" title="Editar">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>
								<?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>',
									['controller' => 'coupons', 'action' => 'delete', $coupon->id],
									['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false]) ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<?= $this->element('pagination') ?>