<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css(['Admin.product.css'], ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->script(['Admin.catalog/product.functions.js', 'Admin.product/default.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <div class="page-title">
        <h2>Editar Produto</h2>
    </div>
    <div class="content mar-bottom-30">
        <div class="container-fluid pad-bottom-30">
            <?= $this->Form->create($product, ['type' => 'file']) ?>
            <?= $this->Form->hidden('stay', ['value' => false]) ?>
            <?php  echo "<input type='hidden' name='urlRetorno' value='".$retornoComPagina."'>"; ?>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#data" aria-controls="home" role="tab"
                                                          data-toggle="tab">Dados</a>
                </li>
                <li role="presentation"><a href="#content" aria-controls="content" role="tab"
                                           data-toggle="tab">Conteúdo</a>
                </li>
                <li role="presentation"><a href="#connections" aria-controls="connections" role="tab" data-toggle="tab">Ligações</a>
                </li>
                <li role="presentation"><a href="#images" aria-controls="images" role="tab"
                                           data-toggle="tab">Imagens</a>
                </li>
                <li role="presentation"><a href="#attributes" aria-controls="attributes" role="tab" data-toggle="tab">Atributos</a>
                </li>
                <li role="presentation"><a href="#variations" aria-controls="variations" role="tab" data-toggle="tab">Variações</a>
                </li>
                <li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO</a></li>
                <li role="presentation"><a href="#dates" aria-controls="dates" role="tab" data-toggle="tab">Prazos</a>
                </li>
            </ul>

            <div class="tab-content pad-bottom-20">
                <div role="tabpanel" class="tab-pane fade in active" id="data">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
                        </div>

                        <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                            <?= $this->Form->control('code', ['class' => 'form-control', 'label' => 'Código']) ?>
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
                                <?= $this->Form->control('stock_control', ['class' => 'form-control', 'label' => 'Estoque controlado?', 'options' => $stock_controls]) ?>
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
                                <?= $this->Form->control('price', ['class' => 'form-control input-price', 'label' => 'Preço Original', 'type' => 'text', 'value' => $product->price_format]) ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <?= $this->Form->control('price_special', ['class' => 'form-control input-price', 'label' => 'Preço Promocional (opcional)', 'type' => 'text', 'value' => $product->price_special_format]) ?>
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
                                <?= $this->Form->control('weight', ['class' => 'form-control input-weight', 'label' => 'Peso (gramas)', 'type' => 'text', 'placeholder' => 'Formato: 000', 'value' => number_format($product->weight, 3, "", "")]) ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <?= $this->Form->control('length', ['class' => 'form-control input-length', 'label' => 'Comprimento (cm)', 'type' => 'text', 'value' => $product->length_format]) ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <?= $this->Form->control('width', ['class' => 'form-control input-width', 'label' => 'Largura (cm)', 'type' => 'text', 'value' => $product->width_format]) ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <?= $this->Form->control('height', ['class' => 'form-control input-height', 'label' => 'Altura (cm)', 'type' => 'text', 'value' => $product->height_format]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <?= $this->Form->control('condition_product', ['type' => 'checkbox', 'value' => 1, 'label' => 'Produto usado']) ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <?= $this->Form->control('launch_product', ['type' => 'checkbox', 'value' => 1, 'label' => 'Lançamento']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="content">
                    <p><?= $this->Html->link('Adicionar aba de conteudo', 'javascript:void(0)', ['class' => 'btn btn-sm btn-default add-tab-content']) ?></p>

                    <?php if ($product->products_tabs): ?>
                        <?php foreach ($product->products_tabs as $products_tab): ?>
                            <div class="item-content">
                                <input type="hidden" name="products_tabs[<?= $products_tab->id ?>][id]"
                                       value="<?= $products_tab->id ?>">
                                <hr>
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <?= $this->Form->control('products_tabs.' . $products_tab->id . '.name', ['class' => 'form-control', 'label' => 'Nome da aba de conteudo', 'value' => $products_tab->name, 'required']) ?>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <?= $this->Form->control('products_tabs.' . $products_tab->id . '.order_show', ['class' => 'form-control', 'label' => 'Ordem de exibição', 'value' => $products_tab->order_show]) ?>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <?= $this->Form->control('products_tabs.' . $products_tab->id . '.status', ['class' => 'form-control', 'label' => 'Status', 'value' => $products_tab->status, 'options' => [0 => 'Desabilitado', 1 => 'Habilitado']]) ?>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <button class="btn btn-danger remove-tab-content" type="button"
                                                data-products-tabs-id="<?= $products_tab->id ?>"><i class="fa fa-trash"
                                                                                                    aria-hidden="true"></i>
                                            Excluir aba
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
										<textarea name=products_tabs[<?= $products_tab->id ?>][content]
                                                  class="form-control input-editor"
                                                  rows="8"><?= $products_tab->content ?></textarea>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="connections">

                    <div class="row">
                        <div class="col-md-12  form-group">
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

                    <div class="row">
                        <div class="col-md-12 form-group btn-file">
                            <label>Imagem de fundo do produto</label>
                            <p class="icon-upload-file <?= !empty($product->image_background) ? 'hidden-element' : '' ?>">
                                <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                            </p>
                            <?= $this->Form->control('image_background', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false, 'disabled' => !empty($product->image_background) ? true : false]) ?>
                            <?= $this->Html->image(!empty($product->image_background) ? $product->thumb_image_background_link : 'Admin.icon-upload.png', ['class' => empty($product->image_background) ? 'hidden-element img-thumbnail img-upload' : 'img-thumbnail img-upload']) ?>
                            <p class="btn-del-file <?= empty($product->image_background) ? 'hidden-element' : '' ?>">
                                <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger btn-sm']) ?>
                            </p>
                        </div>
                    </div>

                    <label>Imagens do Produto</label>

                    <div class="row">
                        <?php if (isset($product->products_images)): ?>
                            <?php foreach ($product->products_images as $key => $image): ?>
                                <div class="col-md-2 <?= $key == 0 ? 'col-md-offset-1' : '' ?>">
                                    <div class="form-group">
                                        <?= $this->Html->image($image->thumb_image_link, ['class' => 'thumbnail']) ?>
                                        <p>
                                            <?= $this->Html->link('Padrão', ['action' => 'set-image-main', $image->id, $image->products_id], ['class' => 'btn btn-primary btn-xs']) ?>
                                            <?= $this->Html->link('Excluir', ['action' => 'delete-image', $image->id, $image->products_id], ['class' => 'btn btn-danger btn-xs']) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php for ($i = 0; $i < $count_images; $i++): ?>
                            <div class="col-md-2 <?= $i == 0 && $count_images == 5 ? 'col-md-offset-1' : '' ?>">
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
                                        <a href="#" class="btn btn-primary btn-sm add-attribute-item"><i
                                                    class="fa fa-plus"
                                                    aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php if ($product->products_attributes): ?>
                                    <?php foreach ($product->products_attributes as $attribute): ?>
                                        <tr>
                                            <td>
                                                <?= $this->Form->hidden('products_attributes.' . $attribute->id . '.id', ['value' => $attribute->id]) ?>
                                                <?= $this->Form->hidden('products_attributes.' . $attribute->id . '.products_id', ['value' => $attribute->products_id]) ?>
                                                <?= $this->Form->control('products_attributes.' . $attribute->id . '.attributes_id', ['label' => false, 'class' => 'form-control', 'options' => $attributesList, 'type' => 'select', 'value' => $attribute->attributes_id]) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->control('products_attributes.' . $attribute->id . '.value', ['label' => false, 'class' => 'form-control', 'type' => $attribute->attribute->type, 'value' => $attribute->value]) ?>
                                            </td>
                                            <td align="right">
                                                <?php if($attribute->attribute->type != 'text' && ($attribute->value_link)): ?>
                                                    <?= $this->Html->link(
                                                            '<i class="fa fa-eye" aria-hidden="true"></i>',
                                                            $attribute->value_link,
                                                            ['escape' => false, 'class' => 'btn btn-default btn-sm', 'target' => '_blank', 'title' => 'Visualizar']
                                                    ) ?>
                                                <?php endif; ?>
                                                <?= $this->Html->link('<i class="fa fa-trash" aria-hidden="true"></i>', '#', ['escape' => false, 'class' => 'btn btn-danger btn-sm remove-attribute', 'attributes-id' => $attribute->id]) ?>
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
                                <?php if ($product->variations_groups): ?>
                                    <?php $i = 0; ?>
                                    <?php foreach ($product->variations_groups as $variations_group): ?>
                                        <li id="li-variations-groups-<?= $variations_group['id'] ?>"
                                            class="li-variations-groups <?= $i == 0 ? 'active' : '' ?>"
                                            data-variations-groups-id="<?= $variations_group['id'] ?>">
                                            <?= $variations_group['name'] ?> <i class="fa fa-close pull-right"
                                                                                aria-hidden="true"
                                                                                data-variations-groups-id="<?= $variations_group['id'] ?>"
                                                                                data-products-variations-groups-id="<?= $variations_group['id'] ?>"></i>
                                        </li>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <li>
                                    <select class="form-control select-variations-groups">
                                        <option value="">-- Escolha uma variação --</option>
                                        <?php foreach ($variationsGroupsContent as $key => $variationsGroup): ?>
                                            <option value="<?= $key ?>"><?= $variationsGroup ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-10 list-variations-content">
                            <?php if ($product->variations_groups): ?>
                                <?php $i = 0; ?>
                                <?php foreach ($product->variations_groups as $variations_group): ?>
                                    <div class="variation-content" id="variation-content-<?= $variations_group['id'] ?>"
                                         data-id="variation-content-<?= $variations_group['id'] ?>" <?= $i > 0 ? 'style="display: none;"' : '' ?>>
                                        <h3><?= $variations_group['name'] ?></h3>
                                        <div class="table-responsive">
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Estoque</th>
                                                    <th>Código</th>
                                                    <th>Campo Auxiliar</th>
                                                    <th>Imagem</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="5"></td>
                                                    <td align="center">
                                                        <button class="btn btn-sm btn-primary btn-add-variation"
                                                                data-variations-groups-id="<?= $variations_group['id'] ?>"
                                                                type="button">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                <?php foreach ($product->products_variations as $products_variation): ?>
                                                    <?php if ($products_variation->variations_groups_id == $variations_group['id']): ?>
                                                        <tr>
                                                            <input type="hidden"
                                                                   name="products_variations[<?= $products_variation->id ?>][id]"
                                                                   value="<?= $products_variation->id ?>">
                                                            <input type="hidden"
                                                                   name="products_variations[<?= $products_variation->id ?>][variations_groups_id]"
                                                                   value="<?= $variations_group['id'] ?>">
                                                            <td>
                                                                <select name="products_variations[<?= $products_variation->id ?>][variations_id]"
                                                                        class="form-control">
                                                                    <?php foreach ($variations_group['variations'] as $variation): ?>
                                                                        <?php $variation['id'] == $products_variation->variations_id ? $s = 'selected' : $s = '' ?>
                                                                        <option value="<?= $variation['id'] ?>" <?= $s ?>><?= $variation['name'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input name="products_variations[<?= $products_variation->id ?>][stock]"
                                                                       class="form-control" type="text"
                                                                       value="<?= $products_variation->stock ?>">
                                                            </td>
                                                            <td>
                                                                <input name="products_variations[<?= $products_variation->id ?>][sku]"
                                                                       class="form-control" type="text"
                                                                       value="<?= $products_variation->sku ?>">
                                                            </td>
                                                            <td>
                                                                <?php if ($products_variation->variations_group->auxiliary_field_type == 'image'): ?>
                                                                    <?php if ($products_variation->thumb_auxiliary_field_link): ?>
                                                                        <a href="<?= $products_variation->auxiliary_field_link ?>"
                                                                           data-toggle="lightbox"
                                                                           data-gallery="product">
                                                                            <?= $this->Html->image($products_variation->thumb_auxiliary_field_link) ?>
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <input name="products_variations[<?= $products_variation->id ?>][auxiliary_field]"
                                                                               type="file" class="form-control">
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <input name="products_variations[<?= $products_variation->id ?>][auxiliary_field]"
                                                                           class="form-control" type="text"
                                                                           value="<?= $products_variation->auxiliary_field ?>">
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($products_variation->thumb_image_link): ?>
                                                                    <a href="<?= $products_variation->image_link ?>"
                                                                       data-toggle="lightbox"
                                                                       data-gallery="product">
                                                                        <?= $this->Html->image($products_variation->thumb_image_link) ?>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <input name="products_variations[<?= $products_variation->id ?>][image]"
                                                                           type="file" class="form-control">
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                        class="btn btn-danger btn-sm btn-delete-variation"
                                                                        title="Excluir"
                                                                        data-products-variations-id="<?= $products_variation->id ?>">
                                                                    <i class="fa fa-trash"
                                                                       aria-hidden="true"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endif ?>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
<?= $this->element('modal-gallery') ?>