$(document).on('submit', "#credit-card form", function (e) {
    e.preventDefault();

    var cc = new Moip.CreditCard({
        number: $("#credit-card #card-number").val().replace(' ', ''),
        cvc: $("#credit-card #cvc").val(),
        expMonth: $("#credit-card #expiry-month").val(),
        expYear: $("#credit-card #expiry-year").val(),
        pubKey: $("#credit-card #public-key").val(),
        name: $("#credit-card #card-name").val(),
        document: $("#credit-card #document").val(),
        birth_date: $("#credit-card #birth-date").val()
    });

    if (cc.isValid()) {
        $("#hash").val(cc.hash());
    } else {
        $("#hash").val('');
        alert('Cartão inválido, revise o número, codigo de segurança e data de válidade.');
        return false;
    }

    $.ajax({
        type: "POST",
        url: base_url + "finalizar-compra/moip/credit-card.json",
        data: $(this).serialize(),
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
                alert(result.data.message);
            }
        }
    })
});

// $(document).on('submit', "#ticket form", function (e) {
//     loading('Processando pagamento...');
// });

var input = $('#credit-card input[name=card_number]');
if (input.length > 0) {
    $(document).ready(function () {
        input.payform('formatCardNumber');
    });

    $(document).on('keyup', input, function () {
        var card_type = $.payform.parseCardType(input.val());
        if (card_type !== null && $.payform.validateCardNumber(input.val())) {
            $("#credit-card input[name=card_type]").val(card_type);
        } else {
            $("#credit-card input[name=card_type]").val('');
        }
    });
}