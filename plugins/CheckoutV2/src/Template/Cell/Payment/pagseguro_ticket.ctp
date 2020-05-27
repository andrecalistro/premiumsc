<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?= $this->Form->create('', [
    'id' => 'form-pagseguro-ticket',
    'class' => 'form-horizontal',
    'role' => 'form',
    'style' => 'display:none;',
    'url' => [
        'controller' => 'pagseguro-ticket',
        'action' => 'process',
        'plugin' => 'CheckoutV2'
    ]
]) ?>
<?= $this->Form->control('hash', ['type' => 'hidden']) ?>
<div class="grid form-grid" id="credit-card">
    <div class="col">
        <p>O pedido será confirmado somente após a aprovação do
            pagamento. Após o pagamento do boleto a confirmação deve ocorrer entre 2 a 3 dias
            úteis.</p>
    </div>
    <div class="col hr"></div>

    <?php if (!isset($customer['document']) || !$customer['document']): ?>
        <div class="col col-xs-6">
            <div class="form-group">
                <label for="document">CPF do Titular do Cartão</label>
                <?= $this->Form->control('document', [
                    'class' => 'block mask-cpf',
                    'label' => false,
                    'required' => true,
                    'value' => $document,
                    'placeholder' => 'Ex.: 123.456.789-12'
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!isset($customer['birth_date']) || !$customer['birth_date']): ?>
        <div class="col col-xs-6">
            <div class="form-group">
                <label for="birth_date">Data de Nascimento</label>
                <?= $this->Form->control('birth_date', [
                    'label' => false,
                    'required' => true,
                    'class' => 'block mask-date',
                    'value' => $birth_date,
                    'placeholder' => 'Ex.: 01/02/1987'
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!isset($customer['telephone']) || !$customer['telephone']): ?>
        <div class="col col-xs-6">
            <div class="form-group">
                <label for="telephone">Telefone do Titular do Cartão</label>
                <?= $this->Form->control('telephone', [
                    'label' => false,
                    'required' => true,
                    'class' => 'block mask-telephone',
                    'value' => $telephone,
                    'placeholder' => 'Telefone do titular do cartão'
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="col text-center">
        <?= $this->Form->button('Finalizar Compra', [
            'type' => 'submit',
            'class' => 'btn btn-success btn-lg mt-2'
        ]) ?>
        <p class="continue">ou <?= $this->Html->link('Alterar forma de pagamento', [
                'controller' => 'checkout',
                'action' => 'choose-payment'
            ]) ?></p>
    </div>
</div>
<?= $this->Form->end() ?>

<script type="text/javascript">
    var pagseguro_script = document.createElement('script');
    var jquery_mask_script = document.createElement('script');
    var mask_script = document.createElement('script');

    pagseguro_script.src = "<?= $js ?>";
    pagseguro_script.onload = function () {
        PagSeguroDirectPayment.setSessionId('<?= $session_id ?>');

        PagSeguroDirectPayment.onSenderHashReady(function (response) {
            if (response.status === 'error') {
                loadingClose();
                alertDialog('Ocorreu um problema ao processar seu pagamento. Por favor, tente novamente.');
                return false;
            }

            $("#form-pagseguro-ticket input[name=hash]").val(response.senderHash);
            $("#form-pagseguro-ticket").show();
            return true;
        });
    };
    document.body.appendChild(pagseguro_script);
    jquery_mask_script.src = '<?= $this->Url->build('/checkout_v2/js/jquery.mask.js', ['fullBase' => true]) ?>';
    mask_script.src = '<?= $this->Url->build('/checkout_v2/js/mask.functions.js', ['fullBase' => true]) ?>';
    document.body.appendChild(jquery_mask_script);
    document.body.appendChild(mask_script);
</script>
