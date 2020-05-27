<div class="product-item">
    <a href="<?= $product->link ?>">
        <div class="product-image">
            <?= $this->Html->image($product->thumb_main_image, ['class' => 'img-responsive']) ?>
        </div>
        <div class="product-title"><?= $product->name ?></div>
        <div class="wrapper-product">
            <?php if ($product->price_special): ?>
                <div class="product-price-old">de
                    <del><?= $product->old_price ?></del>
                    por
                </div>
            <?php endif; ?>
            <div class="product-price"><?= $product->price_format['formatted'] ?></div>
            <?= ($_store->installment_without_interest > 0 && isset($product->installment_price)) ? "<div class=\"product-total\">{$_store->installment_without_interest}x de {$product->installment_price} sem juros</div>" : "" ?>
        </div>
    </a>
</div>