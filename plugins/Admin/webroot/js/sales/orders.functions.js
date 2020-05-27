$(document).on('click', '.btn-register-tracking', function (e) {
    e.preventDefault();
    var orders_id = $(this).data('orders-id');
    var status_name = $(this).data('orders-status');
    $("#modal-register-tracking").find($("input[name='orders_id']")).val(orders_id);
    $("#modal-register-tracking").find($("label[for='orders-statuses-id']")).html('Alterar status de <strong>' + status_name + '</strong> para');
    $("#modal-register-tracking").modal('show');
})

$(document).on('submit', '#modal-register-tracking form', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: base_url + "orders/register-tracking.json",
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        complete: function () {
            closeModalLoading();
        },
        success: function (response) {
            if(response.json.status){
                showalert(response.json.message, 'success');
                $("#order-status-name-"+$("#modal-register-tracking").find($("input[name='orders_id']")).val()).html(response.json.status_name);
                $("#modal-register-tracking").modal('hide');
            }else{
                showalert(response.json.message, 'error');
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            showalert('Ocorreu um erro. Por favor, tente novamente');
        }
    })
})

