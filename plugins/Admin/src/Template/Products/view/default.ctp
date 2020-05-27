<?php
/**
  * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Product $product
  */
?>
<div class="page-title">
    <h2>Produto</h2>
</div>

<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <div class="row">
            <div class="col-md-1 col-xs-12">
                <?= $this->Html->image($product->thumb_main_image, ['class' => 'img-responsive img-thumbnail']) ?>
            </div>
            <div class="col-md-7 col-xs-12">
                <p><strong>Nome</strong></p>
                <?= $product->name ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <p><strong>Código</strong></p>
                <?= $product->code ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-4">
                <p><strong>Categorias</strong></p>
                <?php if(isset($product->categories)): ?>
                    <?php foreach ($product->categories as $category): ?>
                        > <?= $category->title ?><br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <p><strong>Estoque</strong></p>
                <?= $product->stock ?>
            </div>

            <div class="col-md-4">
                <p><strong>Estoque controlado?</strong></p>
                <?= $product->stock_control ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-4">
                <p><strong>Preço Original</strong></p>
                <?= $product->price_format ?>
            </div>

            <div class="col-md-4">
                <p><strong>Preço Promocional</strong></p>
                <?= $product->price_special_format ?>
            </div>

            <div class="col-md-4">
                <p><strong>Exibir preço na listagem?</strong></p>
                <?= $product->show_price ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <?php if(isset($product->products_images)): ?>
                <?php foreach ($product->products_images as $key => $image): ?>
                    <div class="col-md-2 <?= $key == 0 ? 'col-md-offset-1' : '' ?>">
                        <div class="form-group">
                            <?= $this->Html->image($image->thumb_image_link, ['class' => 'img-responsive img-thumbnail']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <hr>

        <div class="form-group">
            <p><strong>Descrição</strong></p>
            <?= $product->description ?>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-2">
                <p><strong>Peso (kg)</strong></p>
                <?= $product->weight_format ?>
            </div>

            <div class="col-md-2">
                <p><strong>Comprimento (cm)</strong></p>
                <?= $product->length_format ?>
            </div>

            <div class="col-md-2">
                <p><strong>Largura (cm)</strong></p>
                <?= $product->width_format ?>
            </div>

            <div class="col-md-2">
                <p><strong>Altura (cm)</strong></p>
                <?= $product->height_format ?>
            </div>

            <div class="col-md-4">
                <p><strong>Frete gratis para este produto</strong></p>
                <?= $product->shipping_free ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-4">
                <p><strong>Posição na vitrine</strong></p>
                <?= $product->positions_id ?>
            </div>

            <div class="col-md-4">
                <p><strong>Produto principal?</strong></p>
                <?= $product->main ?>
            </div>

            <div class="col-md-4">
                <p><strong>Tags</strong></p>
                <?= $product->tags ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-4">
                <p><strong>Url para SEO</strong></p>
                <?= $product->seo_url ?>
            </div>

            <div class="col-md-4">
                <p><strong>Título para SEO</strong></p>
                <?= $product->seo_title ?>
            </div>

            <div class="col-md-4">
                <p><strong>Descrição para SEO</strong></p>
                <?= $product->seo_description ?>
            </div>
        </div>

        <p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
    </div>
</div>
