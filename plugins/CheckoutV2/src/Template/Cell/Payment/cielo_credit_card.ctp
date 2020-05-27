<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div id="credit-card">
    <?= $this->Form->create('', ['role' => 'form']) ?>
    <?= $this->Form->control('card_type', ['type' => 'hidden']) ?>
    <div class="text-left"><label>Cartões aceitos</label></div>
    <div class="d-flex justify-content-between flex-row mb-3">
        <?php foreach ($cardBrands as $key => $cardBrand): ?>
            <?= $this->Html->image($cardBrand, ['id' => 'img-brand-' . $key, 'class' => 'img-brand-credit-card', 'style' => 'max-width: 55px; max-height: 35px;']) ?>
        <?php endforeach; ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('card_number', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Número do cartão', 'required' => true]) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('card_name', ['class' => 'form-control text-uppercase', 'label' => false, 'placeholder' => 'Nome impresso no cartão']) ?>
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
                <?= $this->Form->control('installment', ['label' => false, 'options' => $installments, 'empty' => 'Número de parcelas', 'class' => 'form-control', 'required' => true]) ?>
            </div>
        </div>
    </div>
    <?= $this->Form->button('Confirmar Pagamento', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->script(['Checkout.creditcard.min', 'Checkout.cielo.functions'], ['fullBase' => true]) ?>
</div>