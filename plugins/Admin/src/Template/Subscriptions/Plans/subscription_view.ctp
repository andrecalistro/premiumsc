<?php
/**
 * @var \App\View\AppView $this
 * @var \Subscriptions\Model\Entity\Subscription $subscription
 */
$this->Html->script('Admin.plans/shipment.functions.js', ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <div class="page-title">
        <h2>Detalhes da assinatura</h2>
    </div>

    <div class="content mar-bottom-30">
        <div class="container-fluid pad-bottom-30">

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#data" aria-controls="home" role="tab"
                                                          data-toggle="tab">Dados</a>
                </li>
                <li role="presentation"><a href="#payments" aria-controls="history" role="tab"
                                           data-toggle="tab">Pagamentos</a>
                <li role="presentation"><a href="#shipments" aria-controls="history" role="tab"
                                           data-toggle="tab">Envios</a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="data">
                    <h3>Cliente</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Nome</strong></p>
                            <?= $subscription->customer->name ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>E-mail</strong></p>
                            <?= $subscription->customer->email ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>CPF</strong></p>
                            <?= $subscription->customer->document ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Telefone</strong></p>
                            <?= $subscription->customer->telephone ?>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Celular</strong></p>
                            <?= $subscription->customer->cellphone ?>
                        </div>
                    </div>
                    <hr>
                    <h3>Endereço para entrega</h3>
                    <div class="row">
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
                    <hr>
                    <div class="row">
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
                    <hr>
                    <h3>Plano</h3>
                    <div class="row">
                        <div class="col-md-3">
                            <p><strong>Nome</strong></p>
                            <?= $subscription->plan->name?>
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
                    <hr>
                    <div class="row">
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
                </div>

                <div role="tabpanel" class="tab-pane fade in" id="payments">
                    <h3>Pagamentos</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Forma de Pagamento</th>
                                <th>Status</th>
                                <th>Valor Total</th>
                                <th>Data da cobrança</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($subscription->subscription_billings as $billing): ?>
                                <tr>
                                    <td><?= $billing->id?></td>
                                    <td><?= $billing->payment_component ?></td>
                                    <td><?= $billing->subscription_billing_status->name ?></td>
                                    <td><?= $subscription->price_total_format ?></td>
                                    <td><?= $billing->date_process->format("d/m/Y") ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade in" id="shipments">
                    <h3>Envios</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($subscription->subscription_shipments as $shipment): ?>
                                <tr>
                                    <td><?= $shipment->id?></td>
                                    <td id="subscriptionShipmentName-<?= $shipment->id ?>">
                                        <?= $shipment->subscription_shipping_status->name ?>
                                    </td>
                                    <td><?= $shipment->created->format("d/m/Y") ?></td>
                                    <td>
                                        <a href="javascript:void(0)" data-status-id="<?= $shipment->status_id ?>" data-id="<?= $shipment->id ?>" class="btn btn-primary btn-sm btn-change-status-shipment">Atualizar status</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <p>
                <?= $this->Html->link('<i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar', $this->request->referer(), ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
            </p>
        </div>
    </div>

    <div class="modal fade" id="modal-register-tracking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <?= $this->Form->create('') ?>
                <?= $this->Form->hidden('subscriptions_shipments_id') ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Alterar status de envio</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <?= $this->Form->control('statuses_id', ['label' => 'Alterar status para', 'class' => 'form-control', 'options' => $subscription_shipping_status, 'empty' => 'Selecione...', 'required']) ?>
                    </div>
                    <div class="form-group" id="form-group-tracking">
                        <?= $this->Form->control('tracking', ['label' => 'Codigo de rastreio', 'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary btn-sm btn-save-shipment-status">Salvar</button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>