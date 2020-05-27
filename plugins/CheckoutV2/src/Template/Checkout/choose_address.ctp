<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script(['Checkout.sweetalert2.all.min.js', 'Checkout.alert.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="main garrula-checkout garrula-checkout-choose-address">

    <div class="checkout-block">
        <h2 class="page-title text-center">Selecione o Endereço de Entrega</h2>
        <ul class="selectable-options addresses-options">
            <?php foreach ($customersAddresses as $address): ?>
                <li class="selectable-option"
                    data-link="<?= $this->Url->build(['controller' => 'checkout', 'action' => 'shipment', $address->id], ['fullBase' => true]) ?>"
                    onclick="window.location.href=$(this).data('link')">
                    <div>
                        <div class="form-group">
                            <input name="address" value="1" id="id_address_0" type="radio">
                            <label for="id_address_0" class="dark"></label>
                        </div>
                    </div>
                    <div>
                        <p>
                            <?= $address->complete_address ?>
                        </p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="text-right">
            <?= $this->Html->link('Adicionar novo Endereço', ['controller' => 'checkout', 'action' => 'add-address'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</section>

<div class="garrula-checkout garrula-checkout-choose-address">

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

    <?= $this->cell('Checkout.Cart::steps', ['steps' => [1, 2]]); ?>

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
                        <?= $this->Html->link('Receber nesse endereço', ['controller' => 'checkout', 'action' => 'shipment', $address->id], ['class' => 'btn btn-primary btn-large']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="text-center mt-3">
            <?= $this->Html->link('Cadastrar outro endereço', ['controller' => 'checkout', 'action' => 'add-address'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </section>
</div>