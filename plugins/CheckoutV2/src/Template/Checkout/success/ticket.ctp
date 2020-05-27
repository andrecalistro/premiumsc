<?php
/**
 * @var App\View\AppView $this
 * @var \CheckoutV2\Model\Entity\Order $order
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
if ($link) {
    $this->Html->scriptBlock('
    $(document).ready(function(){
        var win = window.open(\'' . $link . '\', \'_blank\');
        win.focus();
    });
    ', ['block' => 'scriptBottom']);
}
echo $this->element('CheckoutV2.Checkout/ga-ecommerce-tracking');
?>

<section class="main">

    <div class="order-confirmation">
        <div class="container">
            <div class="grid">
                <div class="col-lg-10 offset-lg-1">
                    <h2 class="page-title text-center">Pedido realizado com sucesso!</h2>
                    <p class="order-number">O número de seu pedido é #<?= $order->id ?>
                        <a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'order', $order->id], 'true') ?>" class="btn btn-success">Acompanhar Pedido</a>
                    </p>

                    <div class="cart-wrapper">
                        <table class="cart-table">
                            <thead>
                            <tr>
                                <th class="product">Produto</th>
                                <th class="description">&nbsp;</th>
                                <th class="unit_price">Valor Unitário</th>
                                <th class="qtd">Quantidade</th>
                                <th class="total_price">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($order->orders_products as $product): ?>
                                <tr>
                                    <td class="product">
                                        <?= $this->Html->image($product->image_thumb, ['class' => 'img-responsive', 'width' => 50]) ?>
                                    </td>
                                    <td class="description"><p>
                                            <?php if ($product->orders_products_variations): ?>
                                                <span>Código <?= $product->product->code ?>
                                                    - <?= $product->orders_products_variations[0]->variations_sku ?></span>
                                                <br><?= $product->orders_products_variations[0]->variation->variations_group->name ?>: <?= $product->orders_products_variations[0]->variation->name ?>
                                            <?php else: ?>
                                                <span>Código <?= $product->product->code ?></span>
                                            <?php endif; ?>
                                            <?= $product->name ?></p>
                                    </td>
                                    <td class="unit_price"><?= $product->price_format ?></td>
                                    <td class="qtd"><?= $product->quantity ?></td>
                                    <td class="total_price"><?= $product->price_total_format ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="order-complete-details">
                        <div class="grid">
                            <div class="col-sm-6">
                                <div class="order-info-block order-shipping">
                                    <h4>Endereço de Entrega</h4>
                                    <p>
                                        <strong><?= $order->address ?>, <?= $order->number ?> - <?= $order->come
                                            ?></strong>
                                        <?= $order->neighborhood ?> - <?= $order->city ?> - <?= $order->state ?><br>
                                        CEP: <?= $order->zipcode ?>
                                    </p>
                                </div>
                                <div class="order-info-block order-payment">
                                    <h4>Forma de Pagamento</h4>
                                    <p>
                                        <strong><?= $order->payment_method_text ?></strong>
                                        <?= $order->installments_text ?>
                                    </p>
                                    <p><a href="<?= $order->payment_url ?>" target="_blank">Imprimir Boleto</a></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="order-overview">
                                    <h4>Resumo do Pedido</h4>
                                    <ul>
                                        <li>Subtotal / <?= \count($order->orders_products) ?> itens<span><?= $order->subtotal_format ?></span></li>
                                        <?php if ($order->discount_format): ?>
                                            <li>Descontos<span class="muted">- <?= $order->discount_format ?></span></li>
                                        <?php endif; ?>
                                        <?php if ($order->coupon_discount): ?>
                                            <li>Cupom de Desconto<span class="muted">- <?= $order->coupon_discount_formatted ?></span></li>
                                        <?php endif; ?>
                                        <li class="frete"><?= $order->shipping_text ?><span><?= $order->shipping_total_format ?></span></li>
                                        <li class="subtotal"><span><?= $order->total_format ?></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col text-center">
                                <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>" class="link">Voltar para a loja</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>