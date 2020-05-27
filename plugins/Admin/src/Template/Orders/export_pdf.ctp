<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css('Admin.bootstrap.min.css');
$this->Html->css('Admin.main.css');
$this->Html->css('Admin.styles.css');
?>
<div class="page-title">
    <h2>Detalhes da Venda - Pedido #<?= $order->id ?></h2>
</div>

<div class="content mar-bottom-30" style="width: 800px;">
    <div class="container-fluid pad-bottom-30">
        <h3>Data - <?= $order->created->format("d/m/Y H:i") ?></h3>
        <h3>Cliente</h3>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td>
                        <p style="font-weight: bold;">Nome</p>
                        <?= $order->customer->name ?>
                    </td>
                    <td>
                        <p style="font-weight: bold;">E-mail</p>
                        <?= $order->customer->email ?>
                    </td>
                    <td>
                        <p style="font-weight: bold;">CPF</p>
                        <?= $order->customer->document ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><br></td>
                </tr>
                <tr>
                    <td>
                        <p style="font-weight: bold;">Telefone</p>
                        <?= $order->customer->telephone ?>
                    </td>
                    <td colspan="2">
                        <p style="font-weight: bold;">Celular</p>
                        <?= $order->customer->cellphone ?>
                    </td>
                </tr>
            </table>
        </div>
        <hr>
        <h3>Endereço para entrega</h3>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td>
                        <p style="font-weight: bold;">Endereço</p>
                        <?= $order->address ?>
                    </td>
                    <td>
                        <p style="font-weight: bold;">Número</p>
                        <?= $order->number ?>
                    </td>
                    <td colspan="2">
                        <p style="font-weight: bold;">Complemento</p>
                        <?= $order->complement ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><br></td>
                </tr>
                <tr>
                    <td>
                        <p style="font-weight: bold;">Bairro</p>
                        <?= $order->neighborhood ?>
                    </td>
                    <td>
                        <p style="font-weight: bold;">Cidade</p>
                        <?= $order->city ?>
                    </td>
                    <td>
                        <p style="font-weight: bold;">Estado</p>
                        <?= $order->state ?>
                    </td>
                    <td>
                        <p style="font-weight: bold;">CEP</p>
                        <?= $order->zipcode ?>
                    </td>
                </tr>
            </table>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <p style="font-weight: bold;">Observações</p>
                <?= ($order->notes) ? nl2br($order->notes) : '--' ?>
            </div>
        </div>
        <hr>
        <h3>Produtos</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Produto</th>
                    <th>Qtde.</th>
                    <th>Valor Un.</th>
                    <th>Valor Total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($order->orders_products as $product): ?>
                    <tr>
                        <td>
                            <?php if ($product->orders_products_variations): ?>
                                <?= $product->product->code ?><?= !empty($product->orders_products_variations[0]->variations_sku) ? ' - ' . $product->orders_products_variations[0]->variations_sku : '' ?>
                                <br><?= $product->orders_products_variations[0]->variation->variations_group->name ?>: <?= $product->orders_products_variations[0]->variation->name ?>
                            <?php else: ?>
                                <?= $product->product->code ?>
                            <?php endif; ?>
                        </td>
                        <td><?= $product->name ?></td>
                        <td><?= $product->quantity ?></td>
                        <td><?= $product->price_format ?></td>
                        <td><?= $product->price_total_format ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Frete</strong></td>
                    <td><?= $order->shipping_text ?> <?= $order->shipping_total_format ?></td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><?= $order->total_format ?></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Forma de Pagamento</th>
                        <th>Status da venda</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <?= $this->Html->image($order->payments_method->image_link, ['width' => 30, 'class' => 'pull-left']) ?> <?= $order->payments_method->name ?>
                        </td>
                        <td>
                            <?= $order->orders_status->name ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12 text-center">
                <p><br><br></p>
                <p>Eu <strong><?= $order->customer->name ?></strong> sob o CPF <strong><?= $order->customer->document ?></strong> declaro que recebi todos os produtos do pedido
                    <strong>#<?= $order->id ?></strong> no data __/__/____</p>
                <p><br><br></p>
                <p>________________________________________<br>Assinatura do cliente</p>
            </div>
        </div>
    </div>
</div>

<script>
    window.print();
</script>