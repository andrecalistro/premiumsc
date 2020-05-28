<?php
/**
 * @var \App\View\AppView $this
 */
?>
<section class="main">
    <div class="section-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li><?= $page->name ?></li>
            </ul>
            <h2><?= $page->name ?></h2>
        </div>
    </div>

    <div class="wrapper">
        <div class="product-list-block">
            <div class="container">
                <?= $page->content ?>
            </div>
        </div>
    </div>

</section>
