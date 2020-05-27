<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Customer $customer
 */
?>
<div class="page-title">
    <h2>Cliente - <?= $customer->name ?></h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#data" aria-controls="home" role="tab" data-toggle="tab">Dados</a>
            </li>
            <li role="presentation"><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Compras</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="data">
                <?php if ($company_register): ?>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <h3>Tipo de conta</h3>
                            <p><?= $customer->customers_type->name ?></p>
                        </div>
                    </div>
                    <?php if ($customer->customers_type->id == 1): ?>
                        <?= $this->element('Admin.Customers/view-block-person') ?>
                    <?php else: ?>
                        <?= $this->element('Admin.Customers/view-block-company') ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?= $this->element('Admin.Customers/view-block-person') ?>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <p><strong>Data de nascimento</strong></p>
                        <?php if($customer->birth_date){echo $customer->birth_date->format('d/m/Y'); }  ?>  
                    </div>

                    <div class="col-md-4 form-group">
                        <p><strong>Celular</strong></p>
                        <?= $customer->cellphone ?>
                    </div>

                    <div class="col-md-4 form-group">
                        <p><strong>Status</strong></p>
                        <?= $customer->status == 1 ? 'Ativo' : 'Inativo' ?>
                    </div>
                </div>
                <hr>
                <h3>Endereços</h3>
                <hr>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>CEP</th>
                                <th>Logradouro</th>
                                <th>Número / Complemento</th>
                                <th>Bairro</th>
                                <th>Cidade</th>
                                <th>Estado</th>
                                <th>Descrição</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($customer->customers_addresses): ?>
                                <?php foreach ($customer->customers_addresses as $customers_address): ?>
                                    <tr>
                                        <td><?= $customers_address->zipcode ?></td>
                                        <td><?= $customers_address->address ?></td>
                                        <td><?= $customers_address->number ?>
                                            / <?= $customers_address->complement ?></td>
                                        <td><?= $customers_address->neighborhood ?></td>
                                        <td><?= $customers_address->city ?></td>
                                        <td><?= $customers_address->state ?></td>
                                        <td><?= $customers_address->description ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade in" id="orders">
                <h3>Compras</h3>
                <hr>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Ref.</th>
                                <th>Qtde. Produtos</th>
                                <th>$ Total</th>
                                <th>Metodo de Pagamento</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($customer->orders): ?>
                                <?php foreach ($customer->orders as $order): ?>
                                    <tr>
                                        <td><?= $order->id ?></td>
                                        <td><?= count($order->orders_products) ?></td>
                                        <td><?= $order->total_format ?></td>
                                        <td>
                                            <?php if ($order->payments_method): ?>
                                                <div class="row">
                                                    <div class="col-md-3 col-xs-3">
                                                        <?= $this->Html->image($order->payments_method->thumb_image_link, ['width' => 30]) ?>
                                                    </div>
                                                    <div class="col-md-9 col-xs-9">
                                                        <?= $order->payments_method->name ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $order->created->format("d/m/Y") ?></td>
                                        <td><?= $order->orders_status->name ?></td>
                                        <td>
                                            <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>', ['controller' => 'orders', 'action' => 'view', $order->id], ['escape' => false, 'class' => 'btn btn-sm btn-primary']) ?>
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
        <?= $this->Html->link("Voltar", $referer, ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
</div>