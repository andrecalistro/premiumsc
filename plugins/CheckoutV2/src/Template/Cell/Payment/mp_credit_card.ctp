<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div id="mp-credit-card">
    <?= $this->Form->create('', ['role' => 'form']) ?>
    <?= $this->Form->control('public_key', ['type' => 'hidden', 'value' => $public_key]) ?>
    <?= $this->Form->control('order_total', ['type' => 'hidden', 'value' => $order_total]) ?>
    <?= $this->Form->control('token', ['type' => 'hidden']) ?>
    <?= $this->Form->control('card_type', ['type' => 'hidden']) ?>
    <?= $this->Form->control('card_issuer', ['type' => 'hidden']) ?>
    <div class="form-group">
        <?= $this->Form->control('card_number', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Número do cartão', 'required' => true]) ?>
        <label class="alert alert-danger small w-100 card-number-alert" style="display:none;">Número do cartão
            inválido</label>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <?= $this->Form->control('card_name', ['class' => 'form-control text-uppercase', 'label' => false, 'placeholder' => 'Nome impresso no cartão', 'value' => $name]) ?>
        </div>
        <div class="col-md-6 form-group">
            <?= $this->Form->control('document', ['class' => 'form-control', 'label' => false, 'required' => true, 'value' => $document, 'placeholder' => 'CPF do titular do cartão']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <?= $this->Form->control('expiry_month', ['label' => false, 'empty' => 'Validade Mês', 'options' => $months, 'required' => true, 'class' => 'form-control']) ?>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <?= $this->Form->control('expiry_year', ['label' => false, 'empty' => 'Validade Ano', 'options' => $years, 'required' => true, 'class' => 'form-control']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <?= $this->Form->control('cvc', ['class' => 'form-control', 'label' => false, 'maxlength' => 4, 'autocomplete' => 'off', 'placeholder' => 'Código de segurança']) ?>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <?= $this->Form->control('installment', ['label' => false, 'options' => [], 'empty' => 'Número de parcelas', 'class' => 'form-control', 'required' => true]) ?>
            </div>
        </div>
    </div>
    <?= $this->Form->button('Confirmar Pagamento', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->script(['Checkout.creditcard.min', 'Checkout.mp-credit-card.functions'], ['fullBase' => true]) ?>
</div>