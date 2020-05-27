$('.btn-view-product-rating').on('click', function () {
    let productsRatingsId = $(this).data('id');

    if (!productsRatingsId || productsRatingsId === undefined) {
        showalert('Avaliação não disponivel', 'error');
        return false;
    }

    $.ajax({
        url: base_url + 'products-ratings/view/' + productsRatingsId + '.json',
        type: "get",
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        success: function (data) {
            showModalProductRating(data.productsRating);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 404) {
                showalert('Avaliação não encontrada', 'error');
                return false;
            }
            showalert(errorThrown, 'error');
        },
        complete: function () {
            closeModalLoading();
        }
    });
});

$('.btn-approve-product-rating').on('click', function () {
    let id = $(this).data('id');

    if (!id || id === undefined) {
        showalert('Avaliação inválida para aprovar', 'error');
        return false;
    }

    $.ajax({
        url: base_url + 'products-ratings/set-status.json',
        type: "post",
        data: {productRatingId: id, status: 2},
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        success: function (data) {
            if (data.status) {
                showalert('Avaliação aprovada', 'success');
                updateRow(id);
                return;
            }
            showalert('Ocorreu um problema ao aprovar essa avaliação. Por favor, tente novamente.', 'error');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            showalert(errorThrown, 'error');
        },
        complete: function () {
            closeModalLoading();
        }
    });
});

$('.btn-disapprove-product-rating').on('click', function () {
    let id = $(this).data('id');

    if (!id || id === undefined) {
        showalert('Avaliação inválida para reprovar', 'error');
        return false;
    }

    $.ajax({
        url: base_url + 'products-ratings/set-status.json',
        type: "post",
        data: {productRatingId: id, status: 3},
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        success: function (data) {
            if (data.status) {
                showalert('Avaliação reprovada', 'success');
                updateRow(id);
                return;
            }
            showalert('Ocorreu um problema ao reprovar essa avaliação. Por favor, tente novamente.', 'error');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            showalert(errorThrown, 'error');
        },
        complete: function () {
            closeModalLoading();
        }
    });
});

function showModalProductRating(productRating) {
    let modal = $("#modal-product-rating");

    modal.find('#text-date').html(productRating.created_formatted);
    modal.find('#text-status').html(productRating.products_ratings_status.name);
    modal.find('#text-order').html(productRating.orders_id);
    modal.find('#text-customer').html(productRating.customer.name);
    modal.find('#text-product').html(productRating.products_name);
    modal.find('#text-rating').html(productRating.rating);
    modal.find('#text-answer').html(productRating.answer);

    modal.find('.btn-disapprove-product-rating').attr('data-id', productRating.id);
    modal.find('.btn-approve-product-rating').attr('data-id', productRating.id);
    modal.find('#text-answer').html(productRating.answer);

    modal.modal('show');
}

function updateRow(productRatingId) {
    $.ajax({
        url: base_url + 'products-ratings/view/' + productRatingId + '.json',
        type: "get",
        dataType: 'json',
        success: function (data) {
            let rating = data.productsRating;
            let html = '<td><a href="/admin/orders/view/' + rating.orders_id + '" target="_blank">' + rating.orders_id + '</a></td>' +
                '<td>' +
                '<span><a href="/admin/customers/view/' + rating.customers_id + '" target="_blank">' + rating.customer.name + '</a></span>' +
                '</td>' +
                '<td><a href="/admin/products/view/' + rating.products_id + '" target="_blank">' + rating.products_name + '</a></td>' +
                '<td>' + rating.rating + '</td>' +
                '<td>' + rating.created_formatted + '</td>' +
                '<td>' + rating.products_ratings_status.name + '</td>' +
                '<td>' +
                '<a href="javascript:void(0)" class="btn btn-sm btn-primary btn-view-product-rating" title="Visualizar" data-id="' + rating.id + '"><i class="fa fa-eye" aria-hidden="true"></i></a>' +
                '<a href="javascript:void(0)" class="btn btn-sm btn-success btn-approve-product-rating" title="Aprovar" data-id="' + rating.id + '"><i class="fa fa-check" aria-hidden="true"></i></a>' +
                '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-disapprove-product-rating" title="Reprovar" data-id="' + rating.id + '"><i class="fa fa-close" aria-hidden="true"></i></a>' +
                '</td>';

            $("#tr-rating-" + rating.id).html(html);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            showalert(errorThrown, 'error');
        }
    });
}