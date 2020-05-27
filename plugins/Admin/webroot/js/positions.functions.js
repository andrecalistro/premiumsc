$(document).on('click', '.btn-change-position', function () {
    var input = $(this).closest('.input-group').find('input');

    $.ajax({
        url: base_url + 'positions/change-position.json',
        data: {id: input.data('product-position-id'), order_show: input.val()},
        type: "post",
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        success: function (data) {
            if (data.json.status) {
                showalert(data.json.message, 'success');
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
});