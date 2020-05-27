<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Store $store
 */
?>
<div class="page-title">
    <h2>Configurar Loja</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($store, ['type' => 'file']) ?>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#data" aria-controls="data" role="tab" data-toggle="tab">Dados</a>
            </li>
            <li role="presentation"><a href="#address" aria-controls="address" role="tab" data-toggle="tab">Endereço</a>
            </li>
            <li role="presentation"><a href="#email" aria-controls="email" role="tab" data-toggle="tab">E-mail</a></li>
            <li role="presentation"><a href="#order" aria-controls="order" role="tab" data-toggle="tab">Pedido</a></li>
            <li role="presentation"><a href="#seo" aria-controls="seo" role="tab" data-toggle="tab">SEO</a></li>
            <li role="presentation"><a href="#social" aria-controls="social" role="tab" data-toggle="tab">Social</a>
            </li>
            <li role="presentation"><a href="#integrations" aria-controls="integrations" role="tab" data-toggle="tab">Integrações
                    e Scripts</a></li>
            <li role="presentation"><a href="#products" aria-controls="products" role="tab"
                                       data-toggle="tab">Pedidos</a></li>
            <li role="presentation"><a href="#cache" aria-controls="cache" role="tab" data-toggle="tab">Cache</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome', 'value' => $store->name]) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('document', ['class' => 'form-control', 'label' => 'CNPJ', 'value' => $store->document]) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('telephone', ['class' => 'form-control', 'label' => 'Telefone', 'value' => $store->telephone]) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('cellphone', ['class' => 'form-control', 'label' => 'Celular', 'value' => $store->cellphone]) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('terms_pages_id', ['class' => 'form-control', 'options' => $pages, 'type' => 'select', 'empty' => 'Selecione...', 'label' => 'Página de termos do cadastro', 'value' => $store->terms_pages_id]) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group btn-file">
                            <label>Logo</label>
                            <p class="icon-upload-file <?= !empty($store->logo) ? 'hidden-element' : '' ?>">
                                <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                            </p>
                            <?= $this->Form->control('logo', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false, 'disabled' => !empty($store->logo) ? true : false]) ?>
                            <?= $this->Form->control('logo', ['class' => 'input-text-file', 'type' => 'hidden', 'label' => false, 'div' => false, 'value' => $store->logo, 'disabled' => empty($store->logo) ? true : false]) ?>
                            <?= $this->Html->image(!empty($store->logo) ? $store->thumb_logo_link : 'Admin.icon-upload.png', ['class' => empty($store->logo) ? 'hidden-element img-thumbnail img-upload' : 'img-thumbnail img-upload']) ?>
                            <p class="btn-del-file <?= empty($store->logo) ? 'hidden-element' : '' ?>">
                                <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger btn-sm']) ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group btn-file">
                            <label>Favicon</label>
                            <p class="icon-upload-file <?= !empty($store->favicon) ? 'hidden-element' : '' ?>">
                                <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                            </p>
                            <?= $this->Form->control('favicon', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false, 'disabled' => !empty($store->favicon) ? true : false]) ?>
                            <?= $this->Form->control('favicon', ['class' => 'input-text-file', 'type' => 'hidden', 'label' => false, 'div' => false, 'value' => $store->favicon, 'disabled' => empty($store->favicon) ? true : false]) ?>
                            <?= $this->Html->image(!empty($store->favicon) ? $store->thumb_favicon_link : 'Admin.icon-upload.png', ['class' => empty($store->favicon) ? 'hidden-element img-thumbnail img-upload' : 'img-thumbnail img-upload']) ?>
                            <p class="btn-del-file <?= empty($store->favicon) ? 'hidden-element' : '' ?>">
                                <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger btn-sm']) ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group btn-file">
                            <label>Icone</label>
                            <p class="icon-upload-file <?= !empty($store->icon) ? 'hidden-element' : '' ?>">
                                <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                            </p>
                            <?= $this->Form->control('icon', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false, 'disabled' => !empty($store->icon) ? true : false]) ?>
                            <?= $this->Form->control('icon', ['class' => 'input-text-file', 'type' => 'hidden', 'label' => false, 'div' => false, 'value' => $store->icon, 'disabled' => empty($store->icon) ? true : false]) ?>
                            <?= $this->Html->image(!empty($store->icon) ? $store->thumb_icon_link : 'Admin.icon-upload.png', ['class' => empty($store->icon) ? 'hidden-element img-thumbnail img-upload' : 'img-thumbnail img-upload']) ?>
                            <p class="btn-del-file <?= empty($store->icon) ? 'hidden-element' : '' ?>">
                                <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger btn-sm']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="address">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <?= $this->Form->control('zipcode', ['label' => 'CEP', 'class' => 'form-control input-cep', 'maxlength' => 9, 'value' => $store->zipcode]) ?>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <?= $this->Form->control('address', ['label' => 'Logradouro', 'class' => 'form-control input-address', 'value' => $store->address]) ?>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <?= $this->Form->control('number', ['label' => 'Número', 'class' => 'form-control input-number', 'value' => $store->number]) ?>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <?= $this->Form->control('complement', ['label' => 'Complemento', 'class' => 'form-control', 'value' => $store->complement]) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('neighborhood', ['label' => 'Bairro', 'class' => 'form-control input-neighborhood', 'value' => $store->neighborhood]) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('city', ['label' => 'Cidade', 'class' => 'form-control input-city', 'value' => $store->city]) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('state', ['label' => 'Estado', 'class' => 'form-control input-state', 'value' => $store->state]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="email">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('email_notification', ['class' => 'form-control', 'label' => 'E-mail remetente', 'value' => $store->email_notification]) ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('email_contact', ['class' => 'form-control', 'label' => 'E-mail para contato', 'value' => $store->email_contact]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="order">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('status_new_order', ['class' => 'form-control', 'label' => 'Status de um pedido novo', 'options' => $ordersStatuses, 'value' => $store->status_new_order]) ?>
                    </div>

                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('status_completed_order', ['class' => 'form-control', 'label' => 'Status de um pedido finalizado', 'options' => $ordersStatuses, 'value' => $store->status_completed_order]) ?>
                    </div>

                    <div class="col-md-4 form-group">
                        <?= $this->Form->control('due_days', ['class' => 'form-control', 'label' => 'Qtde de dias pra cancelar um pedido com status novo', 'value' => $store->due_days]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('sender_address', ['class' => 'form-control', 'label' => 'Endereço do remetente', 'value' => $store->sender_address, 'type' => 'textarea']) ?>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="seo">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('seo_title', ['class' => 'form-control', 'label' => 'SEO Título', 'value' => $store->seo_title]) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('seo_description', ['class' => 'form-control', 'label' => 'SEO Descrição', 'type' => 'textarea', 'value' => $store->seo_description]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="social">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('facebook', ['class' => 'form-control', 'label' => 'Facebook', 'value' => $store->facebook]) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('instagram', ['class' => 'form-control', 'label' => 'Instagram', 'value' => $store->instagram]) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= $this->Form->control('twitter', ['class' => 'form-control', 'label' => 'Twitter', 'value' => $store->twitter]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="integrations">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Blog</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <?= $this->Form->control('blog_url', ['type' => 'text', 'class' => 'form-control', 'label' => 'URL Blog', 'value' => $store->blog_url]) ?>
                            </div>
                        </div>

                        <hr>

                        <h4>Analytics</h4>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <?= $this->Form->control('analytics_account_id', ['type' => 'text', 'class' => 'form-control', 'label' => 'ID da Conta do Analytics', 'value' => $store->analytics_account_id]) ?>
                            </div>
                            <div class="col-md-4 form-group">
                                <?= $this->Form->control('analytics_property_id', ['type' => 'text', 'class' => 'form-control', 'label' => 'ID da Propriedade do Analytics', 'value' => $store->analytics_property_id]) ?>
                            </div>
                            <div class="col-md-4 form-group">
                                <?= $this->Form->control('google_analytics_ecommerce_status',
                                    ['type' => 'checkbox', 'value' => 1, 'label' => 'Habilitar Google Analytics para Comércio Eletrônico', 'checked' => $store->google_analytics_ecommerce_status == 1 ? true : false]) ?>
                            </div>
                            <div class="col-md-12">
                                <p>Para o funcionamento do Analytics no painel do Garrula, adicione o usuário
                                    "garrula-analytics@garrula-185214.iam.gserviceaccount.com" à sua conta do Google
                                    Analytics na qual está configurado
                                    este e-commerce.</p>
                            </div>
                            <div class="col-md-6 form-group">
                                <?= $this->Form->control('google_analytics',
                                    ['class' => 'form-control', 'label' => 'Código Google Analytics', 'type' => 'textarea', 'value' => $store->google_analytics]) ?>
                            </div>
                        </div>

                        <hr>

                        <h4>Recaptcha</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <?= $this->Form->control('google_recaptcha_site_key', ['class' => 'form-control', 'label' => 'Site Key Google Recaptcha', 'value' => $store->google_recaptcha_site_key]) ?>
                            </div>
                            <div class="col-md-6 form-group">
                                <?= $this->Form->control('google_recaptcha_secret_key', ['class' => 'form-control', 'label' => 'Secret Key Google Recaptcha', 'value' => $store->google_recaptcha_secret_key]) ?>
                            </div>
                        </div>

                        <hr>

                        <h4>Pixel Facebook</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <?= $this->Form->control('facebook_pixel', ['class' => 'form-control', 'label' => 'Pixel de conversão do Facebook', 'value' => $store->facebook_pixel]) ?>
                            </div>
                        </div>

                        <hr>

                        <h4>Scripts Adicionais</h4>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <?= $this->Form->control('additional_scripts_header',
                                    ['class' => 'form-control', 'label' => 'Scripts Header', 'type' => 'textarea', 'value' => $store->additional_scripts_header]) ?>
                            </div>
                            <div class="col-md-12 form-group">
                                <?= $this->Form->control('additional_scripts_footer',
                                    ['class' => 'form-control', 'label' => 'Scripts Footer', 'type' => 'textarea', 'value' => $store->additional_scripts_footer]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="products">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Escolha qual o status o produto terá quando o pedido tiver o status:</label>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="mar-bottom-20">
                                <thead>
                                <tr>
                                    <th>Status do pedido</th>
                                    <th>Status do produto</th>
                                    <th>Estoque</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($ordersStatuses): ?>
                                    <?php foreach ($ordersStatuses as $key => $orders_status): ?>
                                        <tr>
                                            <td>
                                                <?= $orders_status ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->control('orders_statuses_config[' . $key . '][products_statuses_id]', ['options' => $productsStatuses, 'class' => 'form-control', 'label' => false, 'value' => isset($store->orders_statuses_config->$key) ? $store->orders_statuses_config->$key->products_statuses_id : '']) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->control('orders_statuses_config[' . $key . '][control_stock]', ['options' => $stockControl, 'label' => false, 'class' => 'form-control', 'value' => isset($store->orders_statuses_config->$key) ? $store->orders_statuses_config->$key->control_stock : '']) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="cache">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Configurações de Cache</h4>
                        <a class="btn btn-primary btn-sm"
                           href="<?= $this->Url->build(['controller' => 'stores', 'action' => 'clearCache'], ['fullBase' => true]) ?>">Limpar
                            cache</a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'dashboard'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>