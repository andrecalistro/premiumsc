<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div id="content" class="pad-top-25 pad-bottom-95">
    <div class="container">
        <div class="tp-breadcrumbs">
            <?= $this->Html->link('Home', "/") ?>
            <span class="sep"><i class="fa fa-angle-right"></i></span>
            Carrinho de Compras
        </div>
        <div class="page-title mar-bottom-20">Carrinho de Compras</div>
        <p class="text-center mar-bottom-85 font-16 font-semibold">Lorem ipsum dolor sit amet, consectetur adipiscing
            elit, sed do eiusmod tempor incididunt ut labore et dolor.</p>
        <div class="table-responsive hidden-sm hidden-xs">
            <table class="cart">
                <thead>
                <tr>
                    <th class="text-left">produto</th>
                    <th></th>
                    <th>quantidade</th>
                    <th>VALOR UNITÁIO</th>
                    <th>subtotal</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $this->Html->image($product->thumb_main_image, ['class' => 'img-responsive table-image', 'alt' => $product->name]) ?></td>
                        <td>
                            <span class="product-name"><?= $product->name ?></span>
                            <span class="sku">cód. do produto <?= $product->id ?></span>
                        </td>
                        <td>
                            <div class="quantity-group clearfix">
                                <button type="button" class="quantity-minus"
                                        onclick="window.location='<?= $this->Url->build(['controller' => 'carts', 'action' => 'decrement', $product->carts_id]) ?>'">
                                    <i class="fa fa-minus"></i></button>
                                <input type="number" step="1" min="1" max="10" value="<?= $product->quantity ?>"
                                       class="input-text qty text"
                                       size="4"/>
                                <button type="button" class="quantity-plus"
                                        onclick="window.location='<?= $this->Url->build(['controller' => 'carts', 'action' => 'increment', $product->carts_id]) ?>'">
                                    <i class="fa fa-plus"></i></button>
                            </div>
                        </td>
                        <td class="price"><?= $product->unit_price_format ?></td>
                        <td class="total-price"><?= $product->total_price_format ?></td>
                        <td>
                            <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'carts', 'action' => 'delete', $product->carts_id], ['class' => 'remove', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="tabela-mobile visible-sm visible-xs pad-bottom-60">
            <?php foreach ($products as $product): ?>
                <div class="produto text-center">
                    <div class="img"><?= $this->Html->image($product->product->thumb_main_image, ['alt' => $product->product->name]) ?></div>
                    <p class="product-name pad-top-15"><?= $product->product->name ?></p>
                    <span class="sku">cód. do produto <?= $product->product->id ?></span>

                    <div class="quantity-group clearfix pad-top-20 pad-bottom-20">
                        <button type="button" class="quantity-minus" onclick="window.location='<?= $this->Url->build(['controller' => 'carts', 'action' => 'decrement', $product->id]) ?>'"><i class="fa fa-minus"></i></button>
                        <input type="number" step="1" min="1" max="10" value="<?= $product->quantity ?>" class="input-text qty text" size="4"/>
                        <button type="button" class="quantity-plus" onclick="window.location='<?= $this->Url->build(['controller' => 'carts', 'action' => 'increment', $product->id]) ?>'"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="price"><span>Valor unitário: </span><?= $product->unit_price_format ?></div>
                    <div class="total-price pad-bottom-15"><span>Subtotal: </span><?= $product->total_price_format ?></div>

                    <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'carts', 'action' => 'delete', $product->id], ['class' => 'remove', 'escape' => false]) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-right mar-bottom-30">
            <a href="<?= $this->Url->build("/") ?>" class="btn btn-grey">Continuar Comprando</a>
        </div>

        <div class="row equal_height equal_height_custom">
            <div class="col-md-6">
                <div class="bg-grey shpping-box equal_height_item">
                    <div class="subtitle">Simular Frete</div>
                    <form class="shipping mar-bottom-20">
                        <input type="text" placeholder="Digite o CEP"/>
                        <input type="submit" value="ok" class="btn btn-grey-2 btn-small"/>
                    </form>
                    <div class="wrapper-box mar-bottom-10"><input id="shipping1" type="radio" name="shipping"/> <label
                                for="shipping1">Frete Grátis - Até 2 dia(s) útil(eis) para a entrega- <strong>R$
                                0,00</strong></label></div>
                    <div class="wrapper-box"><input id="shipping1" type="radio" name="shipping"/> <label
                                for="shipping2">Expresso dia seguinte - Até 1 dia útil para a entrega- <strong>R$
                                29,00</strong></label></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="bg-grey coupon-box equal_height_item">
                    <div class="subtitle">Cupom de Desconto</div>
                    <form>
                        <input type="text" placeholder="Digite o código" class="mar-bottom-10"/>
                        <input type="submit" class="btn btn-grey-2 btn-bold btn-small" value="usar cupom"/>
                    </form>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="bg-accent subtotal-box text-white equal_height_item">
                    <div class="subtitle text-white">Subtotal</div>
                    <div class="subtotal-price mar-bottom-30"><?= $subtotal->subtotal_format ?></div>
                    <a href="#" class="btn btn-white btn-small btn-bold">comprar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box-bottom hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="icon-box">
                    <div class="icon"><?= $this->Html->image('icon1.png', ['fullBase' => true, 'class' => 'img-responsive']) ?></div>
                    <div class="title">Retire na Loja</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="icon-box">
                    <div class="icon"><?= $this->Html->image('icon2.png', ['fullBase' => true, 'class' => 'img-responsive']) ?></div>
                    <div class="title">Enviar via Motoboy</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="icon-box">
                    <div class="icon"><?= $this->Html->image('icon3.png', ['fullBase' => true, 'class' => 'img-responsive']) ?></div>
                    <div class="title">Enviar via Correios</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box-bottom-mobile visible-xs">
    <ul>
        <li>
            <div class="img"><?= $this->Html->image('icon1.png', ['fullBase' => true]) ?></div>

            <div class="title">Retire na Loja</div>
        </li>
        <li>
            <div class="img">
                <?= $this->Html->image('icon2.png', ['fullBase' => true]) ?>
            </div>

            <div class="title">Enviar via Motoboy</div>
        </li>
        <li>
            <div class="img">
                <?= $this->Html->image('icon3.png', ['fullBase' => true]) ?>
            </div>

            <div class="title">Enviar via Correios</div>
        </li>
        <div class="clr"></div>
    </ul>
</div>