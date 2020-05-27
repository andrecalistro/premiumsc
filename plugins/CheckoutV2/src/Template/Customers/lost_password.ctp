<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.alert.functions.js'
], ['block' => 'scriptBottom', 'fullBase' => true]);
$this->Form->setTemplates([
    'inputContainer' => '{{content}}'
]);
?>
<section class="main">

    <div class="checkout-block">
        <h2 class="page-title text-center"><?= $_pageTitle ?></h2>
        <?= $this->Form->create() ?>
        <div class="form-group inline-button mt-1">
            <?= $this->Form->control('login', [
                'label' => false,
                'placeholder' => 'E-mail ou CPF',
                'required' => true
            ]) ?>
            <button type="submit" name="step" value="login_register" class="btn btn-success btn-form spacing">
                Redefinir Senha
            </button>
        </div>
        <?= $this->Form->end() ?>
    </div>

</section>
