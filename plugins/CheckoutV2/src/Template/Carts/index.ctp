<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script(['CheckoutV2.sweetalert2.all.min.js', 'CheckoutV2.jquery.mask.js', 'CheckoutV2.alert.functions.js', 'CheckoutV2.mask.functions.js', 'CheckoutV2.cart.functions.js', 'CheckoutV2.shipment.functions.js', 'CheckoutV2.coupon.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="main">

    <div class="shopping-cart">
        <div class="container">
            <h2 class="page-title">Carrinho de compras</h2>
            <div class="grid">
                <div class="col-md-8">
                    <!-- carrinho -->
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
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td class="product"><a href="<?= $product->full_link ?>" target="_blank">
                                            <img src="<?= $product->thumb_main_image ?>" title="<?= $product->name ?>"
                                                 height="80">
                                        </a></td>
                                    <td class="description"><p>
                                            <span>Código: <?= $product->code ?></span><?= $product->name ?></p></td>
                                    <td class="unit_price"><?= $product->unit_price_format ?></td>
                                    <td class="qtd">
                                        <div class="counter-group">
                                            <button type="button" name="minus" class="minus change-quantity-cart"
                                                    data-quantity="<?= ($product->quantity - 1) ?>"
                                                    data-carts-id="<?= $product->carts_id ?>">-
                                            </button>

                                            <input type="hidden" value="<?= $product->quanity ?>" name="quantity">
                                            <span id="quantity" class="number"><?= $product->quantity ?></span>

                                            <button type="button" name="plus" class="plus change-quantity-cart"
                                                    data-quantity="<?= ($product->quantity + 1) ?>"
                                                    data-carts-id="<?= $product->carts_id ?>">+
                                            </button>

                                            <button type="button" name="remove" class="remove btn-remove-cart"
                                                    data-url="<?= $this->Url->build([
                                                        'controller' => 'carts',
                                                        'action' => 'delete',
                                                        $product->carts_id
                                                    ]) ?>">remover
                                            </button>
                                        </div>
                                    </td>
                                    <td class="total_price"><?= $product->total_price_format ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="shipping">
                        <div class="grid">
                            <div class="col col-lg-7 align-self-center">
                                <form name="shipping-calc">
                                    <div class="form-group inline-button">
                                        <label for="cep" class="inline">Cupom de desconto</label>
                                        <input type="text" name="code" id="code" value="<?= $coupon_code ?>">
                                        <button type="button" class="btn btn-primary btn-form spacing btn-coupon-cart">Ok</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="grid">
                            <div class="col col-lg-7 align-self-center">
                                <form name="shipping-calc">
                                    <div class="form-group inline-button">
                                        <label for="cep" class="inline">Calcular frete e prazos</label>
                                        <input type="tel" pattern="[0-9]{5}-[0-9]{3}" name="zipcode"
                                               class="mask-zipcode" value="<?= $zipcode ?>">
                                        <button type="button" class="btn btn-primary btn-form spacing btn-cart-quote">Ok</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col col-lg-5 align-self-center">
                                <div class="form-group radio-as-block" id="content-shipping-quote">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="cart-overview">
                        <h4>Resumo do Pedido</h4>
                        <ul>
                            <li>Subtotal / <?= $textProducts ?><span><?= $subtotal->subtotal_format ?></span></li>
                            <li class="coupon-discount">
                                Descontos <span><?= $coupon ?></span>
                            </li>
                            <li class="frete shipping-text">
                                Frete <?= $quote_title ?>
                                <span><?= $quote_price ?></span>
                            </li>
                            <li class="subtotal total-price">
                                <span><?= $total ?></span>
                            </li>
                        </ul>
                        <?= $this->Html->link(__("Finalizar Compra"), ['controller' => 'checkout', 'action' => 'identification', 'plugin' => 'CheckoutV2'], ['class' => 'btn btn-success btn-lg']) ?>
                        <p>ou <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Continuar comprando</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>