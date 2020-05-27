$(document).on('click', '.btn-quote-choose-checkout', function (e) {
    e.preventDefault();

    var code_shipping = $(this).attr('data-shipping-quote');
    var price_shipping = $(this).attr('data-shipping-quote-price');
    var zipcode = $(this).attr('data-shipping-zipcode');

    $.ajax({
        type: "POST",
        url: base_url + "carts/quote-chosen.json",
        data: {code: code_shipping, price: price_shipping, zipcode: zipcode},
        dataType: 'json'
    }).done(function (result) {
        if (result) {
            window.location = base_url + 'finalizar-compra/pagamento';
        }
    });
});

var input_debit = $('#online-debit input[name=card_number]');
if (input_debit.length > 0) {
    $(document).ready(function () {
        input_debit.payform('formatCardNumber');
    });

    $(document).on('keyup', input_debit, function () {
        var card_type = $.payform.parseCardType(input_debit.val());
        if (card_type !== null && $.payform.validateCardNumber(input_debit.val())) {
            $("#online-debit input[name=card_type]").val(card_type);
        } else {
            $("#online-debit input[name=card_type]").val('');
        }
    });
}

var verifyDiscount = function (method) {
    $.ajax({
        type: "POST",
        url: base_url + "checkout/checkout/discount.json",
        data: {method: method},
        dataType: 'json',
        beforeSend: function () {
            loading();
        },
        success: function (result) {
            $("#discounts").html('');
            if (result.discount.status) {
                generateHtmlDiscount(result.discount.discounts);
            }
            $(".total .text-right").html(result.discount.total_format);
            $(".total-order").html(result.discount.total_format);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        },
        complete: function () {
            // loadingClose();
        }
    });
};

var number_format = function (number, decimals, decPoint, thousandsSep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number;
    var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
    var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep;
    var dec = (typeof decPoint === 'undefined') ? '.' : decPoint;
    var s = '';

    var toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec);
        return '' + (Math.round(n * k) / k)
            .toFixed(prec)
    }

    // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0')
    }

    return s.join(dec)
};

$(document).ready(function () {
    loadPayment();
    /*$.ajax({
        type: "POST",
        url: base_url + "checkout/checkout/discount.json",
        data: {method: 'none'},
        dataType: 'json',
        beforeSend: function () {
            loading();
        },
        success: function (result) {
            $("#discounts").html('');
            if (result.discount.status) {
                generateHtmlDiscount(result.discount.discounts);
            }
            $(".total .text-right").html(result.discount.total_format);
            $(".total-order").html(result.discount.total_format);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertDialog('Ocorreu um problema ao carregar seu metodo de pagamento, por favor tente novamente.', 'error');
        },
        complete: function () {
            loadingClose();
        }
    });*/
});

function generateHtmlDiscount(discounts) {
    let html = '';
    for (let i = 0; i < discounts.length; i++) {
        html += '<div class="row border-bottom pb-2 mb-2">';
            html += '<div class="col-8 text-left">';
                html += '<strong>' + discounts[i].discount_text + '</strong>';
            html += '</div>';
            html += '<div class="col-4 text-right">- ' + discounts[i].discount + '</div>';
        html += '</div>';
    }
    $("#discounts").html(html);
}

function loadPayment(){
    let method = $("#payment-code").val();

    verifyDiscount(method);

    $.ajax({
        type: "POST",
        url: base_url + "finalizar-compra/carregar-pagamento.json",
        data: {payment_method: method},
        dataType: 'json',
        async: true,
        beforeSend: function () {
            loading('Carregando forma de pagamento...');
        },
        success: function (result) {
            $("#payment_method").html(result.content);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertDialog('Ocorreu um problema ao carregar seu metodo de pagamento, por favor tente novamente.', 'error');
        },
        complete: function () {
            loadingClose();
        }
    });
}