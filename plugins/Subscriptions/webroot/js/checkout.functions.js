$(document).on('click', '#payment-methods .method', function () {
    let method = $(this).attr('data-value');

    $.ajax({
        type: "POST",
        url: base_url + "subscriptions/plano/carregar-pagamento.json",
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
});

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