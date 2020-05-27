<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script(['Checkout.sweetalert2.all.min.js', 'Checkout.alert.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="garrula-checkout garrula-checkout-choose-address">

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

    <section class="container my-5">
        <div class="text-center">
            <h3>Endereço para envio</h3>
        </div>
        <?php foreach ($customersAddresses as $address): ?>
        <div class="col-md-8 m-auto mt-3 bg-cor-3 py-2">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li><?= $address->complete_address ?></li>
                    </ul>
                </div>
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <?= $this->Html->link('Receber nesse endereço', [$address->id, '_name' => 'planShipment'], ['class' => 'btn btn-primary btn-large']) ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="text-center mt-3">
            <?= $this->Html->link('Cadastrar outro endereço', ['controller' => 'checkout', 'action' => 'add-address'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </section>
</div>