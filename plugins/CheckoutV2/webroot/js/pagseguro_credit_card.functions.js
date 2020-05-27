let input = $('#credit-card input[name=card_number]');
if (input.length > 0) {
    $(document).ready(function () {
        input.payform('formatCardNumber');
    });

    $(document).on('keyup', input, function () {
        let card_type = $.payform.parseCardType(input.val());
        if (card_type !== null && $.payform.validateCardNumber(input.val())) {
            $("#credit-card input[name=card_type]").val(card_type);
        } else {
            $("#credit-card input[name=card_type]").val('');
        }
    });
}