var generateApiToken = function () {
    $.ajax({
        url: base_url + 'stores/generate-api-token.json',
        type: "get",
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        success: function (data) {
            console.log(data);
            if(data.token){
                $("#api-token").val(data.token);
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