<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div id="credit-card">
    <?= $this->Form->create('', ['role' => 'form', 'id' => 'form-pagseguro-credit-card', 'style' => 'display:none;']) ?>
    <?= $this->Form->control('hash', ['type' => 'hidden']) ?>
    <?= $this->Form->control('card_type', ['type' => 'hidden']) ?>
    <?= $this->Form->control('total', ['type' => 'hidden', 'value' => $total]) ?>
    <div class="form-group">
        <?= $this->Form->control('card_number', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Número do cartão', 'required' => true]) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('card_name', ['class' => 'form-control text-uppercase', 'label' => false, 'placeholder' => 'Nome impresso no cartão']) ?>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <?= $this->Form->control('document', ['class' => 'form-control mask-cpf', 'label' => false, 'required' => true, 'value' => $document, 'placeholder' => 'CPF do titular do cartão']) ?>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <?= $this->Form->control('birth_date', ['label' => false, 'required' => true, 'class' => 'form-control mask-date', 'value' => $birth_date, 'placeholder' => 'Data de nascimento do titular do cartão']) ?>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <?= $this->Form->control('telephone', ['label' => false, 'required' => true, 'class' => 'form-control mask-telephone', 'value' => $telephone, 'placeholder' => 'Telefone do titular do cartão']) ?>
            </div>
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
    </div>
    <?= $this->Form->button('Confirmar Pagamento da Assinatura', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) ?>
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
    var credit_card_script = document.createElement('script');
    credit_card_script.src = '<?= $this->Url->build('/checkout/js/creditcard.min.js', ['fullBase' => true]) ?>';

    credit_card_script.onload = function () {
        var pagseguro_credit_card_script = document.createElement('script');
        pagseguro_credit_card_script.src = '<?= $this->Url->build('/checkout/js/pagseguro_credit_card.functions.js', ['fullBase' => true]) ?>';
        document.body.appendChild(pagseguro_credit_card_script);

        var pagseguro_script = document.createElement('script');
        pagseguro_script.src = "<?= $js ?>";

        pagseguro_script.onload = function () {
            PagSeguroDirectPayment.setSessionId('<?= $session_id ?>');

            $('#card-number').on('blur', function () {
                if ($('#card-type').val() === '') {
                    alertDialog('Número do cartão inválido ou incorreto, por favor corrija', 'error');
                    return false;
                }
            });

            $("#credit-card form").on('submit', function (e) {
                e.preventDefault();

                var cartao = $("#card-number").val().replace(/\D/g, '');

                if ($('#card-type').val() === '' || cartao === '') {
                    alertDialog('Número do cartão inválido ou incorreto, por favor corrija', 'error');
                    return false;
                }

                if ($('#installment').val() === '') {
                    alertDialog('Selecione a quantidade de parcelas que deseja', 'error');
                    return false;
                }

                PagSeguroDirectPayment.createCardToken({
                    cardNumber: cartao,
                    brand: $("#card-type").val(),
                    cvv: $("#cvc").val(),
                    expirationMonth: $("#expiry-month").val(),
                    expirationYear: $("#expiry-year").val(),
                    success: function (response) {
                        if (response.card.token) {
                            $.ajax({
                                type: "POST",
                                url: "<?= $processPaymentUrl ?>",
                                data: $("#credit-card form").serialize() + '&token=' + response.card.token + '&hash=' + PagSeguroDirectPayment.getSenderHash() + '&payment=PagSeguro&method=creditCard',
                                dataType: 'json',
                                beforeSend: function () {
                                    loading('Processando pagamento...');
                                },
                                complete: function () {
                                    loadingClose();
                                },
                                success: function (result) {
                                    if (result.status) {
                                        window.location = result.redirect;
                                    } else {
                                        alertDialog(result.message, 'error');
                                    }
                                }
                            });
                        } else {
                            alertDialog('Cartão inválido, revise o número, codigo de segurança e data de válidade.', 'error');
                            return false;
                        }
                    },
                    error: function () {
                        alertDialog('Cartão inválido, revise o número, codigo de segurança e data de válidade.', 'error');
                        return false;
                    }
                });
            });
            $(".mask-date").mask("00/00/0000");
            $(".mask-cpf").mask("000.000.000-00");
            var SPMaskBehavior = function (val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                spOptions = {
                    onKeyPress: function (val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };

            $(".mask-telephone").mask(SPMaskBehavior, spOptions);
        };

        document.body.appendChild(pagseguro_script);
    };

    $.when(document.body.appendChild(credit_card_script)).then(function(response){
        $("#form-pagseguro-credit-card").show();
    });
</script>