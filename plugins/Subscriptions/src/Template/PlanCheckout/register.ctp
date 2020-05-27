<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script(['Checkout.sweetalert2.all.min.js', 'Checkout.jquery.mask.js', 'Checkout.alert.functions.js', 'Checkout.mask.functions.js', 'Checkout.customer.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="garrula-checkout garrula-checkout-register">

    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><a
                            href="<?= $this->Url->build(['controller' => 'carts', 'action' => 'index'], ['fullBase' => true]) ?>">Meu
                        carrinho</a></li>
                <li class="breadcrumb-item"><?= $_pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <?= $this->cell('Subscriptions.Cart::steps', ['steps' => [1, 2]]); ?>

    <section class="container my-5">
        <div class="text-center">
            <h3><?= $_pageTitle ?></h3>
        </div>

        <?= $this->Form->create($customer) ?>
        <div class="row mt-5">
            <!--Dados cadastrais-->
            <div class="col-md-10 offset-md-1">
                <?php if ($company_register): ?>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <?= $this->Form->control('customers_types_id', [
                                'type' => 'radio',
                                'options' => $customersTypes,
                                'label' => 'Tipo de conta',
                                'required' => true,
                                'hiddenField' => false,
                                'class' => 'input-type-customer'
                            ]) ?>
                        </div>
                    </div>
                    <?= $this->element('Checkout.Customers/form-block-person') ?>
                    <?= $this->element('Checkout.Customers/form-block-company') ?>
                <?php else: ?>
                    <?= $this->element('Checkout.Customers/form-block-person') ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('birth_date', ['type' => 'text', 'label' => false, 'placeholder' => 'Data de nascimento', 'class' => 'form-control mask-date']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('gender', ['type' => 'radio', 'label' => false, 'placeholder' => 'Sexo', 'options' => $genders, 'class' => 'radio-wrap', 'hiddenField' => false]) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('password', ['label' => false, 'placeholder' => 'Senha', 'class' => 'form-control']) ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <?= $this->Form->control('password_confirm', ['label' => false, 'placeholder' => 'Confirmar Senha', 'type' => 'password', 'class' => 'form-control']) ?>
                        </div>
                    </div>
                </div>

                <h4>Endereço para entrega</h4>
                <?= $this->Form->control('customers_addresses.0.description', ['label' => false, 'value' => '', 'type' => 'hidden']) ?>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('customers_addresses.0.zipcode', ['label' => false, 'placeholder' => 'CEP', 'class' => 'form-control input-zipcode mask-zipcode', 'value' => $this->request->getSession()->read('zipcode')]) ?>
                    </div>
                    <div class="col-md-8 form-group">
                        <?= $this->Form->control('customers_addresses.0.address', ['label' => false, 'placeholder' => 'Endereço', 'class' => 'form-control input-address']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('customers_addresses.0.number', ['label' => false, 'placeholder' => 'Número', 'class' => 'form-control input-number']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('customers_addresses.0.complement', ['label' => false, 'placeholder' => 'Complemento', 'class' => 'form-control input-complement']) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('customers_addresses.0.neighborhood', ['label' => false, 'placeholder' => 'Bairro', 'class' => 'form-control input-neighborhood']) ?>
                    </div>
                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('customers_addresses.0.city', ['label' => false, 'placeholder' => 'Cidade', 'class' => 'form-control input-city']) ?>
                    </div>
                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('customers_addresses.0.state', ['label' => false, 'placeholder' => 'Estado', 'class' => 'form-control input-state']) ?>
                    </div>
                </div>

                <hr>
                <div class="form-check">
                    Ao entrar, você concorda com nossos <a href="<?= $_link_page_terms ?>" style="border-bottom: none;"
                                                           target="_blank">termos
                        de uso, condições e política de privacidade</a>.
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-8 offset-md-2">
                <?= $this->Html->link('Voltar', ['controller' => 'checkout', 'action' => 'identification'], ['class' => 'btn btn-secondary float-md-left float-lg-left float-xl-left float-xs-none']) ?>
                <?= $this->Form->button('Prosseguir', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-primary float-md-right float-lg-right float-xl-right float-xs-none']) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </section>
</div>