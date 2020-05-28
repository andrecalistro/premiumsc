<?php
/**
 * @var \Cake\View\View $this
 * @var \Theme\Model\Entity\Product $product
 */
?>
<div class="product-wrap-5 mb-25">
    <div class="product-img">
        <a href="<?= $product->full_link ?>">
            <?= $this->Html->image($product->main_image) ?>
        </a>
<!--        <span class="purple">Novo</span>-->
        <div class="product-action-4">
            <div class="pro-same-action pro-cart">
                <input type="hidden" id="input-product-id" value="<?= $product->id ?>">
                <input type="hidden" name="quantity" data-quantity-product-id="<?= $product->id ?>" value="1">
                <a title="Adicionar ao carrinho"
                   href="javascript:void(0)"
                   class="btn-add-cart-out"
                   data-product-id="<?= $product->id ?>" data-product-link="<?= $product->full_link ?>"
                ><i class="pe-7s-cart"></i></a>
            </div>
            <div class="pro-same-action pro-quickview">
                <a title="Mais detalhes" href="<?= $product->full_link ?>"><i
                            class="pe-7s-look"></i></a>
            </div>
        </div>
    </div>
    <div class="product-content-5 text-center">
        <h3><a href="<?= $product->full_link ?>"><?= $product->name ?></a></h3>
        <div class="price-5">
            <span><?= $product->price_format['formatted'] ?></span>
        </div>
    </div>
</div>