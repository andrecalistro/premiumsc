<?php
/**
 * @var \App\View\AppView $this
 */
$url = $this->request->getRequestTarget();
$this->Html->script('Admin.plans/functions.js', ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Assinantes</h2>
        </div>
    </div>
<?= $this->element('pagination') ?>
    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Subscriptions.id', 'Cód') ?></th>
                    <th><?= $this->Paginator->sort('Plans.name', 'Plano') ?></th>
                    <th><?= $this->Paginator->sort('Customers.name', 'Cliente') ?></th>
                    <th><?= $this->Paginator->sort('Subscriptions.price', 'Preço') ?></th>
                    <th><?= $this->Paginator->sort('Subscriptions.price_shipment', 'Frete') ?></th>
                    <th><?= $this->Paginator->sort('Subscriptions.frequency_delivery_name', 'Frequência de envio') ?></th>
                    <th><?= $this->Paginator->sort('Subscriptions.frequency_billing_name', 'Frequência de cobrança') ?></th>
                    <th><?= $this->Paginator->sort('Subscriptions.status', 'Status') ?></th>
                    <th><?= $this->Paginator->sort('Subscriptions.created', 'Data') ?></th>
                    <th></th>
                </tr>

                <tr>
                    <?= $this->Form->create('', ['type' => 'get']) ?>
                    <th width="120"></th>
                    <th width="500"><?= $this->Form->control(
                            'plans_id', [
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Plano',
                            'options' => $plans,
                            'empty' => '-- Selecione --',
                            'value' => $filter['plans_id']
                        ]) ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                        <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary btn-sm', 'title' => 'Buscar']) ?>
                        <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'plans', 'action' => 'subscriptions'], ['class' => 'btn btn-default btn-sm', 'escape' => false, 'title' => 'Todos os produtos']) ?>
                    </th>
                    <?= $this->Form->end() ?>
                </tr>

                </thead>
                <tbody>
                <?php if ($subscriptions): ?>
                    <?php foreach ($subscriptions as $subscription): ?>
                        <tr>
                            <td><?= $subscription->id ?></td>
                            <td><?= $subscription->plan->name ?></td>
                            <td><?= $subscription->customer->name ?></td>
                            <td><?= $subscription->price_format ?></td>
                            <td><?= $subscription->price_shipping_format ?></td>
                            <td><?= $subscription->frequency_delivery_name ?></td>
                            <td><?= $subscription->frequency_billing_name ?></td>
                            <td><?= $subscription->status === 1 ? 'Ativo' : 'Cancelado' ?></td>
                            <td><?= $subscription->created->format('d/m/Y') ?></td>
                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'plans', 'action' => 'subscription-view', $subscription->id, 'plugin' => 'admin']) ?>"
                                   title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <?= $this->Form->postLink('<i class="fa fa-close" aria-hidden="true"></i>', ['controller' => 'plans', 'action' => 'subscription-cancel', $subscription->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja cancelar essa assinatura?', 'escape' => false, 'title' => 'Cancelar assinatura']) ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>