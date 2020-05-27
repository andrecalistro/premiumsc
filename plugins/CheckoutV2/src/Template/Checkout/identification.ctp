<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script(['CheckoutV2.sweetalert2.all.min.js', 'CheckoutV2.jquery.mask.js', 'CheckoutV2.alert.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="main garrula-checkout garrula-checkout-identification">

    <div class="checkout-block">
        <h2 class="page-title text-center">Identificação</h2>
        <p>Utilizamos seu e-mail ou CPF de maneira <strong>100% segura</strong> para verificar se você já é nosso
            cliente. Caso ainda não seja, você será direcionado para a página de cadastro.</p>
        <?= $this->Form->create('') ?>
            <div class="form-group inline-button">
                <input type="text" name="login" placeholder="Digite seu e-mail ou CPF" required>
                <button type="submit" name="step" value="login_register" class="btn btn-success btn-form spacing">
                    Continuar
                </button>
            </div>
        <?= $this->Form->end() ?>
    </div>

</section>