<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script(['Checkout.sweetalert2.all.min.js', 'Checkout.jquery.mask.js', 'Checkout.alert.functions.js', 'Checkout.mask.functions.js', 'Checkout.customer.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>

<div class="garrula-checkout garrula-checkout-add-address">

    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'carts', 'action' => 'index'], ['fullBase' => true]) ?>">Meu carrinho</a></li>
                <li class="breadcrumb-item"><?= $_pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <?= $this->cell('Checkout.Cart::steps', ['steps' => [1, 2]]); ?>

    <section class="container my-5">
        <div class="text-center">
            <h3><?= $_pageTitle ?></h3>
        </div>

        <?= $this->Form->create($customersAddress) ?>
        <div class="row mt-5">
            <!--Dados cadastrais-->
            <div class="col-md-8 offset-md-2">
                <?= $this->Form->control('description', ['label' => false, 'value' => '', 'type' => 'hidden']) ?>
                <div class="form-group">
                    <?= $this->Form->control('zipcode', ['label' => false, 'placeholder' => 'CEP', 'class' => 'form-control input-zipcode mask-zipcode', 'value' => $this->request->getSession()->read('zipcode')]) ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('address', ['label' => false, 'placeholder' => 'Endereço', 'class' => 'form-control input-address']) ?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('number', ['label' => false, 'placeholder' => 'Número', 'class' => 'form-control input-number']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('complement', ['label' => false, 'placeholder' => 'Complemento', 'class' => 'form-control input-complement']) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('neighborhood', ['label' => false, 'placeholder' => 'Bairro', 'class' => 'form-control input-neighborhood']) ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('city', ['label' => false, 'placeholder' => 'Cidade', 'class' => 'form-control input-city']) ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('state', ['label' => false, 'placeholder' => 'Estado', 'class' => 'form-control input-state']) ?>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-8 offset-md-2">
                <?= $this->Html->link('Voltar', ['controller' => 'checkout', 'action' => 'choose-address'], ['class' => 'btn btn-secondary float-md-left float-lg-left float-xl-left float-xs-none']) ?>
                <?= $this->Form->button('Prosseguir', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-primary float-md-right float-lg-right float-xl-right float-xs-none']) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </section>
</div>

