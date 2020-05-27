$(document).on('click', '.status-product', function () {
    statusProduct($(this).data('product-id'), $(this));
});

$(document).on('click', '.btn-stay', function () {
    if ($("input[name=stay]").length > 0) {
        $("input[name=stay]").val(true);
    }
    return true;
});

var shouldSubmit = false;

$(document).on('submit', '#form-product', function (e) {
    if (!shouldSubmit) {
        e.preventDefault();
    } else {
        return true;
    }

    var checkCode = $.ajax({
        url: base_url + 'products/check-code.json',
        data: {code: $('input[name=code]').val()},
        type: "post",
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        }
    });

    checkCode.then(function (response) {
        if (response.status) {
            showalert('Já existe um produto cadastrado com esse código', 'danger');
            $('.nav-tabs a[href="#data"]').tab('show');
            $('input[name=code]').focus();
            closeModalLoading();
        } else {
            shouldSubmit = true;
            $('#form-product').submit();
        }
    });
});

var statusProduct = function (product_id, element) {
    $.ajax({
        url: base_url + 'products/status.json',
        data: {product_id: product_id},
        type: "post",
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        success: function (data) {
            if (data.json.status) {
                showalert(data.json.message, 'success');
                element.toggleClass("btn-success btn-default");
            } else {
                showalert(data.json.message, 'error');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown)
        },
        complete: function () {
            closeModalLoading();
        }
    })
};