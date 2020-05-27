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
                <?php if (isset($product->products_images)): ?>
                    <?php foreach ($product->products_images as $key => $image): ?>
                        <div class="col-md-2 <?= $key == 0 ? 'col-md-offset-1' : '' ?>">
                            <div class="form-group">
                                <a href="<?= $image->image_link ?>" data-toggle="lightbox"
                                   data-gallery="product"><?= $this->Html->image($image->thumb_image_link, ['class' => 'img-responsive img-thumbnail']) ?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <p><strong>Fornecedor</strong></p>
                    <?= $product->provider_name ?>
                </div>
                <div class="col-md-3 col-xs-12">
                    <p><strong>Categorias</strong></p>
                    <?php if (isset($product->categories)): ?>
                        <?php foreach ($product->categories as $category): ?>
                            > <?= $category->title ?><br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-4">
                    <p><strong>Nome</strong></p>
                    <?= $product->name ?>
                </div>

                <div class="col-md-4">
                    <p><strong>Código</strong></p>
                    <?= $product->code ?>
                </div>

                <div class="col-md-4">
                    <p><strong>EAN</strong></p>
                    <?= $product->ean ?>
                </div>
            </div>
            <hr>

            <?php if ($filters_groups): ?>
                <div class="row">
                    <?php foreach ($filters_groups as $filters_group): ?>
                        <div class="col-md-4 form-group">
                            <p><strong><?= $filters_group->name ?></label></strong></p>
                            <?= implode(', ', $product->filters_names[$filters_group->slug]['all']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif ?>

            <hr>

            <div class="row">
                <div class="col-md-3">
                    <p><strong>Produto original</strong></p>
                    <?= $product->launch_product == 1 ? 'Sim' : 'Não' ?>
                </div>

                <div class="col-md-3">
                    <p><strong>Condição</strong></p>
                    <?= isset($product->products_condition->name) ? $product->products_condition->name : '' ?>
                </div>

                <div class="col-md-3">
                    <p><strong>Qtde. em estoque</strong></p>
                    <?= $product->stock ?>
                </div>

                <div class="col-md-3">
                    <p><strong>Estoque controlado</strong></p>
                    <?= $product->stock_control == 1 ? 'Sim' : 'Não' ?>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-3">
                    <p><strong>Preço original</strong></p>
                    R$ <?= $product->price_format ?>
                </div>

                <div class="col-md-3">
                    <p><strong>Preço loja</strong></p>
                    R$ <?= $product->price_promotional_format ?>
                </div>

                <div class="col-md-3">
                    <p><strong>Preço promocional</strong></p>
                    R$ <?= $product->price_special_format ?>
                </div>

                <div class="col-md-3">
                    <p><strong>Status</strong></p>
                    <?= $product->products_status->name ?>
                </div>
            </div>
            <hr>

            <div class="form-group">
                <p><strong>Descrição</strong></p>
                <?= $product->description ?>
            </div>
            <hr>

            <div class="form-group">
                <p><strong>Tags</strong></p>
                <?= $product->tags ?>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-3">
                    <p><strong>Peso (kg)</strong></p>
                    <?= $product->weight_format ?>
                </div>

                <div class="col-md-3">
                    <p><strong>Comprimento (cm)</strong></p>
                    <?= $product->length_format ?>
                </div>

                <div class="col-md-3">
                    <p><strong>Largura (cm)</strong></p>
                    <?= $product->width_format ?>
                </div>

                <div class="col-md-3">
                    <p><strong>Altura (cm)</strong></p>
                    <?= $product->height_format ?>
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
<?= $this->element('modal-gallery') ?>