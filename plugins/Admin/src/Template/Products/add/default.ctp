<?php
/**
 * @var \App\View\AppView $this
 */
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
            <li role="presentation"><a href="#attributes" aria-controls="attributes" role="tab" data-toggle="tab">Atributos</a>
            </li>
            <li role="presentation"><a href="#variations" aria-controls="variations" role="tab" data-toggle="tab">Variações</a>
            </li>
            <li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO</a></li>
            <li role="presentation"><a href="#dates" aria-controls="dates" role="tab" data-toggle="tab">Prazos</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="data">
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

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('categories._ids', ['class' => 'form-control', 'empty' => '-- Selecione --', 'options' => $categories, 'label' => 'Categoria']) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('stock', ['class' => 'form-control', 'label' => 'Estoque - Quantidade']) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('stock_control', ['class' => 'form-control', 'label' => 'Estoque controlado?', 'options' => $stock_controls, 'value' => 1]) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <?= $this->Form->control('providers_id', ['class' => 'form-control input-select2-filters-dynamic', 'label' => 'Fornecedor', 'options' => $providers, 'empty' => ' ']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <?= $this->Form->control('price', ['class' => 'form-control input-price', 'label' => 'Preço Original', 'type' => 'text']) ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <?= $this->Form->control('price_special', ['class' => 'form-control input-price', 'label' => 'Preço Promocional (opcional)', 'type' => 'text']) ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <?= $this->Form->control('status', ['class' => 'form-control', 'label' => 'Status do produto', 'options' => $statuses]) ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <?= $this->Form->control('shipping_control', ['class' => 'form-control', 'label' => 'Requer envio?', 'options' => $shipping_control]) ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('resume', ['class' => 'form-control', 'label' => 'Breve resumo do produto']) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('description', ['class' => 'form-control input-editor', 'label' => 'Descrição', 'rows' => 8]) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('video', ['class' => 'form-control', 'label' => 'URL vídeo', 'placeholder' => 'Youtube, vimeo, etc']) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('tags', ['class' => 'form-control', 'label' => 'Tags']) ?>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <?= $this->Form->control('weight', ['class' => 'form-control input-weight', 'label' => 'Peso (gramas)', 'type' => 'text', 'placeholder' => 'Formato: 000']) ?>
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

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('condition_product', ['type' => 'checkbox', 'value' => 1, 'label' => 'Produto usado']) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('launch_product', ['type' => 'checkbox', 'value' => 1, 'label' => 'Lançamento']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="content">
                <p><?= $this->Html->link('Adicionar aba de conteudo', 'javascript:void(0)', ['class' => 'btn btn-sm btn-default add-tab-content']) ?></p>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="connections">

                <div class="row">
                    <div class="col-md-12 form-group">
                        <?= $this->Form->control('filters._ids', ['label' => 'Filtros', 'class' => 'form-control', 'id' => 'input-select2-filters', 'empty' => 'Selecione...', 'options' => $filters, 'type' => 'select', 'multiple' => true]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <?= $this->Form->control('products_childs._ids', ['label' => 'Produto relacionados', 'class' => 'form-control input-select2', 'options' => $products, 'type' => 'select', 'multiple' => true]) ?>
                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane fade" id="images">

                <label>Imagens do Produto</label>

                <div class="row">
                    <?php for ($i = 1; $i < 6; $i++): ?>
                        <div class="col-md-2 <?= $i == 1 ? 'col-md-offset-1' : '' ?>">
                            <div class="form-group">
                                <?= $this->Form->control('products_images..image', ['class' => 'form-control', 'type' => 'file', 'label' => 'Imagem']) ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane fade" id="attributes">

                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Atributo</th>
                                <th>Valor</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <td colspan="3" align="right">
                                    <a href="#" class="btn btn-primary btn-sm add-attribute-item"><i class="fa fa-plus"
                                                                                                     aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php if ($attributes): ?>
                                <?php foreach ($attributes as $attribute): $uniqIdAttribute = uniqid() ?>
                                    <tr>
                                        <td>
                                            <?= $this->Form->control('products_attributes.' . $uniqIdAttribute . '.attributes_id', ['label' => false, 'class' => 'form-control', 'options' => $attributesList, 'type' => 'select', 'value' => $attribute->id]) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->control('products_attributes.' . $uniqIdAttribute . '.value', ['label' => false, 'class' => 'form-control', 'type' => $attribute->type]) ?>
                                        </td>
                                        <td align="right">
                                            <?= $this->Html->link('<i class="fa fa-trash" aria-hidden="true"></i>', '#', ['escape' => false, 'class' => 'btn btn-danger btn-sm', 'onclick' => '$(this).parent().parent().remove()']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
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

            <div role="tabpanel" class="tab-pane fade" id="dates">

                <div class="row">
                    <div class="col-md-4">
                        <?= $this->Form->control('expiration_date', ['class' => 'form-control input-date-time', 'label' => 'Data de expiração', 'type' => 'text']) ?>
                    </div>

                    <div class="col-md-4">
                        <?= $this->Form->control('release_date', ['class' => 'form-control input-date-time', 'label' => 'Data de lançamento', 'type' => 'text']) ?>
                    </div>

                    <div class="col-md-4">
                        <?= $this->Form->control('additional_delivery_time', ['class' => 'form-control input-number', 'label' => 'Prazo adicional para entrega']) ?>
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



