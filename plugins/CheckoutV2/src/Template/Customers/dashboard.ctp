<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['Checkout.sweetalert2.all.min.js', 'Checkout.alert.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
?>
<div class="garrula-customer garrula-customer-dashboard">

    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><?= $_pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <section class="container">
        <div class="text-center mb-4">
            <h3><?= $_pageTitle ?></h3>
        </div>

        <div class="row">
            <div class="col-md-3">
                <?= $this->cell('Checkout.Customer::menu') ?>
            </div>

            <div class="col-md-9">
                <div class="box-border p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <strong><?= $customer->name ?></strong>
                            <?php if ($customer->customers_types_id == 2): ?>
                                <p>CNPJ: <?= $customer->company_document ?> - <?= $customer->email ?></p>
                            <?php else: ?>
                                <p>CPF: <?= $customer->document ?> - <?= $customer->email ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 text-right mt-3">
                            <?= $this->Html->link('Editar', ['controller' => 'customers', 'action' => 'account'], ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-5">
                    <div class="row">
                        <div class="col-6">Ultimos Pedidos</div>
                        <div class="col-6 text-right">
                            <?= $this->Html->link('Ver todos', ['controller' => 'customers', 'action' => 'orders']) ?>
                        </div>
                    </div>
                    <?php if ($orders): ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="bg-cor-3 mt-2 py-2">
                                <div class="row p-2">
                                    <div class="col d-flex align-items-center">
                                        <strong>Pedido #<?= $order->id ?></strong>
                                    </div>
                                    <div class="col">
                                        <strong>Data</strong>
                                        <p><?= $order->created->format('d/m/Y') ?></p>
                                    </div>
                                    <div class="col">
                                        <strong>Total</strong>
                                        <p><?= $order->total_format ?></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <strong>Status</strong>
                                        <p><?= $order->orders_status->name ?></p>
                                    </div>
                                    <div class="col d-flex justify-content-end align-items-center">
                                        <?= $this->Html->link('Ver detalhes', ['controller' => 'customers', 'action' => 'order', $order->id], ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="m-auto">Você ainda não fez nenhuma compra.</p>
                    <?php endif; ?>
                </div>

                <hr>

                <div class="mt-4 mb-5">
                    <div class="row">
                        <div class="col-6">Meus endereços</div>
                        <div class="col-6 text-right">
                            <?= $this->Html->link('Cadastrar endereço', ['controller' => 'customers-addresses', 'action' => 'add']) ?>
                        </div>
                    </div>
                    <?php if ($addresses): ?>
                        <?php foreach ($addresses as $address): ?>
                            <div class="bg-cor-3 mt-2 py-2">
                                <div class="row p-2">
                                    <div class="col-md-8 d-flex align-items-center">
                                        <p><?= $address->complete_address ?></p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <?= $this->Html->link('Editar', ['controller' => 'customers-addresses', 'action' => 'edit', $address->id], ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="m-auto">Nenhum endereço cadastrado.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>