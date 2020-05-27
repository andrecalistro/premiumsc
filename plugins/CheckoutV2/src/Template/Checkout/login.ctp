<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script(['CheckoutV2.sweetalert2.all.min.js', 'CheckoutV2.jquery.mask.js', 'CheckoutV2.alert.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="main">

    <div class="checkout-block">
        <h2 class="page-title text-center">Identificação</h2>
        <p>Utilizamos seu e-mail ou CPF de maneira <strong>100% segura</strong> para verificar se você já é nosso cliente. Caso ainda não seja, você será direcionado para a página de cadastro.</p>
        <?= $this->Form->create() ?>
            <div class="form-group valid">
                <input type="text" name="login" value="<?= $login ?>" class="block">
            </div>
            <div class="form-group inline-button mt-1">
                <input type="password" name="password" placeholder="Digite sua senha">
                <button type="submit" name="step" value="login_register" class="btn btn-success btn-form spacing">Continuar</button>
            </div>
            <div class="login_helper_buttons">
                <?= $this->Html->link('Esqueci minha senha', ['controller' => 'customers', 'action' => 'lost-password', 'plugin' => 'CheckoutV2']) ?>&nbsp;
                <?= $this->Html->link('Novo cadastro', ['controller' => 'checkout', 'action' => 'register', 'plugin' => 'CheckoutV2']) ?>
            </div>
        <?= $this->Form->end() ?>
    </div>

</section>