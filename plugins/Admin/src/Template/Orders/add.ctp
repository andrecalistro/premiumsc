<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->scriptBlock('
	var selected_ids = ' . json_encode($selected_ids) . ';
', ['block' => 'scriptBottom']);
$this->Html->script(['order/add-order.functions.js'], ['block' => 'scriptBottom', 'fullLink' => true]);
?>
<div class="page-title">
    <h2>Nova Venda</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($order) ?>
        <?= $this->Form->control('customers_id', ['type' => 'hidden']) ?>
        <?= $this->Form->control('customers_addresses_id', ['type' => 'hidden']) ?>
        <h4>Dados do cliente</h4>
        <div class="row">
            <div class="col-md-4 col-xs-12 form-group">
                <?= $this->Form->control('name', ['class' => 'form-control input-select2-customers', 'label' => 'Nome completo', 'type' => 'select']) ?>
            </div>
            <div class="col-md-4 col-xs-12 form-group">
                <?= $this->Form->control('email', ['class' => 'form-control', 'label' => 'E-mail']) ?>
            </div>
            <div class="col-md-4 col-xs-12 form-group">
                <?= $this->Form->control('document', ['class' => 'form-control input-cpf', 'label' => 'CPF']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12 form-group">
                <?= $this->Form->control('telephone', ['class' => 'form-control', 'label' => 'Celular']) ?>
            </div>
            <div class="col-md-4 col-xs-12 form-group">
                <?= $this->Form->control('birth_date', ['class' => 'form-control input-date', 'label' => 'Data de nascimento']) ?>
            </div>
        </div>

        <h4>Endereço de entrega</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('zipcode', ['label' => 'CEP', 'class' => 'form-control input-cep', 'maxlength' => 9]) ?>
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <?= $this->Form->control('address', ['label' => 'Logradouro', 'class' => 'form-control input-address']) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <?= $this->Form->control('number', ['label' => 'Número', 'class' => 'form-control input-number']) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <?= $this->Form->control('complement', ['label' => 'Complemento', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('neighborhood', ['label' => 'Bairro', 'class' => 'form-control input-neighborhood']) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('city', ['label' => 'Cidade', 'class' => 'form-control input-city']) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('state', ['label' => 'Estado', 'class' => 'form-control input-state']) ?>
                </div>
            </div>
        </div>

        <h4>Observações</h4>
        <div class="form-group">
            <?= $this->Form->control('notes', ['class' => 'form-control', 'type' => 'textarea', 'label' => false]) ?>
        </div>

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h4>Produtos</h4>
                <div class="input-group">
                    <select name="product" class="form-control input-select2" id="products-ids" tabindex="-1"
                            aria-hidden="true">
                        <?php foreach ($products as $product): ?>
                            <option <?= isset($product->products_images[0]->thumb_image_link) ? 'data-image="' . $product->products_images[0]->thumb_image_link . '"' : '' ?>
                                    value="<?= $product->id ?>"><?= $product->code . ' - ' . $product->name . ' - ' . $product->price_final['formatted'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="input-group-btn">
					    <button class="btn btn-primary js-add-product" type="button">Adicionar Produto</button>
				    </span>
                </div>
                <div class="table-responsive list-products mar-bottom-20 js-products-list">
                    <table>
                        <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Qtde</th>
                            <th>Preço</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($default_products) > 0) :
                            foreach ($default_products as $product): ?>
                                <tr data-product-id="<?= $product->id ?>">
                                    <td><img src="<?= $product->thumb_main_image ?>"
                                             alt=""><?= $product->code . ' - ' . $product->name ?></td>
                                    <td><?= $product->price_final['formatted'] ?></td>
                                    <td>
                                        <input type="hidden" name="products[_ids][]" value="<?= $product->id ?>">
                                        <button type="button" class="btn btn-danger btn-sm js-remove-product"
                                                title="Excluir"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                        endif;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <h4>Status</h4>
                <div class="form-group">
                    <?= $this->Form->control('orders_statuses_id', ['class' => 'form-control', 'options' => $statuses, 'label' => false]) ?>
                </div>
                <h4>Frete</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('shipping_text', ['class' => 'form-control', 'options' => $shipping_methods, 'label' => false]) ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <?= $this->Form->control('shipping_total', ['class' => 'form-control input-price', 'type' => 'text', 'label' => false, 'placeholder' => 'Valor do frete', 'onblur' => 'calcTotal()']) ?>
                    </div>
                </div>
                <h4>Pagamento</h4>
                <div class="form-group">
                    <?= $this->Form->control('payment_method', ['class' => 'form-control', 'options' => $payment_methods, 'label' => false]) ?>
                </div>
                <h4>Valores</h4>
                <div class="table-responsive mar-bottom-20">
                    <table>
                        <tr>
                            <td width="80%"><b>Subtotal dos produtos</b></td>
                            <td id="order_subtotal" width="20%"></td>
                        </tr>
                        <tr>
                            <td width="80%"><b>Frete</b></td>
                            <td id="shipping_total"></td>
                        </tr>
                        <tr>
                            <td><b>Desconto</b></td>
                            <td><?= $this->Form->control('discount', ['class' => 'form-control input-price', 'label' => false, 'type' => 'text', 'onblur' => 'calcTotal()']) ?></td>
                        </tr>
                        <tr>
                            <td><b>Total</b></td>
                            <td id="order_total"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <?= $this->Html->link("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Cancelar", ['controller' => 'orders', 'plugin' => 'admin'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
            </div>
            <div class="col-md-6 col-xs-12 text-right">
                <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>