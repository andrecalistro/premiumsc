function addProductWishList(productId) {
    if (productId === undefined) {
        alertDialog('Selecione um produto para adicionar', 'warning');
        return false;
    }

    $.ajax({
        type: "POST",
        url: base_url + "checkout/wish-lists/add.json",
        data: {productId: productId},
        // dataType: 'json',
        async: true,
        beforeSend: function () {
            loading('Adicionando produto a lista de desejo...');
        }
    }).then(function (response) {
        response = JSON.parse(response);
        if (response.redirect) {
            alertDialog(response.message, 'success', response.redirect);
        }
    }).fail(function (jqXHR) {
        let response = JSON.parse(jqXHR.responseText);
        alertDialog(response.message, 'error', response.redirect);
    });
}

$(document).ready(function(){
   $(".garrula-customer-wish-list a").on('click', function(e) {
       let id = $(this).attr('href').split('/').pop();
       addSessionStorage(id);
   });
});

function addSessionStorage(productId)
{
    let sessionWishList = sessionStorage.getItem('wish-list-purchase');
    let products = [];

    if(sessionWishList !== 'undefined') {
        products = JSON.parse(sessionWishList);
    }

    products.push(productId);

    sessionStorage.setValue('wish-list-purchase', products);
}