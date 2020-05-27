<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.jquery.mask.js',
    'CheckoutV2.alert.functions.js',
    'CheckoutV2.mask.functions.js',
    'CheckoutV2.customer.functions.js'
], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="main">

    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Início</a></li>
                <li><?= $_pageTitle ?></li>
            </ul>
        </div>
    </div>

    <div class="user-profile">
        <div class="container">
            <div class="grid">
                <?= $this->element('Customers/menu') ?>
                <div class="col-md-8 col-lg-6 align-self-start">
                    <h2 class="profile-section-title"><?= $_pageTitle ?></h2>
                    <?= $this->Form->create($customer) ?>
                    <div class="grid form-grid">
                        <div class="col">
                            <div class="form-group">
                                <?= $this->Form->control('password', ['label' => false, 'placeholder' => 'Senha', 'class' => 'block']) ?>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <?= $this->Form->control('password_confirm', ['label' => false, 'placeholder' => 'Confirmar Senha', 'type' => 'password', 'class' => 'block']) ?>
                            </div>
                        </div>
                        <div class="col text-center">
                            <?= $this->Form->button('Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-lg mt-1']) ?>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>

</section>