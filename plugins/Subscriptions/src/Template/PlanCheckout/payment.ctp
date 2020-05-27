<?php
/**
 * @var App\View\AppView $this
 * @var \Subscriptions\Model\Entity\Plan $plan
 * @var \Checkout\Model\Entity\CustomersAddress $address
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script(['Checkout.sweetalert2.all.min.js', 'Checkout.alert.functions.js', 'Subscriptions.checkout.functions', 'Checkout.jquery.mask.js', 'Checkout.mask.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="garrula-checkout garrula-checkout-payment">
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

    <div class="container my-5 ">
        <div class="text-center">
            <h4><?= $_pageTitle ?></h4>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 text-center" id="payment-methods">

                    <div class="container bg-cor-1 pt-3 pb-2 text-center text-white font-lato">
                        <p>O valor total da sua assinatura é de <span
                                    class="total-order"><?= $totalFormat ?></span></p>
                    </div>

                    <?php if ($payment_methods): ?>
                        <?php foreach ($payment_methods as $payment_method): ?>
                            <div class="form-check form-check-inline text-left my-3">
                                <input type="radio" name="payment" value="<?= $payment_method['code'] ?>"
                                       class="method form-check-input"
                                       data-value="<?= $payment_method['code'] ?>" id="<?= $payment_method['code'] ?>"/>
                                <label class="form-check-label" for="<?= $payment_method['code'] ?>">
                                    <?= $payment_method['label'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h4 class="mt-4">Não há formas de pagamentos disponiveis. Por favor entre em contato com o
                            administrador.</h4>
                    <?php endif; ?>

                    <hr>

                    <div id="payment_method"></div>

                </div>
                <div class="col-md-6">
                    <div class="box-border mb-3">
                        <h4>Endereço de entrega</h4>
                        <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>', ['controller' => 'checkout', 'action' => 'clear-address'], ['class' => 'edit float-right', 'escape' => false]) ?>
                        <p>
                            <?= $address->address ?>, <?= $address->number ?>, <?= $address->complement ?><br/>
                            <?= $address->neighborhood ?> - <?= $address->city ?> - <?= $address->state ?><br/>
                            CEP: <?= $address->zipcode ?></p>
                    </div>

                    <div class="box-border">
                        <h4>Resumo da assinatura</h4>
                        <div class="border-bottom pb-2 mb-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <?= $this->Html->image($plan->thumb_main_image, ['class' => 'img-responsive', 'width' => 50]) ?>
                                </div>
                                <div class="col-md-9 text-right">
                                    <b><?= $plan->name ?></b><br>
                                    <br>
                                    <small><?= $plan->price_format ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom pb-2 mb-2">
                            <div class="col-8">
                                <b>Frequência de cobrança</b>
                            </div>
                            <div class="col-4 text-right">
                                <?= $plan->plan_billing_frequency->name ?>
                            </div>
                        </div>
                        <div class="row border-bottom pb-2 mb-2">
                            <div class="col-8">
                                <b>Frequência de envio</b>
                            </div>
                            <div class="col-4 text-right">
                                <?= $plan->plan_delivery_frequency->name ?>
                            </div>
                        </div>
                        <div class="row border-bottom pb-2 mb-2">
                            <div class="col-8">
                                <b>Frete</b> - <?= $shipment['shipping_text'] ?>
                            </div>
                            <div class="col-4 text-right">
                                <?= $shipment['price_format'] ?>
                            </div>
                        </div>
                        <div class="row total">
                            <div class="col-8">
                                <strong>Total a pagar:</strong>
                            </div>
                            <div class="col-4 text-right">
                                <?= $totalFormat ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>