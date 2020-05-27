<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['Admin.sales/orders.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <div class="page-title">
        <h2>Detalhes da Venda</h2>
    </div>

    <div class="content mar-bottom-30">
        <div class="container-fluid pad-bottom-30">

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#data" aria-controls="home" role="tab"
                                                          data-toggle="tab">Dados</a>
                </li>
                <li role="presentation"><a href="#history" aria-controls="history" role="tab"
                                           data-toggle="tab">Histórico</a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="data">
                    <h3>Cliente</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Nome</strong></p>
                            <?= $order->customer->name ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>E-mail</strong></p>
                            <?= $order->customer->email ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>CPF</strong></p>
                            <?= $order->customer->document ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Telefone</strong></p>
                            <?= $order->customer->telephone ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Celular</strong></p>
                            <?= $order->customer->cellphone ?>
                        </div>
                    </div>
                    <hr>
                    <h3>Endereço para entrega</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Endereço</strong></p>
                            <?= $order->address ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Número</strong></p>
                            <?= $order->number ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Complemento</strong></p>
                            <?= $order->complement ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <p><strong>Bairro</strong></p>
                            <?= $order->neighborhood ?>
                        </div>

                        <div class="col-md-3">
                            <p><strong>Cidade</strong></p>
                            <?= $order->city ?>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Estado</strong></p>
                            <?= $order->state ?>
                        </div>
                        <div class="col-md-3">
                            <p><strong>CEP</strong></p>
                            <?= $order->zipcode ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Observações</strong></p>
                            <?= ($order->notes) ? nl2br($order->notes) : '--' ?>
                        </div>
                    </div>
                    <hr>
                    <h3>Produtos</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Código</th>
                                <th>Qtde.</th>
                                <th>Valor Un.</th>
                                <th>Valor Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($order->orders_products as $product): ?>
                                <tr>
                                    <td>
                                        <?php if (isset($product->product->thumb_main_image)): ?>
                                            <a href="<?= $product->product->main_image ?>" data-toggle="lightbox"
                                               data-gallery="product"><?= $this->Html->image($product->product->thumb_main_image, ['align' => 'left', 'width' => '55', 'class' => 'hidden-xs']) ?></a>
                                        <?php endif; ?>
                                        <?= $product->name ?>
                                        <?= $this->Html->link('<i class="fa fa-external-link" aria-hidden="true"></i>', ['controller' => 'products', 'action' => 'view', $product->product->id], ['target' => '_blank', 'escape' => false, 'title' => 'Ver detalhes do produto']) ?>
                                    </td>
                                    <td>
                                        <?php if ($product->orders_products_variations): ?>
                                            <?= $product->product->code ?><?= !empty($product->orders_products_variations[0]->variations_sku) ? ' - ' . $product->orders_products_variations[0]->variations_sku : '' ?>
                                            <br><?= $product->orders_products_variations[0]->variation->variations_group->name ?>: <?= $product->orders_products_variations[0]->variation->name ?>
                                        <?php else: ?>
                                            <?= $product->product->code ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $product->quantity ?></td>
                                    <td><?= $product->price_format ?></td>
                                    <td><?= $product->price_total_format ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <h3>Total</h3>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <p><strong>Frete</strong></p>
                            <?= $order->shipping_text ?> <?= $order->shipping_total_format ?>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Total</strong></p>
                            <?= $order->total_format ?>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Forma de Pagamento</strong></p>
                            <?= $this->Html->image($order->payments_method->image_link, ['width' => 30, 'class' => 'pull-left']) ?> <?= $order->payments_method->name ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Status da Venda</strong></p>
                            <span id="order-status-name-<?= $order->id ?>"><?= $order->orders_status->name ?></span>
                            <p><?= $this->Html->link('Alterar Status', 'javascript:void(0)', ['data-toggle' => 'modal', 'data-target' => '#modal-change-status-order']) ?></p>
                        </div>
                    </div>

                    <?php if ($order->shipping_sent_date): ?>
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>O pedido foi enviado em</strong></p>
                                <?= $order->shipping_sent_date->format('d/m/Y à\s H:i') ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div role="tabpanel" class="tab-pane fade in" id="history">
                    <h3>Histórico</h3>
                    <?php if ($order->orders_histories): ?>
                        <?php foreach ($order->orders_histories as $order_history): ?>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <p><strong><?= $order_history->created->format('d/m/Y H:i') ?></strong></p>
                                    <p><strong>Status:</strong> <?= $order_history->orders_status->name ?></p>
                                    <p><strong>Cliente
                                            notificado:</strong> <?= $order_history->notify_customer == 1 ? 'Sim' : 'Não' ?>
                                    </p>
                                    <p><strong>Comentários:</strong> <?= $order_history->comment ?></p>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <p>
                <?= $this->Html->link('<i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar', $this->request->referer(), ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                <?= $this->Html->link('<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Gerar PDF', ['controller' => 'orders', 'action' => 'export-pdf', $order->id], ['class' => 'btn btn-default btn-sm', 'escape' => false, 'target' => '_blank']) ?>
                <?= $this->Html->link('<i class="fa fa-truck" aria-hidden="true"></i> Cadastrar codigo/link de rastreio', '#', ['escape' => false, 'class' => 'btn btn-sm btn-default btn-register-tracking', 'title' => 'Cadastrar codigo/link de rastreio', 'data-orders-id' => $order->id, 'data-orders-status' => $order->orders_status->name]) ?>
            </p>
        </div>
    </div>

    <div class="modal fade" id="modal-change-status-order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <?= $this->Form->create($ordersHistory, ['url' => ['controller' => 'orders', 'action' => 'change-status', $order->id]]) ?>
                <?= $this->Form->hidden('orders_id', ['value' => $order->id]) ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Alterar status da Venda</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <?= $this->Form->control('orders_statuses_id', ['label' => 'Status', 'class' => 'form-control', 'options' => $statuses, 'empty' => 'Selecione...', 'required', 'val' => $order->orders_statuses_id]) ?>
                    </div>
                    <div class="form-group">
                        <label>Notificar o cliente</label>
                        <?= $this->Form->control('notify_customer', ['label' => false, 'options' => [0 => 'Não', 1 => 'Sim'], 'type' => 'radio', 'value' => 0]) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->control('comment', ['label' => 'Comentários', 'type' => 'textarea', 'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-register-tracking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <?= $this->Form->create('') ?>
                <?= $this->Form->hidden('orders_id') ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Cadastrar codigo/link de rastreio do pedido</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <?= $this->Form->control('orders_statuses_id', ['label' => 'Alterar status para', 'class' => 'form-control', 'options' => $statuses, 'empty' => 'Selecione...', 'required', 'val' => 4]) ?>
                    </div>
                    <div class="form-group">
                        <label>Notificar o cliente</label>
                        <?= $this->Form->control('notify_customer', ['label' => false, 'options' => [0 => 'Não', 1 => 'Sim'], 'type' => 'radio', 'value' => 0]) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->control('tracking', ['label' => 'Codigo ou link para rastreio', 'class' => 'form-control', 'required']) ?>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->control('shipping_sent_date', ['label' => 'Data em que o pedido foi enviado', 'class' => 'form-control input-date', 'required', 'placeholder' => 'dd/mm/aaaa']) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
<?= $this->element('modal-gallery') ?>