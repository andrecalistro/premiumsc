<?php
/**
 * @var \Cake\View\View $this
 * @var \Theme\Model\Entity\Category[] $categories
 */
?>
<section class="main">
    <div class="section-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li>Produtos</li>
            </ul>
            <div class="separator"></div>
            <h2>Produtos</h2>
        </div>
    </div>

    <div class="wrapper">
        <div class="product-list-block">
            <div class="container">
                <?php foreach ($categories

                               as $category): ?>
                    <a href="<?= $category->full_link ?>">
                        <h2><?= $category->title ?></h2>
                    </a>
                    <ul class="product-list">
                        <?php foreach ($category->products as $product): ?>
                            <li>
                                <?= $this->element('Theme.product', ['product' => $product]) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?= $this->cell(\Cake\Core\Configure::read('Theme') . '.Banner::display', ['slug' => 'linha-profissional-home']) ?>

</section>
