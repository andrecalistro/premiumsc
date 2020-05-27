<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div id="content" class="pad-top-25 pad-bottom-90">
    <div class="container">
        <div class="tp-breadcrumbs mar-bottom-30">
            <a href="<?= $this->Url->build("/") ?>">Home</a>
            <span class="sep"><i class="fa fa-angle-right"></i></span>
            <?= $product->name ?>
        </div>
        <div class="row space-60 mar-bottom-60">
            <div class="col-md-6 col-sm-6">
                <div class="main-image">
                    <div class="single-product-main-images owl-carousel" id="sync1">
                        <?php if ($product->products_images): ?>
                            <?php foreach ($product->products_images as $image): ?>
                                <div class="image-item">
                                    <?= $this->Html->image($image->image_link, ['class' => 'img-responsive', 'alt' => $product->name]) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="single-product-main-thumbnails owl-carousel" id="sync2">
                        <?php if ($product->products_images): ?>
                            <?php foreach ($product->products_images as $image): ?>
                                <div class="image-item">
                                    <?= $this->Html->image($image->thumb_image_link, ['class' => 'img-responsive', 'alt' => $product->name]) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <ul class="socials-share">
                        <li><a href="#"><i class="fa fa-twitter"></i> Twitter</a></li>
                        <li><a href="#"><i class="fa fa-facebook"></i> Facebook</a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i> Google+</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="product-details">
                    <div class="product-name"><?= $product->name ?></div>
                    <div class="product-subtitle">cód. do produto <?= $product->id ?></div>

                    <!--                    <div class="rate-wrapper">-->
                    <!--                        <div class="product-rate rate-4">-->
                    <!--                            <span class="star-active"></span>-->
                    <!--                        </div>-->
                    <!--                        <span class="text">(16.837)</span>-->
                    <!--                    </div>-->

                    <?php if ($product->price_special): ?>
                        <div class="product-price-old">de
                            <del><?= $product->old_price ?></del>
                            por
                        </div>
                    <?php endif; ?>
                    <div class="product-price"><?= $product->price_format['formatted'] ?></div>
                    <?= ($_store->installment_without_interest > 0 && isset($product->installment_price)) ? "<div class=\"product-total\">{$_store->installment_without_interest}x de {$product->installment_price} sem juros</div>" : "" ?>

                    <div class="mar-bottom-20"></div>

                    <!--                    <div class="row">-->
                    <!--                        <div class="col-md-6 col-sm-6">-->
                    <!--                            <label>Tamanhos:</label>-->
                    <!--                            <select class="mar-bottom-10">-->
                    <!--                                <option>escolha o tamanho</option>-->
                    <!--                            </select>-->
                    <!--                        </div>-->
                    <!--                        <div class="col-md-6 col-sm-6">-->
                    <!--                            <label>COR:</label>-->
                    <!--                            <select class="mar-bottom-10">-->
                    <!--                                <option>selecione a cor</option>-->
                    <!--                            </select>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <p class="mar-bottom-20" style="color: #999999;">Adicionar à Lista de Desejos <i
                                class="fa fa-heart-o"></i></p>


                    <div class="row mar-bottom-20">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="input-group">
                                <div class="input-group-addon">Quantidade</div>
                                <input type="text" class="form-control" placeholder="Quantidade" value="1" name="quantity" data-quantity-product-id="<?= $product->id ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mar-bottom-25">
                        <?= $this->Html->link(__('Comprar'), "", ['class' => 'btn btn-accent btn-add-cart', 'data-product-id' => $product->id]) ?>
                    </div>

                    <div class="shipping">
                        <label>Calcular Frete:</label>
                        <?= $this->Form->create('', ['id' => 'form-simulate-shipping', 'class' => 'coupon-form']) ?>
                            <?= $this->Form->control('zipcode', ['placeholder' => 'Digite seu CEP', 'class' => 'coupon', 'label' => false, 'div' => false, 'required' => true]) ?>
                            <?= $this->Form->button('ok', ['type' => 'submit', 'class' => 'submit button-simulate-shipping', 'data-product-id' => $product->id]) ?>
                        <?= $this->Form->end() ?>
                    </div>

                    <table id="quote-simulate-product">
<!--                        <tr>-->
<!--                            <td><img src="images/sedex.png" alt=""/></td>-->
<!--                            <td>SEDEX<br/>Entrega em até 3 dias <br/>úteis</td>-->
<!--                            <td class="price">R$ 12,88</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td><img src="images/pac.png" alt=""/></td>-->
<!--                            <td>PAC<br/>Entrega em até 7 dias <br/>úteis</td>-->
<!--                            <td class="price">R$ 12,88</td>-->
<!--                        </tr>-->
                    </table>

                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                       aria-expanded="true" aria-controls="collapseOne">
                                        Descrição
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                 aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <?= $product->description ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-title">Clientes como você também viram</div>
        <div class="row equal_height space-60">
            <div class="col-md-3 col-sm-6">
                <div class="product-item">
                    <a href="producto.html">
                        <div class="product-image">
                            <?= $this->Html->image('product1.jpg', ['class' => 'img-responsive full-image']) ?>
                        </div>
                        <div class="product-title">Blusa Nadador Branca</div>
                        <div class="wrapper-product">
                            <div class="product-price-old">de
                                <del>R$199,90</del>
                                por
                            </div>
                            <div class="product-price">R$129,90</div>
                            <div class="product-total">10x de R$459,90 sem juros</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-item">
                    <a href="producto.html">
                        <div class="product-image">
                            <?= $this->Html->image('product1.jpg', ['class' => 'img-responsive full-image']) ?>
                        </div>
                        <div class="product-title">Blusa Nadador Branca</div>
                        <div class="wrapper-product">
                            <div class="product-price-old">de
                                <del>R$199,90</del>
                                por
                            </div>
                            <div class="product-price">R$129,90</div>
                            <div class="product-total">10x de R$459,90 sem juros</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-item">
                    <a href="producto.html">
                        <div class="product-image">
                            <?= $this->Html->image('product1.jpg', ['class' => 'img-responsive full-image']) ?>
                        </div>
                        <div class="product-title">Blusa Nadador Branca</div>
                        <div class="wrapper-product">
                            <div class="product-price-old">de
                                <del>R$199,90</del>
                                por
                            </div>
                            <div class="product-price">R$129,90</div>
                            <div class="product-total">10x de R$459,90 sem juros</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-item">
                    <a href="producto.html">
                        <div class="product-image">
                            <?= $this->Html->image('product1.jpg', ['class' => 'img-responsive full-image']) ?>
                        </div>
                        <div class="product-title">Blusa Nadador Branca</div>
                        <div class="wrapper-product">
                            <div class="product-price-old">de
                                <del>R$199,90</del>
                                por
                            </div>
                            <div class="product-price">R$129,90</div>
                            <div class="product-total">10x de R$459,90 sem juros</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>