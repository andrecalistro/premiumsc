<?php
/**
 * @var \App\View\AppView $this
 */

$this->Html->scriptBlock('
	$(document).on(\'click\', \'#js-check-all\', function () {
		if($(this).is(\':checked\')) {
			$(\'input[name="products_id[]"]\').prop(\'checked\', true);
		} else {
			$(\'input[name="products_id[]"]\').prop(\'checked\', false);
		}
	});
	
	$(document).on(\'click\', \'.btn-options button\', function(e) {
	    $("#form-provider").attr(\'action\', $(this).data(\'action\'));
	    $("#form-provider").submit();
	});
', ['block' => 'scriptBottom']);
$this->Html->script(['catalog/providers.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="page-title">
    <h2>Fornecedor</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid">

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#data" aria-controls="data" role="tab" data-toggle="tab">Informações</a>
            </li>
            <li role="presentation"><a href="#products" aria-controls="products" role="tab"
                                       data-toggle="tab">Produtos</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="data">
                <div class="row mar-bottom-15">
                    <div class="col-md-3">
                        <b>Nome:</b><br><?= $provider->name ?>
                    </div>
                    <div class="col-md-3">
                        <b>Porcentagem do
                            Fornecedor:</b><br><?= $provider->commission ?><?= !empty($provider->commission) ? '%' : '' ?>
                    </div>
                    <div class="col-md-3">
                        <b>Status:</b><br><?= $provider->status == 1 ? 'Ativo' : 'Inativo' ?>
                    </div>
                    <div class="col-md-3">
                        <?= !empty($provider->thumb_image_link) ? $this->Html->image($provider->thumb_image_link, ['class' => 'thumbnail']) : '' ?>
                    </div>
                </div>

                <div class="row mar-bottom-15">
                    <div class="col-md-4">
                        <b>E-mail:</b><br><?= $provider->email ?>
                    </div>
                    <div class="col-md-4">
                        <b>Telefone:</b><br><?= $provider->telephone ?>
                    </div>
                    <div class="col-md-4">
                        <b>CPF ou CNPJ:</b><br><?= $provider->document ?>
                    </div>
                </div>

                <div class="row mar-bottom-15">
                    <div class="col-md-4">
                        <b>Banco:</b><br><?= $provider->bank ?>
                    </div>
                    <div class="col-md-4">
                        <b>Número da agência:</b><br><?= $provider->agency ?>
                    </div>
                    <div class="col-md-4">
                        <b>Número da conta corrente:</b><br><?= $provider->account ?>
                    </div>
                </div>

                <h3>Endereço</h3>
                <hr>
                <div class="row mar-bottom-15">
                    <div class="col-md-3">
                        <b>CEP:</b><br><?= $provider->zipcode ?>
                    </div>

                    <div class="col-md-5">
                        <b>Endereço:</b><br><?= $provider->address ?>
                    </div>

                    <div class="col-md-2">
                        <b>Número:</b><br><?= $provider->number ?>
                    </div>

                    <div class="col-md-2">
                        <b>Complemento:</b><br><?= $provider->complement ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <b>Bairro:</b><br><?= $provider->bairro ?>
                    </div>

                    <div class="col-md-4">
                        <b>Cidade:</b><br><?= $provider->city ?>
                    </div>

                    <div class="col-md-4">
                        <b>Estado:</b><br><?= $provider->state ?>
                    </div>
                </div>

                <div class="row mar-top-30">
                    <div class="col-md-12">
                        <?= $this->Html->link('<i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
                        <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i> Editar', ['controller' => 'providers', 'action' => 'edit', $provider->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                        <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i> Excluir', ['controller' => 'providers', 'action' => 'delete', $provider->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="products">

                <?= $this->Form->create('', ['type' => 'post', 'id' => 'form-provider']) ?>
                <p class="btn-options">
                    <button type="submit" class="btn btn-primary btn-sm" name="submit" value="send-email"
                            data-action="<?= $this->Url->build(['controller' => 'providers', 'action' => 'view', $provider->id], ['fullBase' => true]) ?>">
                        Enviar relatório por e-mail
                    </button>
                </p>

                <div class="table-responsive">
                    <table class="mar-bottom-20">
                        <thead>
                        <tr>
                            <th width="55">
                                <input type="checkbox" id="js-check-all" value="1">
                            </th>
                            <th><?= $this->Paginator->sort('name', 'Produto') ?></th>
                            <th class="hidden-xs"><?= $this->Paginator->sort('code', 'Código') ?></th>
                            <th><?= $this->Paginator->sort('price_special', 'Preço') ?></th>
                            <th><?= $this->Paginator->sort('commission', 'Valor do Fornecedor') ?></th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th><?= $this->Paginator->sort('providers_payment_status', 'Status Fornecedor') ?></th>
                            <th class="hidden-xs"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($provider->products): ?>
                            <?php foreach ($provider->products as $product): ?>
                                <tr>
                                    <td><?= $this->Form->control('products_id[]',
                                            ['type' => 'checkbox', 'templates' => ['inputContainer' => '{{content}}'], 'label' => false, 'value' => $product->id, 'hiddenField' => false]) ?></td>
                                    <td><?= isset($product->products_images[0]->thumb_image_link) ?
                                            $this->Html->image($product->products_images[0]->thumb_image_link, ['align' => 'left', 'width' => '55', 'class' => 'hidden-xs']) : '' ?> <?= $product->name ?>
                                    </td>
                                    <td><?= $product->code ?></td>
                                    <td class="hidden-xs"><?= $product->price_final['formatted'] ?></td>
                                    <td><?= $product->commission['formatted'] ?></td>
                                    <td><?= $product->products_status->name ?></td>
                                    <td class="span-providers-payment-status"><?= ($product->providers_payment_status) ? '<span class="label label-success">Pago</span>' : '<span class="label label-danger">Não pago</span>' ?></td>
                                    <td>
                                        <a class="btn btn-default btn-sm"
                                           href="<?= $this->Url->build(['controller' => 'products', 'action' => 'view', $product->id, 'plugin' => 'admin']) ?>"
                                           title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <?php if ($product->products_status->id == 4): ?>
                                            <?php if ($product->providers_payment_status): ?>
                                                <a class="btn btn-default btn-sm btn-paid-out"
                                                   href="<?= $this->Url->build(['controller' => 'products', 'action' => 'edit-providers-status', $product->id, 'plugin' => 'admin'], ['fullBase' => true]) ?>"
                                                   title="Desmarcar produto como pago">
                                                    <i class="fa fa-money" aria-hidden="true"></i>
                                                </a>
                                            <?php else: ?>
                                                <a class="btn btn-success btn-sm btn-paid-out"
                                                   href="<?= $this->Url->build(['controller' => 'products', 'action' => 'edit-providers-status', $product->id, 'plugin' => 'admin'], ['fullBase' => true]) ?>"
                                                   title="Marcar produto como pago">
                                                    <i class="fa fa-money" aria-hidden="true"></i>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    <?= $this->Form->end() ?>
                </div>

                <p><b>Valor Total do Fornecedor: </b><?= 'R$ ' . number_format($commissions['total'], 2, ',', '') ?></p>
                <p><b>Valor Recebido: </b><?= 'R$ ' . number_format($commissions['received'], 2, ',', '') ?></p>
                <p><b>Valor a Receber: </b><?= 'R$ ' . number_format($commissions['toReceive'], 2, ',', '') ?></p>

                <div class="row mar-top-30">
                    <div class="col-md-12">
                        <?= $this->Html->link('<i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>