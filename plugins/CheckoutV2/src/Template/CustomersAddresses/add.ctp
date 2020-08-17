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
                <li><a href="<?= $this->Url->build([
                        'controller' => 'customersAddresses',
                        'action' => 'index'
                    ], ['fullBase' => true]) ?>">Endereços</a></li>
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
                    <?= $this->Form->create($customersAddress) ?>
                    <?= $this->Form->control('description', ['type' => 'hidden']) ?>
                    <div class="grid form-grid">
                        <div class="col">
                            <div class="form-group">
                                <label for="zipcode">CEP</label>
                                <?= $this->Form->control('zipcode', [
                                    'label' => false, 'placeholder' => 'Ex.: 12345-678', 'class' => 'block input-zipcode mask-zipcode']) ?>
                            </div>
                        </div>
                        <div class="col col-xs-9">
                            <div class="form-group">
                                <label for="address">Endereço</label>
                                <?= $this->Form->control('address', ['label' => false, 'class' => 'block input-address']) ?>
                            </div>
                        </div>
                        <div class="col col-xs-3">
                            <div class="form-group">
                                <label for="number">Número</label>
                                <?= $this->Form->control('number', ['label' => false, 'class' => 'block input-number']) ?>
                            </div>
                        </div>
                        <div class="col col-xs-6">
                            <div class="form-group">
                                <label for="complement">Complemento</label>
                                <?= $this->Form->control('complement', ['label' => false, 'placeholder' => 'Ex.: Bloco 02 - Ap 123', 'class' => 'block']) ?>
                            </div>
                        </div>
                        <div class="col col-xs-6">
                            <div class="form-group">
                                <label for="neighborhood">Bairro</label>
                                <?= $this->Form->control('neighborhood', ['label' => false, 'class' => 'block input-neighborhood']) ?>
                            </div>
                        </div>
                        <div class="col col-xs-6">
                            <div class="form-group select">
                                <label for="city">Cidade</label>
                                <?= $this->Form->control('city', ['label' => false, 'class' => 'block input-city']) ?>
                            </div>
                        </div>
                        <div class="col col-xs-6">
                            <div class="form-group select">
                                <label for="state">Estado</label>
                                <?= $this->Form->control('state', ['label' => false, 'class' => 'block input-state', 'maxlength' => 2]) ?>
                            </div>
                        </div>
                        <div class="col text-center">
                            <?= $this->Form->button('Salvar alterações', ['type' => 'submit', 'class' => 'btn btn-success btn-lg mt-1']) ?>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>

</section>