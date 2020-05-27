$(document).on('keyup', '#form-coupon-cart input#code', function () {
    var self = $(this);
    self.val(self.val().toUpperCase());
});

$(document).on('click', '.btn-coupon-cart', function (e) {
    let inputCode = $("input#code");
    let code = inputCode.val().toUpperCase();
    console.log(code, code.length);
    if(code.length === 0) {
        alertDialog("Cupom inválido", 'error');
        return;
    }

    inputCode.val(code);
    validateCart(code).then(updateDiscountCart);
});

$(document).on('click', '.change-coupon', function () {
    $("input#code").val('');
    $("#form-coupon-cart").toggle();
    $(".coupon-discount").html('');
});

$(document).on('submit', '#form-coupon-cart', function (e) {
    e.preventDefault();
    var code = $(this).find("input#code").val().toUpperCase();
    $(this).find("input#code").val(code);
    validateCart(code).then(updateDiscountCart);
});

var validateCart = function (code) {
    return $.ajax({
        type: "POST",
        url: base_url + "checkout/coupons/validate-cart.json",
        data: {code: code},
        dataType: 'json',
        beforeSend: function () {
            loading('Estamos validando seu cupom...');
        },
        success: function (result) {
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertDialog(jqXHR.responseText, 'error');
        }
    });
};

var updateDiscountCart = function () {
    return $.ajax({
        type: "GET",
        url: base_url + "checkout/coupons/get-discount.json",
        dataType: 'json',
        beforeSend: function () {
            loading('Aplicando desconto...');
        },
        success: function (result) {
            console.log(result);
            $(".coupon-discount span").html('- ' + result.discount.formatted);
            updateTotal();
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertDialog(jqXHR.responseJSON.message, 'error');
        }
    });
};