<?php
/**
 * @var \App\View\AppView $this
 * @var \Theme\Model\Entity\Category $category
 */
$this->Html->script([
    'store/category.functions.js',
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.alert.functions.js',
    'CheckoutV2.cart.functions.js'
], ['fullBase' => true, 'block' => 'scriptBottom']);
$this->Paginator->options(
    ['url' => $paginator_url]
);
?>
<div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a>
                </li>
                <li class="active"><?= $category->title ?> </li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-area pt-95 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-12">
                <?= $this->element('Theme.box-filters') ?>
                <div class="shop-bottom-area">
                    <div class="row">
                        <?php if ($this->Paginator->counter('{{current}}') > 0): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-xl-4 col-md-6 col-lg-4 col-sm-6">
                                    <?= $this->element('Theme.product', ['product' => $product]) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 text-center">
                                <p class="mt-4 mb-5">Não há produtos nessa categoria</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?= $this->element('Theme.pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>

