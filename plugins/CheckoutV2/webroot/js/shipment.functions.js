$(document).on('click', '.button-simulate-shipping', function (e) {
    e.preventDefault();

    var products_id = $(this).attr('data-product-id');
    var quantity = $("input[data-quantity-product-id=" + products_id + "]").val();

    if (quantity <= 0) {
        showDialog('A quantidade mínima é 1.', 'info');
        $("input[data-quantity-product-id=" + products_id + "]").focus();
        return false;
    }

    var zipcode = $("input[name=zipcode]").val();

    $.ajax({
        type: "POST",
        url: base_url + "checkout/carts/product-quote.json",
        data: {products_id: products_id, quantity: quantity, zipcode: zipcode},
        dataType: 'json',
        beforeSend: function () {
            loading('Calculando frete...');
        },
        complete: function () {
            loadingClose();
        },
        success: function (result) {
            $("#quote-simulate-product").html(result.content);
        }
    });
});

$(document).on('click', '.btn-cart-quote', function (e) {
    cart_quote();
});

$(document).on('submit', '#form-shipment', function (e) {
    e.preventDefault();
    cart_quote();
});

$(document).on('click', '.btn-quote-choose', function () {
    loading('Aplicando custo do frete...');

    let code_shipping = $(this).attr('data-shipping-quote');
    let price_shipping = $(this).attr('data-shipping-quote-price');
    let title_shipping = '- ' + $(this).attr('data-shipping-title').replace('<br>', '');
    let zipcode = $("input[name=zipcode]").val();
    let _this = $(this);
    _this.attr('checked', true);

    $.ajax({
        type: "POST",
        url: base_url + "carrinho/selecionar-frete.json",
        data: {code: code_shipping, price: price_shipping, zipcode: zipcode, title: title_shipping},
        dataType: 'json',
    }).done(function (result) {
        if (result.shipping_price) {
            let html = 'Frete ' + title_shipping;
            html += '<span>' + result.shipping_price + '</span>';
            $(".shipping-text").html(html);
        }
        if (result.total) {
            $(".total-price").html('<span>' + result.total + '</span>')
        }
        loadingClose();
    }).fail(function () {
        loadingClose();
        alertDialog('Ocorreu um erro ao calcular o frete. Tente novamente.', 'error');
    });
});

$(document).on('click', '.change-shipment', function () {
    $("input[name=zipcode]").val('');
    $("#form-shipment").toggle();
    $(".shipping-title").html('');
    $(".shipping-price").html('');
});

var cart_quote = function () {

    var zipcode = $("input[name=zipcode]").val();

    if (zipcode.length === 9) {
        loading('Calculando frete...');
        $.getJSON("//viacep.com.br/ws/" + zipcode.replace("-", "") + "/json/?callback=?", function (dados) {
            if (!("erro" in dados)) {
                $.ajax({
                    type: "POST",
                    url: base_url + "carrinho/calcular-frete.json",
                    data: {zipcode: zipcode, version: 'v2'},
                    dataType: 'json',
                }).done(function (result) {
                    $("#content-shipping-quote").html(result.content);
                    loadingClose();
                })
            } else {
                loadingClose();
                alertDialog('CEP não encontrado.', 'error');
                $("input[name=zipcode]").focus()
            }
        });
    } else {
        loadingClose();
        alertDialog('Digite um CEP válido', 'error');
        $("input[name=zipcode]").focus();
    }
};

$(document).on('click', '.btn-add-cart-with-shipping', function (e) {
    e.preventDefault();
    var self = $(this);

    var products_id = $("#input-product-id").val();
    var quantity = $("input[data-quantity-product-id=" + products_id + "]").val();

    if (quantity <= 0) {
        showDialog('A quantidade mínima é 1.', 'info');
        $("input[data-quantity-product-id=" + products_id + "]").focus();
        return false;
    }

    $.ajax({
        type: "POST",
        url: base_url + "carts/add.json",
        data: {products_id: products_id, quantity: quantity},
        dataType: 'json',
        beforeSend: function () {
            loading();
        },
        complete: function () {
            // loadingClose();
        },
        success: function (result) {
            if (result.status) {
                var code_shipping = self.attr('data-shipping-quote');
                var price_shipping = self.attr('data-shipping-quote-price');
                var title = '- ' + self.attr('data-shipping-title').replace('<br>', '');
                var zipcode = $("input[name=zipcode]").val();

                $.ajax({
                    type: "POST",
                    url: base_url + "carts/quote-chosen.json",
                    data: {code: code_shipping, price: price_shipping, zipcode: zipcode, title: title},
                    dataType: 'json',
                    beforeSend: function () {
                        loading();
                    },
                    complete: function () {
                        // loadingClose();
                    },
                    success: function () {
                        window.location = base_url + 'carrinho';
                    }
                });
            } else {
                showDialog(result.message, 'error');
            }
        }
    });
});