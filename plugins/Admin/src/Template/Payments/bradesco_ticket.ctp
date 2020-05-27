<?php
/**
 * @var \App\View\AppView $this
 */
$this->Form->setTemplates([
    'inputContainer' => '{{content}}',
]);
?>
<div class="page-title">
    <h2>Configurar Bradesco Boleto</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($bradesco_ticket, ['type' => 'file']) ?>
        <div class="row">
            <div class="col-md-3 form-group">
                <?= $this->Form->control('label', ['class' => 'form-control', 'label' => 'Nome para exibição', 'value' => $bradesco_ticket->label]) ?>
            </div>

            <div class="col-md-3 form-group">
                <?= $this->Form->control('additional_days', ['class' => 'form-control', 'label' => 'Dias adicionais para vencimento do boleto', 'value' => $bradesco_ticket->additional_days]) ?>
            </div>

            <div class="col-md-3 form-group">
                <?= $this->Form->control('initial_our_number', ['class' => 'form-control', 'label' => 'Nosso numero inicial', 'value' => $bradesco_ticket->initial_our_number]) ?>
            </div>

            <div class="col-md-3 form-group">
                <label>Status</label>
                <div>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $bradesco_ticket->status]) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Agência</label>
                <div class="row">
                    <div class="col-md-8">
                        <?= $this->Form->control('agency', ['class' => 'col-md-8 form-control', 'label' => false, 'value' => $bradesco_ticket->agency, 'placeholder' => 'Número da agencia', 'style' => 'text-align: right;']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('agency_digit', ['class' => 'col-md-4 form-control', 'label' => false, 'value' => $bradesco_ticket->agency_digit, 'placeholder' => 'Dígito da agencia']) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4 form-group">
                <label>Conta</label>
                <div class="row">
                    <div class="col-md-8">
                        <?= $this->Form->control('account', ['class' => 'col-md-8 form-control', 'label' => false, 'value' => $bradesco_ticket->account, 'placeholder' => 'Número da conta', 'style' => 'text-align: right;']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('account_digit', ['class' => 'col-md-4 form-control', 'label' => false, 'value' => $bradesco_ticket->account_digit, 'placeholder' => 'Dígito da conta']) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('account_wallet', ['class' => 'form-control', 'label' => 'Carteira', 'value' => $bradesco_ticket->account_wallet]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 form-group">
                <?= $this->Form->control('identification', ['class' => 'form-control', 'label' => 'Identificação', 'value' => $bradesco_ticket->identification]) ?>
            </div>

            <div class="col-md-3 form-group">
                <?= $this->Form->control('document', ['class' => 'form-control', 'label' => 'CNPJ', 'value' => $bradesco_ticket->document]) ?>
            </div>

            <div class="col-md-3 form-group">
                <label>Endereço \ CEP</label>
                <div class="row">
                    <div class="col-md-8">
                        <?= $this->Form->control('address', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Endereço', 'value' => $bradesco_ticket->address]) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('zipcode', ['class' => 'form-control', 'label' => false, 'placeholder' => 'CEP', 'value' => $bradesco_ticket->zipcode]) ?>
                    </div>
                </div>

            </div>

            <div class="col-md-3 form-group">
                <label>Bairro \ Cidade \ Estado</label>
                <div class="row">
                    <div class="col-md-4">
                        <?= $this->Form->control('neighborhood', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Bairro', 'value' => $bradesco_ticket->neighborhood]) ?>
                    </div>
                    <div class="col-md-5">
                        <?= $this->Form->control('city', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Cidade', 'value' => $bradesco_ticket->city]) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('state', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Estado', 'value' => $bradesco_ticket->state]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <?= $this->Form->control('demonstrative1', ['class' => 'form-control', 'label' => 'Demonstrativo 1', 'value' => $bradesco_ticket->demonstrative1]) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('demonstrative2', ['class' => 'form-control', 'label' => 'Demonstrativo 2', 'value' => $bradesco_ticket->demonstrative2]) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('demonstrative3', ['class' => 'form-control', 'label' => 'Demonstrativo 3', 'value' => $bradesco_ticket->demonstrative3]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 form-group">
                <?= $this->Form->control('instructions1', ['class' => 'form-control', 'label' => 'Instruções 1', 'value' => $bradesco_ticket->instructions1]) ?>
            </div>

            <div class="col-md-3 form-group">
                <?= $this->Form->control('instructions2', ['class' => 'form-control', 'label' => 'Instruções 2', 'value' => $bradesco_ticket->instructions2]) ?>
            </div>

            <div class="col-md-3 form-group">
                <?= $this->Form->control('instructions3', ['class' => 'form-control', 'label' => 'Instruções 3', 'value' => $bradesco_ticket->instructions3]) ?>
            </div>

            <div class="col-md-3 form-group">
                <?= $this->Form->control('instructions4', ['class' => 'form-control', 'label' => 'Instruções 4', 'value' => $bradesco_ticket->instructions4]) ?>
            </div>
        </div>

        <hr>
        <h4>Status do pedido</h4>
        <div class="row">
            <div class="col-md-4 form-group">
                <?= $this->Form->control('status_awaiting_payment', ['class' => 'form-control', 'label' => 'Aguardando pagamento', 'value' => $bradesco_ticket->status_awaiting_payment, 'options' => $ordersStatuses]) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('status_payment_approved', ['class' => 'form-control', 'label' => 'Pagamento aprovado', 'value' => $bradesco_ticket->status_payment_approved, 'options' => $ordersStatuses]) ?>
            </div>

            <div class="col-md-4 form-group">
                <?= $this->Form->control('status_canceled', ['class' => 'form-control', 'label' => 'Cancelado', 'value' => $bradesco_ticket->status_canceled, 'options' => $ordersStatuses]) ?>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-12 form-group btn-file">
                <label>Logo</label>
                <p class="icon-upload-file <?= !empty($bradesco_ticket->logo) ? 'hidden-element' : '' ?>">
                    <?= $this->Html->image('Admin.icon-upload.png', ['class' => 'img-thumbnail']) ?>
                </p>
                <?= $this->Form->control('logo', ['class' => 'img-upload-input', 'type' => 'file', 'label' => false, 'div' => false]) ?>
                <?= $this->Form->control('logo', ['class' => 'input-text-file', 'type' => 'hidden', 'label' => false, 'div' => false, 'value' => $bradesco_ticket->logo, 'disabled' => empty($bradesco_ticket->logo) ? true : false]) ?>
                <?= $this->Html->image(!empty($bradesco_ticket->logo) ? $bradesco_ticket->thumb_logo : 'Admin.icon-upload.png', ['class' => empty($bradesco_ticket->logo) ? 'hidden-element img-thumbnail img-upload' : 'img-thumbnail img-upload']) ?>
                <p class="btn-del-file <?= empty($bradesco_ticket->logo) ? 'hidden-element' : '' ?>">
                    <?= $this->Form->button('Excluir', ['type' => 'button', 'class' => 'btn btn-danger']) ?>
                </p>
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