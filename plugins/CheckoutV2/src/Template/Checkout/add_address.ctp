<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.jquery.mask.js',
    'CheckoutV2.alert.functions.js',
    'CheckoutV2.mask.functions.js',
    'CheckoutV2.customer.functions.js'
], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="main">

    <div class="checkout-block">
        <?= $this->Form->create('customersAddress') ?>
        <h4 class="divide-block">Endereço de Entrega</h4>
        <?= $this->Form->control('description', ['label' => false, 'value' => '', 'type' => 'hidden']) ?>
        <div class="grid form-grid">
            <div class="col">
                <div class="form-group">
                    <label for="customers-addresses-0-zipcode">CEP</label>
                    <?= $this->Form->control('zipcode', [
                        'label' => false,
                        'placeholder' => 'Ex.: 12345-678',
                        'class' => 'block input-zipcode mask-zipcode',
                        'value' => $this->request->getSession()->read('zipcode')
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-9">
                <div class="form-group">
                    <label for="customers-addresses-0-address">Endereço</label>
                    <?= $this->Form->control('address', [
                        'label' => false,
                        'placeholder' => '',
                        'class' => 'block input-address'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-3">
                <div class="form-group">
                    <label for="customers-addresses-0-number">Número</label>
                    <?= $this->Form->control('number', [
                        'label' => false,
                        'placeholder' => 'Número',
                        'class' => 'block input-number'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-6">
                <div class="form-group">
                    <label for="customers-addresses-0-complement">Complemento</label>
                    <?= $this->Form->control('complement', [
                        'label' => false,
                        'placeholder' => 'Ex.: Bloco 02 - Ap 123',
                        'class' => 'block input-complement'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-6">
                <div class="form-group">
                    <label for="customers-addresses-0-neighborhood">Bairro</label>
                    <?= $this->Form->control('neighborhood', [
                        'label' => false,
                        'placeholder' => 'Bairro',
                        'class' => 'block input-neighborhood'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-6">
                <div class="form-group select">
                    <label for="customers-addresses-0-city">Cidade</label>
                    <?= $this->Form->control('city', [
                        'label' => false,
                        'placeholder' => 'Cidade',
                        'class' => 'block input-city'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-6">
                <div class="form-group select">
                    <label for="customers-addresses-0-state">Estado</label>
                    <?= $this->Form->control('state', [
                        'label' => false,
                        'placeholder' => 'Estado',
                        'class' => 'block input-state'
                    ]) ?>
                </div>
            </div>
            <div class="col text-center">

                <?= $this->Form->button('Salvar Endereço', [
                    'type' => 'submit',
                    'label' => false,
                    'class' => 'btn btn-success btn-lg mt-2'
                ]) ?>

                <p><?= $this->Html->link('Voltar', $this->request->referer()) ?></p>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>

</section>