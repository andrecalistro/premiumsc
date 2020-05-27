<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script('Admin.payments/payments-tickets.functions.js', ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Arquivos de retorno</h2>
        </div>
    </div>
<?= $this->element('pagination') ?>
    <div class="content">
        <?= $this->Html->link('Enviar arquivo', 'javascript:void(0)', ['class' => 'btn btn-sm btn-primary mar-top-10 mar-bottom-10', 'onclick' => '$("#modal-add-return").modal("show")']) ?>
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('file_name', 'Arquivo') ?></th>
                    <th><?= $this->Paginator->sort('quantity_tickets', 'Qtde. de boletos processados') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Enviado em') ?></th>
                    <th></th>
                </tr>

                </thead>
                <tbody>
                <?php if ($paymentsTicketsReturns): ?>
                    <?php foreach ($paymentsTicketsReturns as $paymentsTicketsReturn): ?>
                        <tr>
                            <td><?= $paymentsTicketsReturn->id ?></td>
                            <td><?= $paymentsTicketsReturn->file_name ?></td>
                            <td><?= $paymentsTicketsReturn->quantity_tickets ?></td>
                            <td><?= $paymentsTicketsReturn->created->format('d/m/Y H:i') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>

<div class="modal fade" id="modal-add-return" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create('', ['type' => 'file', 'url' => ['controller' => 'payments-tickets-returns', 'action' => 'add']]) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Enviar arquivo de retorno</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= $this->Form->control('file', ['label' => 'Arquivo de retorno', 'class' => 'form-control', 'required', 'type' => 'file']) ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
