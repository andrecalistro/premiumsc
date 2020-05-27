<?php
/**
 * @var \App\View\AppView $this
 * @var \CheckoutV2\Model\Entity\Order[] $orders
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
?>
<section class="main">

    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Início</a></li>
                <li><?= $_pageTitle ?></li>
            </ul>
        </div>
    </div>

    <div class="user-profile">
        <div class="container">
            <div class="grid">
                <?= $this->element('CheckoutV2.Customers/menu') ?>
                <div class="col-md-8 col-lg-8 align-self-start">
                    <h2 class="profile-section-title"><?= $_pageTitle ?></h2>
                    <ul class="pedidos">
                        <?php if ($orders): ?>
                            <?php foreach ($orders as $order): ?>
                                <li>
                                    <p>#<?= $order->id ?></p>
                                    <p>
                                        <small>Data</small>
                                        <?= $order->created->format('d/m/Y') ?>
                                    </p>
                                    <p>
                                        <small>Total</small>
                                        <?= $order->total_format ?>
                                    </p>
                                    <p>
                                        <small>Status</small>
                                        <?= $order->orders_status->name ?>
                                    </p>
                                    <p>
                                        <?= $this->Html->link('Ver detalhes', [
                                                'controller' => 'customers', 'action' => 'order', $order->id]) ?>
                                    </p>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><p class="m-auto">Você ainda não fez nenhuma compra.</p></li>
                        <?php endif; ?>
                    </ul>
                    <?= $this->element('Customers/pagination') ?>
                </div>
            </div>
        </div>
    </div>

</section>