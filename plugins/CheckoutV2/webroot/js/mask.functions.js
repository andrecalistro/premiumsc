$.jMaskGlobals.watchDataMask = true;

$(document).ready(function () {
    $(".mask-date").mask("00/00/0000");
    $(".mask-datetime").mask("00/00/0000 00:00");
    $(".mask-cpf").mask("000.000.000-00");
    $(".mask-cnpj").mask("00.000.000/0000-00");
    $(".mask-zipcode").mask("00000-000");
    $(".mask-hour").mask("00:00");
    $('.mask-size').mask("###0,00", {reverse: true});

    var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $(".mask-telephone").mask(SPMaskBehavior, spOptions);


    if ($('.input-zipcode').length > 0) {
        var zipcode = $('.input-zipcode').val();
        if (zipcode != '') {
            loadAddressData(zipcode);
        }
    }
});