<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->script(['Checkout.sweetalert2.all.min.js', 'Checkout.alert.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="bg-branco py-5">
	<div class="container">
		<div class="row text-center">
			<div class="w-50 m-auto">
				<h2 class="my-2"><?= $_pageTitle ?></h2>
			</div>
		</div>
		<div class="row font-lato">
			<div class="w-50 m-auto">
				<?= $this->Form->create($customer, ['class' => 'form-personalizado']) ?>
				<div class="form-group">
					<label>Nova senha</label>
					<?= $this->Form->control('password', ['class' => 'form-control', 'div' => false, 'label' => 'Nova senha:', 'required' => true]) ?>
				</div>
				<div class="form-group">
					<label>Repita a nova senha</label>
					<?= $this->Form->control('password_confirm', ['class' => 'form-control', 'type' => 'password', 'div' => false, 'label' => 'Repita nova senha:', 'required' => true]) ?>
				</div>

				<div class="container text-center mt-3">
					<?= $this->Form->control('Redefinir Senha', ['class' => 'btn btn-padrao-escuro', 'type' => 'submit', 'div' => false, 'label' => false]) ?>
				</div>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</section>

