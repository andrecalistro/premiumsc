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

$this->Html->script(['Admin.coupon/coupons.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="page-title">
	<h2>Cadastrar Cupom</h2>
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
					<?= $this->Form->control('type', ['class' => 'form-control', 'options' => $coupon_types, 'label' => 'Tipo de desconto', 'onchange' => 'changeaction()']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('value', ['type' => 'text', 'class' => 'form-control input-price', 'label' => 'Valor do desconto']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('release_date', ['type' => 'text', 'class' => 'form-control input-date-time', 'label' => 'Data/hora de lançamento', 'empty' => true]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('expiration_date', ['type' => 'text', 'class' => 'form-control input-date-time', 'label' => 'Data/hora de expiração', 'empty' => true]) ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="restricoes">
				<div class="form-group">
					<?= $this->Form->control('min_value', ['type' => 'text', 'class' => 'form-control input-price', 'label' => 'Valor mínimo da compra']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('max_value', ['type' => 'text', 'class' => 'form-control input-price', 'label' => 'Valor máximo da compra']) ?>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="limites">
				<div class="form-group">
					<?= $this->Form->control('use_limit', ['class' => 'form-control', 'label' => 'Limite de uso do cupom']) ?>
				</div>
			</div>
		</div>

		<?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm', 'div' => false]) ?>
		<?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= $this->Form->end() ?>
	</div>
</div>