<?php
/**
 * @var \App\View\AppView $this
 * @var \Subscriptions\Model\Entity\Subscription $subscription
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
?>
<div class="garrula-customer garrula-customer-dashboard">
    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><a
                            href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'dashboard'], ['fullBase' => true]) ?>">Minha
                        conta</a></li>
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
                <div class="title mb-3">
                    Detalhes da assinatura #<?= $subscription->id ?><br>
                    <span>Realizado em <?= $subscription->created->format('d/m/Y') ?></span>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <p><strong>Plano</strong></p>
                        <?= $subscription->plan->name ?>
                    </div>

                    <div class="col-md-3">
                        <p><strong>Valor</strong></p>
                        <?= $subscription->price_format ?>
                    </div>

                    <div class="col-md-3">
                        <p><strong>Valor do frete</strong></p>
                        <?= $subscription->price_shipping_format ?>
                    </div>

                    <div class="col-md-3">
                        <p><strong>Valor total</strong></p>
                        <?= $subscription->price_total_format ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>Frequência de cobrança</strong></p>
                        <?= $subscription->frequency_billing_name ?>
                    </div>

                    <div class="col-md-4">
                        <p><strong>Frequência de envio</strong></p>
                        <?= $subscription->frequency_delivery_name ?>
                    </div>

                    <div class="col-md-4">
                        <p><strong>Status</strong></p>
                        <?= $subscription->status === 1 ? 'Ativo' : 'Cancelado' ?>
                    </div>
                </div>

                <?php if ($subscription->plan->shipping_required): ?>
                    <h4>Endereço para entrega</h4>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p><strong>Endereço</strong></p>
                            <?= $subscription->customers_address->address ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Número</strong></p>
                            <?= $subscription->customers_address->number ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Complemento</strong></p>
                            <?= $subscription->customers_address->complement ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p><strong>Bairro</strong></p>
                            <?= $subscription->customers_address->neighborhood ?>
                        </div>

                        <div class="col-md-3">
                            <p><strong>Cidade</strong></p>
                            <?= $subscription->customers_address->city ?>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Estado</strong></p>
                            <?= $subscription->customers_address->state ?>
                        </div>
                        <div class="col-md-3">
                            <p><strong>CEP</strong></p>
                            <?= $subscription->customers_address->zipcode ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="w-100 mt-4">
                    <?= $this->Form->postLink(
                        'Cancelar Assinatura',
                        ['_name' => 'planCancelSubscription'],
                        [
                            'data' => ['id' => $subscription->id],
                            'method' => 'POST',
                            'class' => 'btn btn-sm btn-secondary',
                            'confirm' => 'Tem certeza que deseja cancelar sua assinatura?'
                        ]
                    ) ?>
                </div>

                <div class="w-100 mt-4">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-payments"
                               role="tab" aria-controls="nav-payments" aria-selected="true">Pagamentos</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-shipments"
                               role="tab" aria-controls="nav-shipments" aria-selected="false">Envios</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-payments" role="tabpanel"
                             aria-labelledby="nav-home-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Cobrança nº</th>
                                        <th>Forma de Pagamento</th>
                                        <th>Status</th>
                                        <th>Valor Total</th>
                                        <th>Data da cobrança</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($subscription->subscription_billings as $billing): ?>
                                        <tr>
                                            <td><?= $billing->id ?></td>
                                            <td><?= $billing->payment_component ?></td>
                                            <td><?= $billing->subscription_billing_status->name ?></td>
                                            <td><?= $subscription->price_total_format ?></td>
                                            <td><?= $billing->date_process ? $billing->date_process->format('d/m/Y') : '' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-shipments" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Envio nº</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($subscription->subscription_shipments as $shipment): ?>
                                        <tr>
                                            <td><?= $shipment->id ?></td>
                                            <td><?= $shipment->subscription_shipping_status->name ?></td>
                                            <td><?= $shipment->created->format("d/m/Y") ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="<?= $this->request->referer() ?>" class="btn btn-primary btn-sm">Voltar</a>
            </div>
        </div>
    </section>
</div>