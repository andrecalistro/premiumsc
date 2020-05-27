if (selected_ids === undefined) {
    var selected_ids = [];
}

$(document).on('click', '.js-add-product', function (event) {
    event.preventDefault();
    var product_id = $(this).parent().parent().find('select[name=product]').val();

    $.ajax({
        url: base_url + 'products/view/' + product_id + '.json',
        type: 'get',
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        success: function (data) {
            var prod = data.product;
            if (selected_ids.indexOf(prod.id) === -1) {
                var select_quantity = '<select class="form-control" name="product_quantity_' + prod.id + '" onchange="changeProductPriceFinal(' + prod.id + ')">';
                prod.stock_available_options.forEach(function (element, index) {
                    select_quantity += '<option value="' + element + '">' + element + '</option>';
                });
                select_quantity += '</select>';
                var html =
                    '<tr data-product-id="' + prod.id + '">' +
                    '<td>' + '<img src="' + prod.thumb_main_image + '" alt="">' + prod.code + ' - ' + prod.name + '</td>' +
                    '<td>' + select_quantity + '</td>' +
                    '<td><input type="text" name="product_price_' + prod.id + '" class="form-control input-price" value="' + number_format(prod.price_final.regular, 2, ",", ".") + '" onblur="changeProductPriceFinal(' + prod.id + ')"></td>' +
                    '<td><input type="text" name="product_price_total_' + prod.id + '" class="form-control input-price product_price" value="' + number_format(prod.price_final.regular, 2, ",", ".") + '" readonly></td>' +
                    '<td>' +
                    '<input type="hidden" name="products[_ids][]" value="' + prod.id + '">' +
                    '<button type="button" class="btn btn-danger btn-sm js-remove-product" title="Excluir"><i class="fa fa-trash" aria-hidden="true"></i></button>' +
                    '</td>' +
                    '</tr>';
                $('.js-products-list').find('tbody').append(html);
                selected_ids.push(prod.id);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        },
        complete: function () {
            closeModalLoading();
            calcTotal();
        }
    })
});

$(document).on('click', '.js-remove-product', function (event) {
    event.preventDefault();
    var product_id = $(this).parent().parent().attr('data-product-id');
    var index = selected_ids.indexOf(parseInt(product_id));

    if (index > -1) {
        selected_ids.splice(index, 1);
        $(this).parent().parent().remove();
    }
});

$(document).ready(function () {
    $("#input-select2-customers, .input-select2-customers").select2({
        theme: "bootstrap",
        placeholder: "Pesquise clientes por nome, CPF ou e-mail",
        width: null,
        ajax: {
            url: base_url + "customers/find.json",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data.items, function (item, key) {
                        return {
                            text: item,
                            id: key
                        }
                    })
                }
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup
        }, // let our custom formatter work
        minimumInputLength: 3
    });

    $(".input-select2-customers").on('change', function () {
        var customers_id = $(this).val();
        $.ajax({
            url: base_url + 'customers/view/' + customers_id + '.json',
            type: 'get',
            dataType: 'json',
            beforeSend: function () {
                openModalLoading();
            },
            success: function (data) {
                customersFieldsFills(data.customer);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                showalert('Cliente não encontrado', 'error');
                customersFieldsFills(null);
            },
            complete: function () {
                closeModalLoading();
            }
        })
    });
});

function calcTotal() {
    var subtotal = 0;
    var products = $("input.product_price");
    var shipping = $("#shipping-total").val();
    var discount = $("#discount").val();
    if (products.length > 0) {
        products.each(function (index, element) {
            subtotal += number_format_brl($(element).val());
        });
    }
    var total = subtotal + number_format_brl(shipping) - number_format_brl(discount);
    $("#shipping_total").html('R$ ' + shipping);
    $("#order_subtotal").html('R$ ' + number_format(subtotal, 2, ",", "."));
    $("#order_total").html('R$ ' + number_format(total, 2, ",", "."));
}

function changeProductPriceFinal(products_id) {
    var input = $("input[name=product_price_" + products_id + "]");
    var quantity = $("select[name=product_quantity_" + products_id + "]").val();
    var unit_price = number_format_brl(input.val());
    var total_price = unit_price * quantity;
    $("input[name=product_price_total_" + products_id + "]").val(number_format(total_price, 2, ",", "."));
    calcTotal();
}

function customersFieldsFills(customer) {
    var fields = ['customers-id', 'customers-addresses-id', 'email', 'document', 'address', 'zipcode', 'number', 'complement', 'neighborhood', 'city', 'state', 'birth-date', 'telephone'];
    if (!customer) {
        fields.forEach(function (element, index, array) {
            $("input#" + element).val('');
        });
    } else {
        $("input#customers-id").val(customer.id);
        $("input#email").val(customer.email);
        $("input#document").val(customer.document);
        $("input#telephone").val(customer.telephone);
        $("input#birth-date").val(customer.birth_date_format);
        $("input#customers-addresses-id").val(customer.customers_addresses[0].id);
        $("input#zipcode").val(customer.customers_addresses[0].zipcode);
        $("input#address").val(customer.customers_addresses[0].address);
        $("input#number").val(customer.customers_addresses[0].number);
        $("input#complement").val(customer.customers_addresses[0].complement);
        $("input#neighborhood").val(customer.customers_addresses[0].neighborhood);
        $("input#city").val(customer.customers_addresses[0].city);
        $("input#state").val(customer.customers_addresses[0].state);
    }
}

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
    };

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

var number_format_brl = function (number) {
    if (number) {
        number = number.replace('.', '');
        number = number.replace(',', '.');
        return parseFloat(number);
    }
    return 0.00;
};