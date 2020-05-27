<?php
/**
 * @var \App\View\AppView $this
*/
$this->Html->script('Admin.discountgroups/discountgroups.functions', ['block' => 'scriptBottom', 'fullBase' => true]);
$this->Html->css(['Admin.jquery-ui.css'], ['block' => 'cssTop', 'fullBase' => true]);

?>
<div class="page-title">
    <h2>Grupo de Desconto</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($discountsGroupsCustomers) ?>
        <?= $this->Form->control('customers_id', ['type' => 'hidden']) ?>
        <?= $this->Form->control('id', ['type' => 'hidden', 'value' => $id]) ?>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Adicionar cliente', 'autocomplete' => 'off']) ?>
                </div>
            </div>
        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<?= $this->element('pagination') ?>
    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th>Cliente</th>
                    <th>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php if ($allCustomers): ?>
                    <?php foreach ($allCustomers as $customer): ?>
                        <tr>
                            <td><?= $customer->customer->name ?></td>
                            <td>
                                <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['action' => 'delete-customer'], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false, 'data' => ['customerId' => $customer->customer->id, 'groupId' => $id]]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>