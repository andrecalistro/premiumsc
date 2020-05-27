$(document).on('click', '.btn-change-status-shipment', function () {
    let id = $(this).data('id');
    let statusId = $(this).data('status-id');

    let _modal = $("#modal-register-tracking");

    let subscriptionShipmentId = _modal.find("input[name=subscriptions_shipments_id]");
    let selectStatus = _modal.find("select[name=statuses_id]");
    let formGroupTracking = $("#form-group-tracking");

    formGroupTracking.hide();

    subscriptionShipmentId.val(id);
    selectStatus.val(statusId);
    _modal.modal('show');
});

$(document).on('change', '#statuses-id', function () {
    let value = $(this).val();
    let formGroupTracking = $("#form-group-tracking");

    formGroupTracking.hide();
    if (value == 2) {
        formGroupTracking.show();
    }
});

$(document).on('click', '.btn-save-shipment-status', function () {
    let _modal = $("#modal-register-tracking");
    let subscriptionShipmentId = _modal.find("input[name=subscriptions_shipments_id]").val();
    let statusId = _modal.find("select[name=statuses_id]").val();
    let inputTracking = _modal.find('input[name=tracking]');
    let tracking = '';

    if (statusId === undefined || statusId <= 0) {
        showalert('Selecione um status', 'error');
        return false;
    }

    if (statusId == 2) {
        tracking = inputTracking.val();
        if (tracking === '') {
            showalert('Preencha o codigo de rastreio', 'error');
            return false;
        }
    }

    let statusName = $("#subscriptionShipmentName-" + subscriptionShipmentId);

    $.ajax({
        url: base_url + 'plans/shipment-status.json',
        data: {statusId: statusId, subscriptionShipmentId: subscriptionShipmentId, tracking: tracking},
        type: "post",
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        success: function (data) {
            statusName.html(data.statusName);
            showalert('Status do envio alterado', 'success');
            _modal.modal('hide');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            showalert(jqXHR.responseText, 'error');
        },
        complete: function () {
            closeModalLoading();
        }
    })
});
