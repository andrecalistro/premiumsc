$(document).on('change', '.select-product-status', function (e) {
    e.preventDefault();

    $.ajax({
        url: base_url + 'products/status.json',
        data: {product_id: $(this).data('products-id'), status: $(this).val()},
        type: "post",
        dataType: 'json',
        beforeSend: function () {
            openModalLoading();
        },
        success: function (data) {
            if(data.json.status){
                showalert(data.json.message, 'success');
            }else{
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