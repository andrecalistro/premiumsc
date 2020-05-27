<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css(['Admin.product.css'], ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->script(['Admin.catalog/product.functions.js', 'Admin.product/default.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
$uniqid = uniqid();
?>
<div class="page-title">
    <h2>Novo Produto</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($product, ['type' => 'file', 'id' => 'form-product']) ?>
        <?= $this->Form->hidden('stay', ['value' => false]) ?>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#data" aria-controls="home" role="tab" data-toggle="tab">Dados</a>
            </li>
            <li role="presentation"><a href="#content" aria-controls="content" role="tab" data-toggle="tab">Conteúdo</a>
            </li>
            <li role="presentation"><a href="#connections" aria-controls="connections" role="tab" data-toggle="tab">Ligações</a>
            </li>
            <li role="presentation"><a href="#images" aria-controls="images" role="tab" data-toggle="tab">Imagens</a>
            </li>
            <li role="presentation"><a href="#variations" aria-controls="variations" role="tab" data-toggle="tab">Variações</a>
            </li>
            <li role="presentation"><a href="#dimensions" aria-controls="dimensions" role="tab" data-toggle="tab">Dimensões</a>
            </li>
            <li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="data">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('providers_id', ['class' => 'form-control input-select2-filters-dynamic', 'label' => 'Fornecedor', 'options' => $providers, 'empty' => ' ']) ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('categories._ids', ['class' => 'form-control input-select2-filters-dynamic', 'label' => 'Categoria', 'options' => $categories, 'empty' => ' ']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                        <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
                    </div>

                    <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                        <?= $this->Form->control('code', ['class' => 'form-control', 'label' => 'Código', 'value' => $products_id]) ?>
                    </div>

                    <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                        <?= $this->Form->control('ean', ['class' => 'form-control', 'label' => 'EAN']) ?>
                    </div>
                </div>

                <?php if ($filters_groups): ?>
                    <div class="row">
                        <?php foreach ($filters_groups as $filters_group): ?>
                            <div class="col-md-4 form-group">
                                <label><?= $filters_group->name ?></label>
                                <select name="filters_groups[<?= $filters_group->id ?>][]"
                                        class="form-control input-select2-filters-dynamic" multiple="true">
                                    <?php if ($filters_group->filters): ?>
                                        <?php foreach ($filters_group->filters as $filter): ?>
                                            <option value="<?= $filter->name ?>" <?= in_array($filter->id, $product->filters_array) ? 'selected' : '' ?>><?= $filter->name ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif ?>

                <div class="row mar-bottom-15">
                    <?= $this->Form->control('launch_product', ['type' => 'checkbox', 'value' => 1, 'label' => 'Produto original', 'templates' => ['nestingLabel' => '{{hidden}}<div class="col-md-6"><label{{attrs}}>{{input}} {{text}}</label></div>', 'inputContainer' => '{{content}}']]) ?>
                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('products_conditions_id', ['label' => 'Condição do produto', 'empty' => 'Padrão', 'options' => $products_conditions, 'type' => 'select', 'class' => 'form-control']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('status', ['class' => 'form-control', 'label' => 'Status', 'options' => $productsStatuses, 'empty' => '']) ?>
                    </div>

                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('stock', ['class' => 'form-control', 'label' => 'Estoque - Quantidade', 'value' => 1]) ?>
                    </div>

                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('stock_control', ['class' => 'form-control', 'label' => 'Estoque controlado?', 'options' => $stock_controls, 'val' => 1]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('price', ['class' => 'form-control input-price', 'label' => 'Preço Desapegar', 'type' => 'text']) ?>
                    </div>

                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('price_promotional', ['class' => 'form-control input-price', 'label' => 'Preço Loja', 'type' => 'text']) ?>
                    </div>

                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('price_special', ['class' => 'form-control input-price', 'label' => 'Preço Promocional', 'type' => 'text']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('description', ['class' => 'form-control', 'label' => 'Resumo/Descrição']) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('tags', ['class' => 'form-control', 'label' => 'Tags']) ?>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="content">
                <p><?= $this->Html->link('Adicionar aba de conteudo', 'javascript:void(0)', ['class' => 'btn btn-sm btn-default add-tab-content']) ?></p>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="connections">

                <div class="row">
                    <div class="col-md-12 form-group">
                        <?= $this->Form->control('products_childs._ids', ['label' => 'Produto relacionados', 'class' => 'form-control input-select2', 'options' => $products, 'type' => 'select', 'multiple' => true]) ?>
                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane fade" id="images">

                <div class="row">
                    <div class="col-md-12 form-group">
                        <p>O tamanho máximo permitido para as imagens é de 5MB</p>
                    </div>
                </div>

                <div class="row">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="col-md-2 <?= $i == 0 ? 'col-md-offset-1' : '' ?>">
                            <div class="form-group">
                                <?= $this->Form->control('products_images..image', [
                                    'class' => 'form-control',
                                    'type' => 'file',
                                    'label' => 'Imagem'
                                ]) ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane fade" id="dimensions">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <?= $this->Form->control('weight', ['class' => 'form-control input-weight', 'label' => 'Peso (kg)', 'type' => 'text']) ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <?= $this->Form->control('length', ['class' => 'form-control input-length', 'label' => 'Comprimento (cm)', 'type' => 'text']) ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <?= $this->Form->control('width', ['class' => 'form-control input-width', 'label' => 'Largura (cm)', 'type' => 'text']) ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <?= $this->Form->control('height', ['class' => 'form-control input-height', 'label' => 'Altura (cm)', 'type' => 'text']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="seo">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('seo_url', ['class' => 'form-control', 'label' => 'Url']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('seo_title', ['class' => 'form-control', 'label' => 'Título SEO']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('seo_description', ['class' => 'form-control', 'label' => 'Descrição SEO']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('seo_image', ['type' => 'file', 'class' => 'form-control', 'label' => 'Imagem SEO (1200x630px)']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="variations">
                <div class="row">
                    <div class="col-md-2">
                        <ul class="list-variations-groups">
                            <li>
                                <select class="form-control select-variations-groups">
                                    <option value="">-- Escolha uma variação --</option>
                                    <?php foreach ($variationsGroups as $key => $variationsGroup): ?>
                                        <option value="<?= $key ?>"><?= $variationsGroup ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-10 list-variations-content">

                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <?= $this->Html->link("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Cancelar", ['controller' => 'products', 'plugin' => 'admin'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
            </div>
            <div class="col-md-6 col-xs-12 text-right">
                <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
                <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar e permanecer', ['type' => 'submit', 'class' => 'btn btn-success btn-sm btn-stay', 'escape' => false]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
