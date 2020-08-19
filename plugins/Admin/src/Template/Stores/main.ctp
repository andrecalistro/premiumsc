<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Store $store
 */
$this->Html->script('store.functions.js', ['fullBase' => true, 'block' => 'scriptBottom']);
?>
<div class="page-title">
    <h2>Configurar Loja</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($main, ['type' => 'file']) ?>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab"
                                                      data-toggle="tab">Geral</a>
            </li>
            <li role="presentation"><a href="#product" aria-controls="product" role="tab" data-toggle="tab">Produto</a>
            </li>
            <li role="presentation"><a href="#customer" aria-controls="customer" role="tab" data-toggle="tab">Cliente</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="general">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>API Token</label>
                            <div class="input-group">
                                <?= $this->Form->control('api_token', ['class' => 'form-control', 'label' => false, 'value' => $main->api_token, 'readonly' => true]) ?>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" data-toggle="tooltip" data-placement="top" title="Gerar Token" onclick="generateApiToken()">
                                        <i class="fa fa-refresh" aria-hidden="false"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade in" id="product">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('template_product_form', ['class' => 'form-control', 'label' => 'Template do formulário do produto', 'value' => $main->template_product_form]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade in" id="customer">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('company_register', ['class' => 'form-control', 'label' => 'Habilitar cadastro de dados de pessoa jurídica', 'options' => $statuses, 'value' => $main->company_register]) ?>
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