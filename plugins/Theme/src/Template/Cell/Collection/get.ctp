<?php
/**
 * @var \Cake\View\View $this
 * @var \Theme\Model\Entity\Category[] $categories
 */
?>
<?php if($categories): ?>
<div class="collections-area pt-50 pb-70">
    <div class="container">
        <div class="section-title-3 mb-40">
            <h4>Coleçoes</h4>
        </div>
        <div class="collection-wrap">
            <div class="collection-active owl-carousel">
                <?php foreach($categories as $category): ?>
                <div class="collection-product">
                    <div class="collection-img">
                        <a href="<?= $category->full_link ?>">
                            <?= $this->Html->image($category->image_link) ?>
                        </a>
                    </div>
                    <div class="collection-content text-center">
                        <span><?= $category->products_total ?> produtos</span>
                        <h4><a href="<?= $category->full_link ?>"><?= $category->title ?></a></h4>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>