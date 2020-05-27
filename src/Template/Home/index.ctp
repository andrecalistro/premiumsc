<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?= $this->element('slider') ?>

<div id="content">
    
    <div class="pad-top-60">
        <div class="container">
            <div class="row equal_height space-60">
                <?php foreach($products as $product): ?>
                    <div class="col-md-3 col-sm-6">
                        <?= $this->element('product_home', ['product' => $product]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="tp-bg text-center text-white pad-top-120 pad-bottom-120"
         style="background-image: url(<?= $this->Url->build('img/home-bg.jpg', ['fullBase' => true]) ?>);">
        <div class="container">
            <div class="font-25 font-semibold text-uppercase">CONHEÇA NOSSA</div>
            <div class="font-40 font-bold text-uppercase mar-bottom-30">LINHA DE ACESSÓRIOS</div>
            <a class="btn btn-accent" href="#">Conhecer Agora</a>
        </div>
    </div>
    <div class="pad-top-55">
        <div class="container">
            <div class="font-25 font-semibold text-uppercase text-center color-dark">PRODUTOS</div>
            <div class="font-40 font-bold text-uppercase mar-bottom-30 text-center color-dark">MAIS VENDIDOS</div>
            <div class="row equal_height space-60">
                <?php foreach($products as $product): ?>
                    <div class="col-md-3 col-sm-6">
                        <?= $this->element('product_home', ['product' => $product]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row no-space equal_height">
        <div class="col-md-4 col-sm-4 text-center text-white   box-home-categoria">
            <a href="categorias.html">
                <div class="img tp-bg" style="background: url(<?= $this->Url->build('img/home1.jpg', ['fullBase' => true]) ?>) no-repeat center center;"></div>
                <div class="txt">
                    <div class="font-40 font-bold text-uppercase mar-bottom-20">REGATAS</div>
                    <a href="categorias.html" class="btn btn-white-o">VEJA MAIS</a>
                </div>

            </a>
        </div>
        <div class="col-md-4 col-sm-4 text-center text-white  box-home-categoria">
            <a href="categorias.html">
                <div class="img tp-bg" style="background: url(<?= $this->Url->build('img/home3.jpg', ['fullBase' => true]) ?>) no-repeat center center;"></div>
                <div class="txt">
                    <div class="font-40 font-bold text-uppercase mar-bottom-20">MOLETONS</div>
                    <a href="categorias.html" class="btn btn-white-o">VEJA MAIS</a>
                </div>

            </a>
        </div>
        <div class="col-md-4 col-sm-4 text-center text-white  box-home-categoria">
            <a href="categorias.html">
                <div class="img tp-bg" style="background: url(<?= $this->Url->build('img/home3.jpg', ['fullBase' => true]) ?>) no-repeat center center;"></div>
                <div class="txt">
                    <div class="font-40 font-bold text-uppercase mar-bottom-20">BERMUDAS</div>
                    <a href="categorias.html" class="btn btn-white-o">VEJA MAIS</a>
                </div>

            </a>
        </div>
    </div>

</div>
