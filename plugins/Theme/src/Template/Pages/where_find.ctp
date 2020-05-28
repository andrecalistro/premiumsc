<?php
/**
 * @var \App\View\AppView $this
 * @var \Theme\Model\Entity\Page $page
 */
?>
<section class="main">
    <div class="section-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li>Onde Encontrar</li>
            </ul>
            <div class="separator"></div>
            <h2>Onde Encontrar</h2>
        </div>
    </div>

    <?= $page->content ?>

</section>
