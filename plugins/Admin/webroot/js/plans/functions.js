$(document).on('click', '.btn-stay', function () {
    if ($("input[name=stay]").length > 0) {
        $("input[name=stay]").val(true);
    }
    return true;
});

$(document).on('click', '.status-plan', function () {
    statusPlan($(this).data('plan-id'), $(this));
});

var statusPlan = function (plan_id, element) {
    $.ajax({
        url: base_url + 'plans/status.json',
        data: {plan_id: plan_id},
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