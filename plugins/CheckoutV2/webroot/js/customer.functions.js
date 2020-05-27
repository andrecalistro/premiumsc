$(document).on('keyup', '.input-zipcode', function () {
    loadAddressData($(this).val());
});

$(document).on('submit', '#form-email-marketing', function (e) {
    e.preventDefault();
    saveEmailMarketing($(this).serialize()).then(function (result) {
        if (result.json.status) {
            $("#form-email-marketing").find('input[name="name"]').val('');
            $("#form-email-marketing").find('input[name="email"]').val('');
        } else {
            $("#form-email-marketing").find('input[name="email"]').focus();
        }
    });
});

$(document).on('submit', '#form-customer-force-update-data', function (e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: base_url + "checkout-v2/customers/force-update-data.json",
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function () {
            loading('Salvando seus dados...');
        },
        complete: function () {
        },
        success: function (result) {
            if (result.json.status) {
                alertDialog(result.json.message, 'success');
                $("#modal-force-update-data").modal('hide');
                return true;
            } else {
                alertDialog(result.json.message, 'error');
                return false;
            }
        }
    });
});

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

function loadAddressData(zipcode) {
    zipcode = zipcode.replace("-", "");

    if (zipcode.length == 8) {
        loading('Procurando endereço...');

        $.getJSON("//viacep.com.br/ws/" + zipcode + "/json/?callback=?", function (dados) {
            if (!("erro" in dados)) {
                //Atualiza os campos com os valores da consulta.
                $(".input-address").val(dados.logradouro);
                $(".input-neighborhood").val(dados.bairro);
                $(".input-city").val(dados.localidade);
                $(".input-state").val(dados.uf);
                $(".input-number").focus();
                loadingClose();
            } else {
                alertDialog('CEP não encontrado', 'error');
            }
        });
    }
}

var saveEmailMarketing = function (data) {
    return $.ajax({
        type: "POST",
        url: base_url + "newsletter.json",
        data: data,
        dataType: 'json',
        beforeSend: function () {
            loading('Salvando seus dados...');
        },
        complete: function () {
        },
        success: function (result) {
            if (result.status) {
                alertDialog(result.message, 'success');

                return true;
            } else {
                alertDialog(result.message, 'error');
                return false;
            }
        }
    });
};