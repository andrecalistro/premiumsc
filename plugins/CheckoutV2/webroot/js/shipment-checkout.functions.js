$("input[name=shipping]").on('change', function () {
    let _input = $(this);
    let _totalPrice = $('.total-price');
    let value = _input.data('value');
    let subtotal = _totalPrice.data('subtotal');
    let total = value + subtotal;
    let text = _input.data('text');
    let title = _input.data('title');
    $(".shipping-text").html(title + '<span>' + text + '</span>');
    _totalPrice.find('span').html('R$ ' + number_format(total, 2, ",", "."));
});

$(".confirm-shipment").on('click', function () {
    let code = $("input[name=shipping]:checked").val();
    if (code === undefined) {
        alertDialog('Selecione uma opção de envio', 'error');
        return false;
    }
    loading();
    $("#form-shipment #data").val(code);
    $("#form-shipment").submit();
});

$(".address_choose").on('change', function () {
    loading();
    window.location.href = base_url + 'finalizar-compra/forma-de-envio/' + $(this).val();
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