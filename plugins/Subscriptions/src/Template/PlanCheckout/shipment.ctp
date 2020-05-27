<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script(['Checkout.sweetalert2.all.min.js', 'Checkout.alert.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="garrula-checkout garrula-checkout-shipment">

    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'carts', 'action' => 'index'], ['fullBase' => true]) ?>">Meu carrinho</a></li>
                <li class="breadcrumb-item"><?= $_pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <?= $this->cell('Subscriptions.Cart::steps', ['steps' => [1, 2]]); ?>

    <div class="container">
        <div class="text-center">
            <h3>Forma de envio</h3>
        </div>
        <div class="my-3">
            <ul class="list-unstyled mb-0">
                <li><?= $address->complete_address ?></li>
            </ul>
            <?= $this->Html->link(__('Escolher outro endereço'), ['_name' => 'planChooseAddress'], ['class' => 'btn btn-secondary']) ?>
        </div>
        <section class="my-4">
            <?= $content ?>
        </section>
    </div>
</div>