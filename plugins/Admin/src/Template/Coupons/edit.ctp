<?php
/**
  * @var \App\View\AppView $this
  */
$this->Html->scriptBlock('
$(document).on("keyup", "input#code", function(){
    var self = $(this);
    self.val(self.val().toUpperCase());
});
', ['block' => 'scriptBottom']);
?>
<div class="page-title">
	<h2>Editar Cupom</h2>
</div>
<div class="content mar-bottom-30">
	<div class="container-fluid pad-bottom-30">
		<?= $this->Form->create($coupon) ?>

		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#geral" aria-controls="geral" role="tab" data-toggle="tab">Geral</a></li>
			<li role="presentation"><a href="#restricoes" aria-controls="restricoes" role="tab" data-toggle="tab">Restrições de Uso</a></li>
			<li role="presentation"><a href="#limites" aria-controls="limites" role="tab" data-toggle="tab">Limites de Uso</a></li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="geral">
				<div class="form-group">
					<?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('description', ['class' => 'form-control', 'label' => 'Descrição']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('code', ['class' => 'form-control', 'label' => 'Código']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('type', ['class' => 'form-control', 'options' => $coupon_types, 'label' => 'Tipo de desconto']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('value', ['type' => 'text', 'class' => 'form-control input-price', 'label' => 'Valor do desconto', 'value' => $coupon->value_formatted]) ?>
				</div>
                <?php /*<div class="form-group">
					<?= $this->Form->control('free_shipping', ['class' => '', 'label' => 'Habilitar frete grátis']) ?>
				</div>*/ ?>
				<div class="form-group">
					<?= $this->Form->control('release_date',
						['type' => 'text', 'class' => 'form-control input-date-time', 'label' => 'Data/hora de lançamento', 'empty' => true,
							'value' => ($coupon->release_date) ? $coupon->release_date->format('d/m/Y H:i') : '']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('expiration_date',
						['type' => 'text', 'class' => 'form-control input-date-time', 'label' => 'Data/hora de expiração', 'empty' => true,
							'value' => ($coupon->expiration_date) ? $coupon->expiration_date->format('d/m/Y H:i') : '']) ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="restricoes">
				<div class="form-group">
					<?= $this->Form->control('min_value', ['type' => 'text', 'class' => 'form-control input-price', 'label' => 'Valor mínimo da compra', 'value' => $coupon->min_value_formatted]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('max_value', ['type' => 'text', 'class' => 'form-control input-price', 'label' => 'Valor máximo da compra', 'value' => $coupon->max_value_formatted]) ?>
				</div>
                <?php /*<div class="form-group">
					<?= $this->Form->control('only_individual_use', ['class' => '', 'label' => 'Apenas uso individual (não pode ser usado com outros cupons)']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('exclude_promotional_items', ['class' => '', 'label' => 'Excluir itens em oferta']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('products_ids',
						['type' => 'select', 'class' => 'form-control input-select2', 'options' => $products, 'label' => 'Produtos',
							'multiple' => true, 'value' => $coupon->products_ids_array]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('excluded_products_ids',
						['type' => 'select', 'class' => 'form-control input-select2', 'options' => $products, 'label' => 'Excluir produtos',
							'multiple' => true, 'value' => $coupon->excluded_products_ids_array]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('categories_ids',
						['type' => 'select', 'class' => 'form-control input-select2', 'options' => $categories, 'label' => 'Categorias',
							'multiple' => true, 'value' => $coupon->categories_ids_array]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('excluded_categories_ids',
						['type' => 'select', 'class' => 'form-control input-select2', 'options' => $categories, 'label' => 'Excluir categorias',
							'multiple' => true, 'value' => $coupon->excluded_categories_ids_array]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('restricted_emails_list', ['class' => 'form-control', 'label' => 'Restringir aos e-mails (digite um por linha)']) ?>
				</div> */ ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="limites">
				<div class="form-group">
					<?= $this->Form->control('use_limit', ['class' => 'form-control', 'label' => 'Limite de uso do cupom']) ?>
				</div>
				<?php /*<div class="form-group">
					<?= $this->Form->control('customer_use_limit', ['class' => 'form-control', 'label' => 'Limite de uso por cliente']) ?>
				</div>*/ ?>
			</div>
		</div>

		<?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
		<?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>