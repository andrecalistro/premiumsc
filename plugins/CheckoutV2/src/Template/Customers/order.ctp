<?php
/**
 * @var \App\View\AppView $this
 * @var \CheckoutV2\Model\Entity\Order $order
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
?>
<section class="main">

    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Início</a></li>
                <li><a href="<?= $this->Url->build([
                        'controller' => 'customers',
                        'action' => 'orders'
                    ]) ?>">Pedidos</a></li>
                <li><?= $_pageTitle ?></li>
            </ul>
        </div>
    </div>

    <div class="user-profile">
        <div class="container">
            <div class="grid">
                <?= $this->element('Customers/menu') ?>
                <div class="col-md-8 col-lg-8 align-self-start">
                    <h2 class="profile-section-title">Detalhes do Pedido #<?= $order->id ?>
                        <small>Realizado em <?= $order->created->format('d/m/Y') ?></small>
                    </h2>
                    <!-- status steps -->
                    <div class="progress-steps">
                        <ul>
                            <?php if ($order->orders_statuses_id == 6): ?>
                                <li class="complete">Cancelado</li>
                            <?php else: ?>
                                <?php foreach ($statuses as $status): ?>
                                    <li class="<?= ($order->orders_statuses_id >= $status->id) ? 'complete' : ''; ?>"><?= $status->name ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- order content -->
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
                            <?php foreach ($order->orders_products as $orders_product): ?>
                                <tr>
                                    <td class="product">
                                        <img src="<?= $orders_product->image_thumb ?>" title="" width="50"></td>
                                    <td class="description"><p>
                                            <span>Código: <?= $orders_product->product->code ?></span><?= $orders_product->name ?>
                                        </p></td>
                                    <td class="unit_price"><?= $orders_product->price_format ?></td>
                                    <td class="qtd"><?= $orders_product->quantity ?></td>
                                    <td class="total_price"><?= $orders_product->price_total_format ?></td>
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
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="order-overview">
                                    <h4>Resumo do Pedido</h4>
                                    <ul>
                                        <li>Subtotal / <?= \count($order->orders_products) ?>
                                            itens<span><?= $order->subtotal_format ?></span></li>
                                        <li>Descontos<span class="muted">- <?= $order->discount_format ?></span></li>
                                        <li class="frete"><?= $order->shipping_text ?>
                                            <span><?= $order->shipping_total_format ?></span></li>
                                        <li class="subtotal"><span><?= $order->total_format ?></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col text-center">
                                <a href="<?= $this->Url->build([
                                    'controller' => 'customers',
                                    'action' => 'orders'
                                ], ['fullBase' => true]) ?>" class="btn btn-primary">Voltar para Lista de Pedidos</a>
                                <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>" class="link">Voltar para a loja</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>