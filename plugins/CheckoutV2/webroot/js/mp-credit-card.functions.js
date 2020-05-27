var script = document.createElement('script');

script.src = "https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js";
script.onload = function () {
    var identificationType = 'CPF';
    Mercadopago.setPublishableKey($('#mp-credit-card input[name=public_key]').val());

    var input = $('#mp-credit-card input[name=card_number]');
    if (input.length > 0) {
        $(document).ready(function () {
            input.payform('formatCardNumber');
        });

        $(document).on('keyup', input, function () {
            var card_type = $.payform.parseCardType(input.val());
            if (card_type !== null && $.payform.validateCardNumber(input.val())) {
                var card_number = input.val().replace(/ /g, '');
                $("#mp-credit-card input[name=card_type]").val(card_type);
                Mercadopago.getIssuers(card_type, issuersHandler);
                Mercadopago.getInstallments({
                    "bin": card_number.substr(0, 6),
                    "amount": $("#mp-credit-card #order-total").val()
                }, installmentHandler);
            } else {
                $("#mp-credit-card input[name=card_type]").val('');
                $("#mp-credit-card #card-issuer").val('');
                $("#mp-credit-card #installment").html('<option value="">Número de parcelas</option>');
            }
        });

        $(input).on('focusout', function () {
            if ($("#mp-credit-card #card-type").val() === '') {
                $(".card-number-alert").show('fast');
            } else {
                $(".card-number-alert").hide('fast');
            }
        });
    }

    $(document).on('submit', '#mp-credit-card form', function (e) {
        e.preventDefault();

        var form = {
            cardNumber: document.getElementById('card-number').value,
            securityCode: document.getElementById('cvc').value,
            cardExpirationMonth: document.getElementById('expiry-month').value,
            cardExpirationYear: document.getElementById('expiry-year').value,
            cardholderName: document.getElementById('card-name').value,
            docType: identificationType,
            docNumber: document.getElementById('document').value
        };
        Mercadopago.clearSession();
        Mercadopago.createToken(form, tokenHandler);
    });
};
document.body.appendChild(script);

function issuersHandler(code, response) {
    $("#mp-credit-card #card-issuer").val('');
    if (code === 200) {
        if (response[0]) {
            $("#mp-credit-card #card-issuer").val(response[0].id);
        }
    }
}

function installmentHandler(code, response) {
    $("#mp-credit-card #installment").html('<option value="">Número de parcelas</option>');
    if (code === 200) {
        if (response[0]) {
            var installments_html = '';
            $.each(response[0].payer_costs, function (index, value) {
                installments_html += '<option value="' + value.installments + '_' + value.installment_amount + '_' + value.total_amount + '">' + value.recommended_message + '</option>';
            });
            $("#mp-credit-card #installment").html(installments_html);
        }
    }
}

function tokenHandler(code, response) {
    $("#mp-credit-card #token").val('');
    if (code === 200) {
        if (response.id) {
            $("#mp-credit-card #token").val(response.id);
            $.ajax({
                type: "POST",
                url: base_url + "finalizar-compra/mp-credit-card/process.json",
                data: {
                    'token': response.id,
                    'installment': $("#mp-credit-card #installment").val(),
                    'payment_method_id': $("#mp-credit-card #card-type").val(),
                    'issuer_id': $("#mp-credit-card #card-issuer").val()
                },
                dataType: 'json',
                beforeSend: function () {
                    loading('Processando pagamento...');
                },
                complete: function () {
                    // loadingClose();
                },
                success: function (result) {
                    if (result.data.status) {
                        window.location = result.data.redirect;
                    } else {
                        resetForm();
                        alertDialog(result.data.message, 'error');
                    }
                }
            });
        }
    } else {
        resetForm();
        alertDialog('Cartão inválido, revise o número, código de segurança e data de validade.', 'error');
        return false;
    }
}

function resetForm() {
    $("#mp-credit-card #token").val('');
    $("#mp-credit-card #card-type").val('');
    $("#mp-credit-card #card-issuer").val('');
    $("#mp-credit-card #card-number").val('');
    $("#mp-credit-card #expiry-month").val('');
    $("#mp-credit-card #expiry-year").val('');
    $("#mp-credit-card #cvc").val('');
    $("#mp-credit-card #installment").val('');
}