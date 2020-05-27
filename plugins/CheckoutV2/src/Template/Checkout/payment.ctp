<?php
/**
 * @var App\View\AppView $this
 * @var \CheckoutV2\Model\Entity\Order $order
 */
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.alert.functions.js',
    'CheckoutV2.checkout.functions',
    'CheckoutV2.jquery.mask.js',
    'CheckoutV2.mask.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="main">

    <div class="checkout-full-block">
        <div class="container">
            <div class="grid">
                <div class="col-lg-4 offset-lg-1">
                    <div class="order-info-block order-shipping-address">
                        <h4>Endereço de Entrega
                            <?= $this->Html->link('Alterar', [
                                'controller' => 'checkout',
                                'action' => 'choose-address'
                            ], [
                                'class' => 'change-link'
                            ]) ?></h4>
                        <p>
                            <strong><?= $order->address ?>, <?= $order->number ?> - <?= $order->come
                                ?></strong>
                            <?= $order->neighborhood ?> - <?= $order->city ?> - <?= $order->state ?><br>
                            CEP: <?= $order->zipcode ?>
                        </p>
                    </div>
                    <div class="order-info-block order-shipping-method">
                        <h4>Opção de Entrega
                            <?= $this->Html->link('Alterar', [
                                'controller' => 'checkout',
                                'action' => 'choose-address'
                            ], [
                                'class' => 'change-link'
                            ]) ?></h4>
                        </h4>
                        <p>
                            <strong><?= $order->shipping_total_format ?></strong> - <?= $order->shipping_text ?>
                        </p>
                    </div>
                    <div class="order-info-block order-shipping-method">
                        <h4>Resumo do Pedido
                            <?= $this->Html->link('Voltar para o carrinho', [
                                'controller' => 'carts',
                                'action' => 'index'
                            ], [
                                'class' => 'change-link'
                            ]) ?>
                        </h4>
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
                            <li class="frete"><?= $order->shipping_text ?>
                                <span><?= $order->shipping_total_format ?></span>
                            </li>
                            <li class="subtotal"><span><?= $order->total_format ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="checkout-title">Formas de Pagamento <span class="secure">Compra Segura</span></h3>
                    <ul class="selectable-options payment-options">
                        <li class="active no-margin">
                            <div>
                                <div class="form-group">
                                    <input name="payment" value="<?= $order->payment_method ?>"
                                           id="payment-code" class="select-payment"
                                           checked="checked" type="radio">
                                    <label for="payment-code" class="dark"></label>
                                </div>
                            </div>
                            <div>
                                <?= $this->Html->image('payments/icon-' . $order->payment_method . '.svg', [
                                    'fullBase' => true
                                ]) ?>
                            </div>
                            <div>
                                <?= $payment_method->label ?>
                            </div>
                        </li>
                        <li class="payment" id="payment_method">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</section>