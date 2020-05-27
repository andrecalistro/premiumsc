<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Checkout.loja.css', ['fullBase' => true, 'block' => 'cssTop']]);
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
        <?= $this->Form->create(null, ['url' => $login_url]) ?>
        <div class="form-group">
            <?= $this->Form->control('login', [
                'class' => 'block',
                'div' => false,
                'label' => false,
                'placeholder' => 'E-mail ou CPF',
                'required' => true
            ]) ?>
        </div>
        <div class="form-group inline-button mt-1">
            <?= $this->Form->control('password', [
                'div' => false,
                'label' => false,
                'placeholder' => 'Digite sua senha',
                'required' => true
            ]) ?>
            <button type="submit" name="step" value="login_register" class="btn btn-success btn-form spacing">
                Continuar
            </button>
        </div>
        <div class="login_helper_buttons">
            <a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'lost-password'], ['fullBase' => true]) ?>">Esqueci
                minha senha</a>&nbsp;<a href="<?= $register_url ?>">Novo
                cadastro</a>
        </div>
        <?= $this->Form->end() ?>
    </div>

</section>