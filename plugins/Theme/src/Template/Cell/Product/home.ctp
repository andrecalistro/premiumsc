<?php
/**
 * @var \Cake\View\View $this
 * @var \Admin\Model\Entity\ProductsPosition $productsPosition ;
 */
?>
<?php if ($positions): ?>
    <div class="product-area pt-50">
        <div class="container">
            <div class="tab-filter-wrap mb-60">
                <div class="product-tab-list-2 nav">
                    <?php foreach ($positions as $key => $position): ?>
                        <a class="<?= $key > 0 ? '' : 'active' ?>" href="#<?= $position['slug'] ?>" data-toggle="tab">
                            <h4><?= $position['title'] ?>  </h4>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="tab-content jump">
                <?php foreach ($positions as $key => $position): ?>
                    <div class="tab-pane <?= $key > 0 ? '' : 'active' ?>" id="<?= $position['slug'] ?>">
                        <div class="row">
                            <?php foreach ($position['products'] as $positionProduct): ?>
                                <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6">
                                    <?= $this->element('Theme.product', ['product' => $positionProduct->product]) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>