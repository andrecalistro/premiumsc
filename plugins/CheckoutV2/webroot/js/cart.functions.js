$(document).on('click', '.btn-add-cart', function (e) {
    e.preventDefault();
    var btn = $(this);
    verifyVariation(btn.attr('data-product-id')).then(function (result) {
        if (result.variation_required) {
            var variations = getVariationsValues();
            if (variations.length === 0) {
                loadingClose();
                alertDialog('Por favor, selecione uma opção do produto para comprar', 'error');
            } else {
                product_add_cart(btn, variations);
            }
        } else {
            product_add_cart(btn);
        }
    });
});

$(document).on('click', '.btn-add-cart-out', function (e) {
    e.preventDefault();
    var btn = $(this);
    verifyVariation(btn.attr('data-product-id')).then(function (result) {
        if (result.variation_required) {
            var variations = getVariationsValues();
            if (variations.length === 0) {
                window.location.href = btn.data('product-link');
            } else {
                product_add_cart(btn, variations);
            }
        } else {
            product_add_cart(btn);
        }
    });
});

$(document).on('click', '.js-variation', function (event) {
    event.preventDefault();
    $(this).parent().find('.js-variation').removeClass('active');
    $(this).addClass('active');

    $(this).find('input').prop('checked', true);
});

$(document).on('change', '.quantity-cart-product', function () {
    var carts_id = $(this).data('carts-id');
    var quantity = $(this).val();
    if (carts_id && quantity) {
        loading('Alterando quantidade do produto...');
        window.location.href = base_url + 'checkout/carts/change-quantity/' + carts_id + '/' + quantity;
    } else {
        $(this).reset();
    }
});

$(document).on('click', '.change-quantity-cart', function () {
    let carts_id = $(this).data('carts-id');
    let quantity = $(this).data('quantity');

    loading('Alterando quantidade do produto...');
    window.location.href = base_url + 'checkout/carts/change-quantity/' + carts_id + '/' + quantity;
});

$(document).on('click', '.btn-remove-cart', function(e) {
    if (confirm('Tem certeza que deseja remover esse item do carrinho?')) {
        loading('Removendo produto do carrinho...');
        window.location.href = $(this).data('url');
    }
});

var product_add_cart = function (btn, variations) {
    var products_id = btn.attr('data-product-id');
    var quantity = $("input[data-quantity-product-id=" + products_id + "]").val();

    if (quantity <= 0) {
        alertDialog('A quantidade mínima é 1.', 'info');
        $("input[data-quantity-product-id=" + products_id + "]").focus();
        return false;
    }

    if (!variations) {
        variations = [];
    }

    $.ajax({
        type: "POST",
        url: base_url + "checkout/carts/add.json",
        data: {products_id: products_id, quantity: quantity, variations: variations},
        dataType: 'json',
        beforeSend: function () {
            loading('Adicionando produto ao carrinho...');
            // enableLoading(btn);
        },
        complete: function () {
        },
        success: function (result) {
            if (result.status) {
                window.location = base_url + 'carrinho';
            } else {
                loadingClose();
                // disableLoading(btn);
                alert(result.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertDialog(jqXHR.responseText, 'error');
        }
    });
};

var verifyVariation = function (products_id) {
    return $.ajax({
        type: "POST",
        url: base_url + "checkout/carts/verify-variation/" + products_id + ".json",
        dataType: 'json',
        beforeSend: function () {
            loading('Verificando produto...');
        },
        complete: function () {
        }
    });
};

var getVariationsValues = function () {
    var variations = [];
    if ($(".select-variation").length > 0) {
        $('.select-variation').each(function () {
            if ($(this).val() != '') {
                variations.push($(this).val());
            }
        });
    }
    if ($(".radio-variation").length > 0) {
        $('.radio-variation').each(function () {
            if ($(this).prop('checked') && $(this).val() !== '') {
                variations.push($(this).val());
            }
        });
    }
    return variations;
};

var updateTotal = function () {
    $.ajax({
        type: "POST",
        url: base_url + "checkout/carts/get-total.json",
        dataType: 'json',
        beforeSend: function () {
            loading('Atualizando seu pedido...');
        },
        success: function (result) {
            loadingClose();
            $(".total-price span").html(result.total);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertDialog(jqXHR.responseJSON.message, 'error');
        }
    });
};