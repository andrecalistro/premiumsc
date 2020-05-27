<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['store/category.functions.js', 'Checkout.sweetalert2.all.min.js', 'Checkout.alert.functions.js', 'Checkout.cart.functions.js', 'Checkout.wish-list/functions.js?v' . date('YmdHis')], ['fullBase' => true, 'block' => 'scriptBottom']);
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
?>
<div class="garrula-customer garrula-customer-wish-list">

    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><?= $_pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <section class="container">
        <div class="text-center mb-4">
            <h3><?= $_pageTitle ?></h3>
        </div>

        <div class="row">
            <?php if ($products->count() > 0): ?>
                <?php foreach ($products as $wishListProduct): ?>
                    <?= $this->element('Theme.product_home', ['product' => $wishListProduct->product]) ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="row w-100 mb-4 d-flex justify-content-center">Nenhum produto nessa lista</div>
            <?php endif; ?>
            <div class="d-flex justify-content-center w-100">
                <?= $this->element('Customers/pagination') ?>
            </div>
    </section>
</div>