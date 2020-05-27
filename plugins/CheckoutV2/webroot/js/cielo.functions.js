var input = $('#credit-card input[name=card_number], #debit-card input[name=card_number]');
if (input.length > 0) {
    $(document).ready(function () {
        input.payform('formatCardNumber');
    });

    $(document).on('keyup', input, function () {
        var card_type = $.payform.parseCardType(input.val());
        if (card_type !== null && $.payform.validateCardNumber(input.val())) {
            $("#credit-card input[name=card_type], #debit-card input[name=card_type]").val(card_type);
            $("#img-brand-" + card_type).css('opacity', '1');
            input.css('border-color', '#e2e2e2');
        } else {
            $("#credit-card input[name=card_type], #debit-card input[name=card_type]").val('');
            $(".img-brand-credit-card").css('opacity', '0.2');
            input.css('border-color', 'red');
        }
    });
}

$(document).on('submit', "#credit-card form", function (e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: base_url + "finalizar-compra/cielo-credit-card/process.json",
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function () {
            loading('Processando pagamento...');
        },
        complete: function () {
            //loadingClose();
        },
        success: function (result) {
            if (result.data.status) {
                window.location = result.data.redirect;
            } else {
                alertDialog(result.data.message, 'error');
            }
        }
    });
});

$(document).on('submit', "#debit-card form", function (e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: base_url + "finalizar-compra/cielo-debit-card/process.json",
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function () {
            loading('Processando pagamento...');
        },
        complete: function () {
            //loadingClose();
        },
        success: function (result) {
            if (result.data.status) {
                window.location = result.data.redirect;
            } else {
                alertDialog(result.data.message, 'error');
            }
        }
    });
});