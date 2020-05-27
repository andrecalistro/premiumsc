<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?= $this->Form->create('', ['id' => 'form-bradesco-ticket', 'class' => 'form-horizontal', 'role' => 'form', 'url' => ['controller' => 'bradesco-ticket', 'action' => 'process', 'plugin' => 'CheckoutV2']]) ?>
<p class="text-center mar-bottom-20">O pedido será confirmado somente após a aprovação do
    pagamento. Após o pagamento do boleto a confirmação deve ocorrer entre 2 a 3 dias
    úteis.</p>
<?php if (!isset($customer['document']) || !$customer['document']): ?>
    <p><?= $this->Form->control('document', ['label' => false, 'placeholder' => 'Seu CPF', 'class' => 'form-control mask-cpf', 'required']) ?></p>
<?php endif ?>
<?php if (!isset($customer['telephone']) || !$customer['telephone']): ?>
    <p><?= $this->Form->control('telephone', ['label' => false, 'placeholder' => 'Seu telefone', 'class' => 'form-control mask-telephone', 'required']) ?></p>
<?php endif ?>
<?php if (!isset($customer['birth_date']) || !$customer['birth_date']): ?>
    <p><?= $this->Form->control('birth_date', ['type' => 'text', 'label' => false, 'placeholder' => 'Sua data de nascimento', 'class' => 'form-control mask-date', 'required']) ?></p>
<?php endif ?>
<div class="form-group text-center">
    <?= $this->Form->button('Prosseguir', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) ?>
</div>
<?= $this->Form->end() ?>