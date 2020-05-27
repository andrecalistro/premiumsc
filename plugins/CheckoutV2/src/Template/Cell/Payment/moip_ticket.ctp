<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?= $this->Form->create('', ['class' => 'form-horizontal', 'role' => 'form', 'url' => ['controller' => 'moip-ticket', 'action' => 'process']]) ?>
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
        <?= $this->Form->button('Gerar Boleto', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) ?>
    </div>
<?= $this->Form->end() ?>

<script type="text/javascript">
    var jquery_mask_script = document.createElement('script');
    var mask_script = document.createElement('script');
    jquery_mask_script.src = '<?= $this->Url->build('/checkout/js/jquery.mask.js', ['fullBase' => true]) ?>';
    mask_script.src = '<?= $this->Url->build('/checkout/js/mask.functions.js', ['fullBase' => true]) ?>';
    document.body.appendChild(jquery_mask_script);
    document.body.appendChild(mask_script);
</script>
