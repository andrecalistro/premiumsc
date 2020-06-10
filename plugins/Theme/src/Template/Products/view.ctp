<?php
/**
 * @var \App\View\AppView $this
 * @var \Theme\Model\Entity\Product $product
 */
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min',
    'CheckoutV2.alert.functions',
    'CheckoutV2.jquery.mask',
    'CheckoutV2.mask.functions',
    'CheckoutV2.shipment.functions.js',
    'CheckoutV2.cart.functions'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a>
                </li>
                <li class="active"><?= $product->name ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product-details">
                    <div class="product-details-img">
                        <div class="tab-content jump">
                            <?php foreach ($product->products_images as $key => $image): ?>
                                <div id="image-<?= $image->id ?>" class="tab-pane <?= $key === 0 ? 'active' : '' ?> large-img-style">
                                    <img src="<?= $image->image_link ?>" alt="">
                                    <div class="img-popup-wrap">
                                        <a class="img-popup" href="<?= $image->image_link ?>"><i
                                                    class="pe-7s-expand1"></i></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="shop-details-tab nav">
                            <?php foreach ($product->products_images as $image): ?>
                                <a class="shop-details-overly" href="#image=<?= $image->id ?>" data-toggle="tab">
                                    <img src="<?= $image->thumb_image_link ?>" alt="">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product-details-content ml-70">
                    <h2><?= $product->name ?></h2>
                    <div class="product-details-price">
                        <span><?= $product->price_format['formatted'] ?> </span>
                        <!--                        <span class="old">R$ 150,00 </span>-->
                    </div>
                    <p><?= $product->resume ?></p>
                    <!--                    <div class="pro-details-list">-->
                    <!--                        <ul>-->
                    <!--                            <li>- 0.5 mm Dail</li>-->
                    <!--                            <li>- Inspired vector icons</li>-->
                    <!--                            <li>- Very modern style  </li>-->
                    <!--                        </ul>-->
                    <!--                    </div>-->
                    <div class="pro-details-size-color">
                        <?php foreach ($product->filters as $filter): ?>
                            <div class="pro-details-size mr-2">
                                <span><?= $filter->filters_group->name ?></span>
                                <div class="pro-details-size-content">
                                    <ul>
                                        <li><a href="javascript:void(0)" readonly="true"><?= $filter->name ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="pro-details-quality">
                        <input type="hidden" id="quantity" name="quantity" value="1"
                               data-quantity-product-id="<?= $product->id ?>">
                        <div class="pro-details-cart btn-hover">
                            <a href="javascript:void(0)" class="btn-add-cart" data-product-id="<?= $product->id ?>">Comprar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="description-review-area pb-90">
    <div class="container">
        <div class="description-review-wrapper">
            <div class="description-review-topbar nav">
                <?php if($product->products_attributes): ?>
                    <a data-toggle="tab" href="#des-details1">Características</a>
                <?php endif; ?>
                <a class="active" data-toggle="tab" href="#des-details2">Descriçao</a>
            </div>
            <div class="tab-content description-review-bottom">
                <div id="des-details2" class="tab-pane active">
                    <div class="product-description-wrapper">
                        <?= $product->description ?>
                    </div>
                </div>
                <?php if($product->products_attributes): ?>
                    <div id="des-details1" class="tab-pane ">
                        <div class="product-anotherinfo-wrapper">
                            <ul>
                                <?php foreach ($product->products_attributes as $products_attribute): ?>
                                    <li><span><?= $products_attribute->attribute->name ?></span> <?= $products_attribute->value ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($product->products_childs)): ?>
    <div class="related-product-area pb-95">
        <div class="container">
            <div class="section-title text-center mb-50">
                <h2>Produtos relacionados</h2>
            </div>
            <div class="row">
                <?php foreach ($product->products_childs as $product_child): ?>
                    <div class="col-xl-3 col-md-6 col-lg-4 col-sm-6">
                        <?= $this->element('Theme.product', ['product' => $product_child]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>