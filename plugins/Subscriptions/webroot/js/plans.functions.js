$(document).on('click', '.button-simulate-shipping', function (e) {
    e.preventDefault();

    let planId = $(this).attr('data-plan-id');
    let quantity = 1;

    var zipcode = $("input[name=zipcode]").val();

    $.ajax({
        type: "POST",
        url: base_url + "plans/get-quote.json",
        data: {planId: planId, quantity: quantity, zipcode: zipcode},
        dataType: 'json',
        beforeSend: function () {
            loading('Calculando frete...');
        },
        complete: function () {
            loadingClose();
        },
        success: function (result) {
            $("#quote-simulate-plan").html(result.content);
        }
    });
});