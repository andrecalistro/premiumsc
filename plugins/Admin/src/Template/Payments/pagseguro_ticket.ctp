<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar PagSeguro Boleto</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($pagseguro_ticket, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-4 form-group">
                <?= $this->Form->control('label', ['class' => 'form-control', 'label' => 'Nome para exibição', 'value' => $pagseguro_ticket->label]) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('sandbox_email', ['class' => 'form-control', 'label' => 'E-mail de compra para testes Sandbox', 'value' => $pagseguro_ticket->sandbox_email]) ?>
            </div>

            <div class="col-md-4 form-group">
                <label>Exibir logo na tela de pagamento</label>
                <?= $this->Form->control('show_logo', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $pagseguro_ticket->show_logo]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('email', ['class' => 'form-control', 'label' => ['text' => 'E-mail <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="E-mail da conta do PagSeguro."></span>', 'escape' => false], 'value' => $pagseguro_ticket->email]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('token', ['class' => 'form-control', 'label' => ['text' => 'Token <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="O Token de Segurança pode ser encontrado no portal do vendedor do PagSeguro: https://pagseguro.uol.com.br > minha conta > preferência > integrações > utilização de apis > gerar token."></span>', 'escape' => false], 'value' => $pagseguro_ticket->token]) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label>Ambiente</label>
                    <?= $this->Form->control('environment', ['label' => false, 'empty' => 0, 'options' => $environments, 'type' => 'radio', 'value' => $pagseguro_ticket->environment]) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $pagseguro_ticket->status]) ?>
                </div>
            </div>
        </div>
        <hr>
        <h4>Status do pedido</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_waiting_payment', ['class' => 'form-control', 'label' => ['text' => 'Aguardando Pagamento <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o pagamento ainda não foi confirmado."></span>', 'escape' => false], 'value' => $pagseguro_ticket->status_waiting_payment, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_payment_analysis', ['class' => 'form-control', 'label' => ['text' => 'Pagamento em análise <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o comprador pagou mas a transação está sendo analisada."></span>', 'escape' => false], 'value' => $pagseguro_ticket->status_payment_analysis, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_approved_payment', ['class' => 'form-control', 'label' => ['text' => 'Pagamento confirmado <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o pagamento ainda não foi confirmado."></span>', 'escape' => false], 'value' => $pagseguro_ticket->status_approved_payment, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_payment_dispute', ['class' => 'form-control', 'label' => ['text' => 'Pagamento em disputa <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o comprador abriu uma disputa."></span>', 'escape' => false], 'value' => $pagseguro_ticket->status_payment_dispute, 'options' => $ordersStatuses]) ?>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('status_canceled_payment', ['class' => 'form-control', 'label' => ['text' => 'Pedido cancelado <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o pedido for cancelado."></span>', 'escape' => false], 'value' => $pagseguro_ticket->status_canceled_payment, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('status_reversed_payment', ['class' => 'form-control', 'label' => ['text' => 'Pagamento estornado <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o valor da compra for devolvido para o comprador."></span>', 'escape' => false], 'value' => $pagseguro_ticket->status_reversed_payment, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('status_chargeback_payment', ['class' => 'form-control', 'label' => ['text' => 'Pagamento contestado <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o portador do cartão não reconheceu a compra e o valor for devolvido. (chargeback)"></span>', 'escape' => false], 'value' => $pagseguro_ticket->status_chargeback_payment, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

        </div>

        <hr>
        <h4>URLs de notificações e redirecionamentos</h4>
        <div class="row">
            <div class="col-md-4">
                <?= $this->Form->control('notification_url', ['class' => 'form-control', 'label' => ['text' => 'Url de Notificação <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Recebimento da notificação de status de pedido. Cadastre esse endereço no portal do vendedor do PagSeguro: https://pagseguro.uol.com.br > minha conta > preferência > integrações > utilização de apis > notificação de transação."></span>', 'escape' => false], 'readonly' => true, 'value' => $notification_url]) ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <?= $this->Html->link("<i class=\"fa fa-times\" aria-hidden=\"true\"></i> Cancelar", ['controller' => 'payments', 'plugin' => 'admin'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
            </div>
            <div class="col-md-6 col-xs-12 text-right">
                <?= $this->Form->button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'escape' => false]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>