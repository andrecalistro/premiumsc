<?php
/**
 * @var \App\View\AppView $this
 */
$url = $this->request->getRequestTarget();
$this->Html->script('Admin.plans/functions.js', ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Planos</h2>
        </div>

        <div class="navbarRightBtns">
            <a class="btn btn-primary btn-sm navbarBtn"
               href="<?= $this->Url->build(['controller' => 'plans', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar
                Plano</a>
        </div>
    </div>
<?= $this->element('pagination') ?>
    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Plans.id', 'Cód') ?></th>
                    <th><?= $this->Paginator->sort('Plans.description', 'Plano') ?></th>
                    <th><?= $this->Paginator->sort('Plans.price', 'Preço') ?></th>
                    <th><?= $this->Paginator->sort('PlanDeliveryFrequency.name', 'Frequência de envio') ?></th>
                    <th><?= $this->Paginator->sort('PlanBillingFrequency.name', 'Frequência de cobrança') ?></th>
                    <th><?= $this->Paginator->sort('Plans.status', 'Status') ?></th>
                    <th></th>
                </tr>

                <tr>
                    <?= $this->Form->create('', ['type' => 'get']) ?>
                    <th width="120"><?= $this->Form->control('id', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Cód', 'value' => $filter['id'], 'autocomplete' => 'off']) ?></th>
                    <th width="500"><?= $this->Form->control('description', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Plano', 'value' => $filter['description'], 'autocomplete' => 'off']) ?></th>
                    <th><?= $this->Form->control('price', ['label' => false, 'class' => 'form-control input-price', 'placeholder' => 'Preço', 'value' => $filter['price'], 'autocomplete' => 'off']) ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                        <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary btn-sm', 'title' => 'Buscar']) ?>
                        <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'plans', 'action' => 'index'], ['class' => 'btn btn-default btn-sm', 'escape' => false, 'title' => 'Todos os produtos']) ?>
                    </th>
                    <?= $this->Form->end() ?>
                </tr>

                </thead>
                <tbody>
                <?php if ($plans): ?>
                    <?php foreach ($plans as $plan): ?>
                        <tr>
                            <td><?= $plan->id?></td>
                            <td><?= $plan->name?></td>
                            <td><?= $plan->price_format?></td>
                            <td><?= $plan->plan_delivery_frequency->name ?></td>
                            <td><?= $plan->plan_billing_frequency->name ?></td>
                            <td><?= $plan->status_name ?></td>
                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'plans', 'action' => 'view', $plan->id, 'plugin' => 'admin']) ?>"
                                   title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-primary btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'plans', 'action' => 'edit', $plan->id, 'plugin' => 'admin']) ?>"
                                   title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'plans', 'action' => 'delete', $plan->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false, 'title' => 'Excluir']) ?>
                                <a class="btn btn-<?= $plan->status === 1 ? 'success' : 'default' ?> btn-sm status-plan"
                                   title="<?= $plan->status === 1 ? 'Desabilitar' : 'Habilitar' ?> Plano"
                                   href="javascript:void(0)" data-plan-id="<?= $plan->id ?>"><i
                                        class="fa fa-power-off"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>