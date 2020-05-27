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
                var html =
                    '<tr data-product-id="' + prod.id + '">' +
                    '<td>' + '<img src="' + prod.thumb_main_image + '" alt="">' + prod.code + ' - ' + prod.name + '</td>' +
                    '<td>' + prod.price_final.formatted + '</td>' +
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