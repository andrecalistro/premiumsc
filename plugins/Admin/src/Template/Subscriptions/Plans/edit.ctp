<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css(['Admin.product.css'], ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->script(['Admin.plans/functions.js', 'Admin.product/default.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="page-title">
    <h2>Editar Plano</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($plan, ['type' => 'file', 'id' => 'form-plan']) ?>
        <?= $this->Form->hidden('stay', ['value' => false]) ?>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#data" aria-controls="home" role="tab" data-toggle="tab">Dados</a>
            </li>
            <li role="presentation"><a href="#images" aria-controls="images" role="tab" data-toggle="tab">Imagens</a>
            <li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="data">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                        <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
                    </div>

                    <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                        <?= $this->Form->control('frequency_delivery_id', ['class' => 'form-control', 'label' => 'Frequência de entrega', 'empty' => '-- Selecione --', 'options' => $deliveryFrequencies]) ?>
                    </div>

                    <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                        <?= $this->Form->control('frequency_billing_id', ['class' => 'form-control', 'label' => 'Frequeência de cobrança', 'empty' => '-- Selecione --', 'options' => $billingFrequencies]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('status', ['class' => 'form-control', 'label' => 'Status do produto', 'options' => $statuses]) ?>
                    </div>

                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('price', ['class' => 'form-control input-price', 'label' => 'Preço', 'type' => 'text']) ?>
                    </div>

                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('due_at', ['class' => 'form-control input-date', 'label' => 'Válido até', 'type' => 'text']) ?>
                    </div>
                </div>

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

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('shipping_required', ['type' => 'checkbox', 'value' => 1, 'label' => 'Requer envio']) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('shipping_free', ['type' => 'checkbox', 'value' => 1, 'label' => 'Frete grátis']) ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('description', ['class' => 'form-control input-editor', 'label' => 'Descrição', 'rows' => 8]) ?>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane fade" id="images">

                <label>Imagens</label>

                <div class="row">
                    <?php if (isset($plan->plans_images)): ?>
                        <?php foreach ($plan->plans_images as $key => $image): ?>
                            <div class="col-md-2 <?= $key == 0 ? 'col-md-offset-1' : '' ?>">
                                <div class="form-group">
                                    <?= $this->Html->image($image->thumb_image_link, ['class' => 'thumbnail']) ?>
                                    <p>
                                        <?= $this->Html->link('Padrão', ['action' => 'set-image-main', $image->id, $image->plans_id], ['class' => 'btn btn-primary btn-xs']) ?>
                                        <?= $this->Html->link('Excluir', ['action' => 'delete-image', $image->id, $image->plans_id], ['class' => 'btn btn-danger btn-xs']) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php for ($i = 0; $i < $countImages; $i++): ?>
                        <div class="col-md-2 <?= $i == 0 && $countImages == 5 ? 'col-md-offset-1' : '' ?>">
                            <div class="form-group">
                                <?= $this->Form->control('plans_images..image', ['class' => 'form-control', 'type' => 'file', 'label' => 'Imagem']) ?>
                            </div>
                        </div>
                    <?php endfor; ?>
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
        </div>

        <hr>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <?= $this->Html->link("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Cancelar", ['controller' => 'plans', 'plugin' => 'admin'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
            </div>
            <div class="col-md-6 col-xs-12 text-right">
                <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
                <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar e permanecer', ['type' => 'submit', 'class' => 'btn btn-success btn-sm btn-stay', 'escape' => false]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>