$(document).on('click', '.btn-paid-out', function (e) {
    e.preventDefault();
    var self = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: "get",
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        success: function (data) {
            if (data.json.status) {
                if (data.json.providers_payment_status) {
                    self.removeClass('btn-success').addClass('btn-default');
                    self.closest('tr').find('td.span-providers-payment-status').html('<span class="label label-success">Pago</span>');
                } else {
                    self.removeClass('btn-default').addClass('btn-success');
                    self.closest('tr').find('td.span-providers-payment-status').html('<span class="label label-danger">Não pago</span>');
                }
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