<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Configurar PagSeguro</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($pagseguro, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('email', ['class' => 'form-control', 'label' => ['text' => 'E-mail <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="E-mail da conta do PagSeguro."></span>', 'escape' => false], 'value' => $pagseguro->email]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('token', ['class' => 'form-control', 'label' => ['text' => 'Token <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="O Token de Segurança pode ser encontrado no portal do vendedor do PagSeguro: https://pagseguro.uol.com.br > minha conta > preferência > integrações > utilização de apis > gerar token."></span>', 'escape' => false], 'value' => $pagseguro->token]) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label>Ambiente</label>
                    <?= $this->Form->control('environment', ['label' => false, 'empty' => 0, 'options' => $environments, 'type' => 'radio', 'value' => $pagseguro->environment]) ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $pagseguro->status]) ?>
                </div>
            </div>
        </div>
        <hr>
        <h4>Status do pedido</h4>
        <div class="row">Status'
            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_waiting_payment', ['class' => 'form-control', 'label' => ['text' => 'Aguardando Pagamento <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o pagamento ainda não foi confirmado."></span>', 'escape' => false], 'value' => $pagseguro->status_waiting_payment, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_payment_analysis', ['class' => 'form-control', 'label' => ['text' => 'Pagamento em análise <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o comprador pagou mas a transação está sendo analisada."></span>', 'escape' => false], 'value' => $pagseguro->status_payment_analysis, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_approved_payment', ['class' => 'form-control', 'label' => ['text' => 'Pagamento confirmado <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o pagamento ainda não foi confirmado."></span>', 'escape' => false], 'value' => $pagseguro->status_approved_payment, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <?= $this->Form->control('status_payment_dispute', ['class' => 'form-control', 'label' => ['text' => 'Pagamento em disputa <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o comprador abriu uma disputa."></span>', 'escape' => false], 'value' => $pagseguro->status_payment_dispute, 'options' => $ordersStatuses]) ?>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('status_canceled_payment', ['class' => 'form-control', 'label' => ['text' => 'Pedido cancelado <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o pedido for cancelado."></span>', 'escape' => false], 'value' => $pagseguro->status_canceled_payment, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('status_reversed_payment', ['class' => 'form-control', 'label' => ['text' => 'Pagamento estornado <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o valor da compra for devolvido para o comprador."></span>', 'escape' => false], 'value' => $pagseguro->status_reversed_payment, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?= $this->Form->control('status_chargeback_payment', ['class' => 'form-control', 'label' => ['text' => 'Pagamento contestado <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Quando o portador do cartão não reconheceu a compra e o valor for devolvido. (chargeback)"></span>', 'escape' => false], 'value' => $pagseguro->status_chargeback_payment, 'options' => $ordersStatuses]) ?>
                </div>
            </div>

        </div>

        <hr>
        <h4>URLs de notificações e redirecionamentos</h4>
        <div class="row">
            <div class="col-md-4">
                <?= $this->Form->control('notification_url', ['class' => 'form-control', 'label' => ['text' => 'Url de Notificação <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Recebimento da notificação de status de pedido. Cadastre esse endereço no portal do vendedor do PagSeguro: https://pagseguro.uol.com.br > minha conta > preferência > integrações > utilização de apis > notificação de transação."></span>', 'escape' => false], 'readonly' => true, 'value' => $notification_url]) ?>
            </div>

            <div class="col-md-4">
                <?= $this->Form->control('redirect_url', ['class' => 'form-control', 'label' => ['text' => 'Url de redirecionamento <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="O cliente é redirecionado para esta URL quando a compra é finalizada. Cadastre esse endereço no portal do vendedor do PagSeguro: https://pagseguro.uol.com.br > minha conta > preferência > integrações > página de redirecionamento."></span>', 'escape' => false], 'readonly' => true, 'value' => $redirect_url]) ?>
            </div>

            <div class="col-md-4">
                <?= $this->Form->control('cancel_url', ['class' => 'form-control', 'label' => ['text' => 'Url de cancelamento <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="O cliente é redirecionado para esta URL quando o pagamento é cancelado."></span>', 'escape' => false], 'readonly' => true, 'value' => $cancel_url]) ?>
            </div>
        </div>

        <hr>
        <h4>Imagem de pagamento</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group btn-file">
                    <label>Logo</label>
                    <p class="icon-upload-file <?= !empty($pagseguro->logo) ? 'hidden-element' : '' ?>">
                        <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                    </p>
                    <?= $this->Form->control('logo', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false]) ?>
                    <?= $this->Form->control('logo', ['class' => 'input-text-file', 'type' => 'hidden', 'label' => false, 'div' => false, 'value' => $pagseguro->logo, 'disabled' => empty($pagseguro->logo) ? true : false]) ?>
                    <?= $this->Html->image(!empty($pagseguro->logo) ? $pagseguro->thumb_logo : 'Admin.icon-upload.png', ['class' => empty($pagseguro->logo) ? 'hidden-element img-thumbnail img-upload' : 'img-thumbnail img-upload']) ?>
                    <p class="btn-del-file <?= empty($pagseguro->logo) ? 'hidden-element' : '' ?>">
                        <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger']) ?>
                    </p>
                </div>
            </div>
        </div>

        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>