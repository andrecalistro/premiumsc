$(document).on('change', '.input-type-customer', function () {
    manipuleFormCustomer($(this).val());
});

$(document).ready(function () {
    if ($('input[name=customers_types_id]').length > 0) {
        manipuleFormCustomer($('input[name=customers_types_id]:checked').val());
    }
});

function manipuleFormCustomer(type) {
    if (type == 1) {
        $('#form-block-person').css('display', 'block');
        $('#form-block-company').css('display', 'none');
        $('#form-block-person').find('input, select').removeAttr('disabled');
        $('#form-block-company').find('input, select').attr('disabled', true);
    }
    if (type == 2) {
        $('#form-block-company').css('display', 'block');
        $('#form-block-person').css('display', 'none');
        $('#form-block-person').find('input, select').attr('disabled', true);
        $('#form-block-company').find('input, select').removeAttr('disabled');
    }
}