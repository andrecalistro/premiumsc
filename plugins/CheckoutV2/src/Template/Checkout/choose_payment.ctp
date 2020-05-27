<?php
/**
 * @var App\View\AppView $this
 * @var \CheckoutV2\Model\Entity\Order $order
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.alert.functions.js',
    'CheckoutV2.choose-payment.functions.js',
], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="main">

    <div class="checkout-full-block">
        <div class="container">
            <div class="grid">
                <div class="col-md-6 col-lg-4 offset-lg-1">
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
                </div>
                <div class="col-md-6 col-lg-6">
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
                        <li class="frete"><?= $order->shipping_text ?><span><?= $order->shipping_total_format ?></span>
                        </li>
                        <li class="subtotal"><span><?= $order->total_format ?></span></li>
                    </ul>

                    <h3 class="checkout-title">Formas de Pagamento <span class="secure">Compra Segura</span></h3>

                    <?= $this->Form->create('', ['id' => 'choose-payment']) ?>
                    <ul class="selectable-options payment-options">
                        <?php if ($payment_methods): ?>
                            <?php foreach ($payment_methods as $payment_method): ?>
                                <li class="selectable-option">
                                    <div>
                                        <div class="form-group">
                                            <input name="payment" value="<?= $payment_method['code'] ?>"
                                                   id="id_payment_<?= $payment_method['code'] ?>"
                                                   class="select-payment"
                                                   type="radio">
                                            <label for="id_payment_<?= $payment_method['code'] ?>" class="dark"></label>
                                        </div>
                                    </div>
                                    <div>
                                        <?= $this->Html->image('payments/icon-' . $payment_method['code'] . '.svg', [
                                            'fullBase' => true
                                        ]) ?>
                                    </div>
                                    <div>
                                        <?= $payment_method['label'] ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>
                                <h4>Não há formas de pagamentos disponiveis. Por favor entre em contato com o
                                    administrador.</h4>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>

</section>