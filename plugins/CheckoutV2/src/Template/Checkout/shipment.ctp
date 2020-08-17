<?php
/**
 * @var App\View\AppView $this
 * @var \CheckoutV2\Model\Entity\CustomersAddress $address
 * @var \CheckoutV2\Model\Entity\Order $order
 */
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.alert.functions.js',
    'CheckoutV2.shipment-checkout.functions.js'
], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <section class="main">

        <div class="checkout-full-block">
            <div class="container">
                <div class="grid">
                    <div class="col-md-6 col-lg-4 offset-lg-1">
                        <div class="order-info-block order-shipping-address">
                            <h4>Endereço de Entrega<a href="#modal-addresses"
                                                      class="change-link popup-with-zoom-anim">Alterar</a></h4>
                            <p>
                                <strong><?= $address->address ?>, <?= $address->number ?> - <?= $address->come
                                    ?></strong>
                                <?= $address->neighborhood ?> - <?= $address->city ?> - <?= $address->state ?><br>
                                CEP: <?= $address->zipcode ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <h3 class="checkout-title">Opções de Entrega</h3>
                        <ul class="selectable-options shipping-options">
                            <?= $content ?>
                        </ul>

                        <h3 class="checkout-title">Resumo do Pedido</h3>
                        <ul class="checkout-overview">
                            <li><a href="#" class="toggle-order-items">Subtotal /
                                    <strong><?= \count($order->orders_products) ?>
                                        itens</strong><span><?= $order->subtotal_format ?></span></a>
                                <ul>
                                    <?php foreach ($order->orders_products as $order_product): ?>
                                        <li>
                                            <span><?= $order_product->name ?></span>
                                            <span><?= $order_product->price_format ?></span>
                                            <span><?= $order_product->quantity ?>x</span>
                                            <span><?= $order_product->price_total_format ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <?php if ($order->discount_format): ?>
                                <li class="coupon-discount">
                                    Descontos <span><?= $order->discount_format ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if ($order->coupon_discount): ?>
                                <li class="coupon-discount">
                                    Cupom de Desconto <span>- <?= $order->coupon_discount_formatted ?></span>
                                </li>
                            <?php endif; ?>
                            <li class="frete shipping-text">
                                Frete
                                <span>--</span>
                            </li>
                            <li class="subtotal total-price" data-subtotal="<?= $order->subtotal ?>">
                                <span><?= $order->total_format ?></span>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="javascript:void(0)" class="btn btn-success btn-lg confirm-shipment">Confirmar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

<?= $this->Form->create('', ['id' => 'form-shipment']) ?>
<?= $this->Form->control('data', ['type' => 'hidden']) ?>
<?= $this->Form->end() ?>

<div id="modal-addresses" class="zoom-anim-dialog modal mfp-hide">
    <h3 class="checkout-title">Selecione o Endereço de Entrega</h3>
    <ul class="selectable-options addresses-options">
        <?php foreach ($addresses as $address): ?>
            <li class="selectable-option">
                <div>
                    <div class="form-group">
                        <input name="address_choose" value="<?= $address->id ?>" id="id_address_<?= $address->id ?>"
                               class="address_choose"
                               type="radio">
                        <label for="id_address_<?= $address->id ?>" class="dark"></label>
                    </div>
                </div>
                <div>
                    <p>
                        <strong><?= $address->address ?>, <?= $address->number ?> - <?= $address->come
                            ?></strong>
                        <?= $address->neighborhood ?> - <?= $address->city ?> - <?= $address->state ?><br>
                        CEP: <?= $address->zipcode ?>
                    </p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="text-right">
        <?= $this->Html->link('Adicionar novo Endereço', [
            'controller' => 'checkout',
            'action' => 'add-address'
        ], [
            'class' => 'btn btn-success'
        ]) ?>
    </div>
</div>