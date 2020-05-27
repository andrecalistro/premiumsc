<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="grid form-grid" id="credit-card">
    <?= $this->Form->create('', ['role' => 'form', 'id' => 'form-pagseguro-credit-card', 'style' => 'display:none;']) ?>
    <?= $this->Form->control('hash', ['type' => 'hidden']) ?>
    <?= $this->Form->control('card_type', ['type' => 'hidden']) ?>
    <?= $this->Form->control('total', ['type' => 'hidden', 'value' => $total]) ?>
    <div class="col">
        <div class="form-group">
            <label for="card_number">Número do Cartão</label>
            <?= $this->Form->control('card_number', [
                'class' => 'block',
                'label' => false,
                'required' => true
            ]) ?>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="card_name">Nome Impresso no Cartão</label>
            <?= $this->Form->control('card_name', [
                'class' => 'block text-uppercase',
                'label' => false
            ]) ?>
        </div>
    </div>
    <div class="col-6 col-xs-3">
        <div class="form-group select">
            <label for="expiry_month">Validade</label>
            <?= $this->Form->control('expiry_month', [
                'label' => false,
                'empty' => 'Mês',
                'options' => $months,
                'required' => true,
                'class' => 'block-control'
            ]) ?>
        </div>
    </div>
    <div class="col-6 col-xs-3">
        <div class="form-group select">
            <label for="exp-date-year">&nbsp;</label>
            <?= $this->Form->control('expiry_year', [
                'label' => false,
                'empty' => 'Ano',
                'options' => $years,
                'required' => true,
                'class' => 'block'
            ]) ?>
        </div>
    </div>
    <div class="col col-xs-6">
        <div class="form-group credit-card">
            <label for="cvc">Código de Segurança</label>
            <?= $this->Form->control('cvc', [
                'class' => 'block',
                'label' => false,
                'maxlength' => 4,
                'autocomplete' => 'off',
                'placeholder' => 'CVV'
            ]) ?>
        </div>
    </div>
    <div class="col col-xs-6">
        <div class="form-group select">
            <label for="installment">Número de Parcelas</label>
            <?= $this->Form->control('installment', [
                'label' => false,
                'options' => [],
                'class' => 'block',
                'required' => true
            ]) ?>
        </div>
    </div>
    <div class="col hr"></div>
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
    <?= $this->Form->end() ?>
</div>


<script type="text/javascript">
    var credit_card_script = document.createElement('script');
    credit_card_script.src = '<?= $this->Url->build('/checkout_v2/js/creditcard.min.js', ['fullBase' => true]) ?>';

    credit_card_script.onload = function () {
        var pagseguro_credit_card_script = document.createElement('script');
        pagseguro_credit_card_script.src = '<?= $this->Url->build('/checkout_v2/js/pagseguro_credit_card.functions.js',
            ['fullBase' => true]) ?>';
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
                $.ajax({
                    type: "POST",
                    url: base_url + "finalizar-compra/pagseguro-credit-card/get-installments.json",
                    data: {brand: $("#credit-card input#card-type").val()},
                    dataType: 'json',
                    beforeSend: function () {
                        loading('Carregando parcelas...');
                    },
                    complete: function () {
                        loadingClose();
                    },
                    success: function (result) {
                        if (result.installments) {
                            let installments_html = '';
                            $.each(result.installments, function (index, installment) {
                                installments_html += '<option value="' + installment.quantity + '_' + installment.amount + '_' + installment.totalAmount + '">' + installment.quantity + 'x de R$ ' + installment.installmentAmountFormatted + (installment.interestFree === 'true' ? ' sem juros' : ' com juros') + '</option>';
                            });
                            $("#credit-card #installment").html(installments_html);
                        }
                    }
                });

                //PagSeguroDirectPayment.getInstallments({
                //    amount: <?//= $total ?>//,
                //    brand: $("#credit-card input#card-type").val(),
                //    maxInstallmentNoInterest: <?//= $no_interest ?>//,
                //    success: function (response) {
                //        if (!response.error) {
                //            var installments_html = '';
                //            $.each(response.installments, function (index, brand) {
                //                $.each(brand, function (key, installment) {
                //                    installments_html += '<option value="' + installment.quantity + '_' + installment.installmentAmount + '_' + installment.totalAmount + '">' + installment.quantity + 'x de R$ ' + number_format(installment.installmentAmount, 2, ",", ".") + (installment.interestFree ? ' sem juros' : ' com juros') + '</option>';
                //                });
                //            });
                //            $("#credit-card #installment").html(installments_html);
                //        } else {
                //            alertDialog('Número do cartão inválido ou incorreto, por favor corrija', 'error');
                //            return false;
                //        }
                //    },
                //    error: function (response) {
                //        console.log(response);
                //    },
                //    complete: function (response) {
                //        //tratamento comum para todas chamadas
                //    }
                //});
            });

            $("#credit-card form").on('submit', function (e) {
                e.preventDefault();

                let cartao = $("#card-number").val().replace(/\D/g, '');

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
                                url: base_url + "finalizar-compra/pagseguro-credit-card/process.json",
                                data: $("#credit-card form").serialize() + '&token=' + response.card.token + '&hash=' + PagSeguroDirectPayment.getSenderHash(),
                                dataType: 'json',
                                beforeSend: function () {
                                    loading('Processando pagamento...');
                                },
                                complete: function () {
                                    loadingClose();
                                },
                                success: function (result) {
                                    if (result.data.status) {
                                        window.location = result.data.redirect;
                                    } else {
                                        alertDialog(result.data.message, 'error');
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
            let SPMaskBehavior = function (val) {
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

    $.when(document.body.appendChild(credit_card_script)).then(function (response) {
        $("#form-pagseguro-credit-card").show();
    });
</script>