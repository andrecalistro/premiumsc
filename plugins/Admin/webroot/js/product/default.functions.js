$(document).on('change', '#variations .select-variations-groups', function () {
    var select = $(this);
    var variations_groups_id = select.val();
    var variations_groups_name = select.find("option:selected").text();

    if (variations_groups_id > 0 && check_variation_exists(variations_groups_id) == 0) {
        $('.li-variations-groups').removeClass('active');
        var html = '<li id="li-variations-groups-' + variations_groups_id + '" class="li-variations-groups active" data-variations-groups-id="' + variations_groups_id + '">';
        html += variations_groups_name + ' <i class="fa fa-close pull-right" aria-hidden="true" data-variations-groups-id="' + variations_groups_id + '"></i>';
        html += '</li>';
        get_variation_group_content(variations_groups_id);
    }

    $("#variations .list-variations-groups").prepend(html);
    $(this).val('');
});

$(document).on('click', '#variations .li-variations-groups', function () {
    if (!$(this).hasClass('active')) {
        var variations_groups_id = $(this).data('variations-groups-id');
        $('.li-variations-groups').removeClass('active');
        $("#variations .list-variations-content .variation-content").hide('fast');
        $(this).addClass('active');
        $("#variations .list-variations-content #variation-content-" + variations_groups_id).show('fast');
    }
});

$(document).on('click', '#variations .li-variations-groups .fa-close', function () {
    var parent = $(this).closest('#variations .li-variations-groups');
    var variations_groups_id = $(this).data('variations-groups-id');
    $("#variations .list-variations-content #variation-content-" + variations_groups_id).remove();
    delete_variation_group($(this));
    parent.remove();
});

$(document).on('click', '#variations .variation-content .btn-add-variation', function () {
    var variations_groups_id = $(this).data('variations-groups-id');
    add_variation(variations_groups_id);
});

$(document).on('click', '#variations .variation-content .btn-delete-variation', function () {
    delete_variation($(this));
});

var check_variation_exists = function (variations_groups_id) {
    return $("#variations .list-variations-groups").find('li#li-variations-groups-' + variations_groups_id).length;
};

var get_variation_group_content = function (variations_groups_id) {
    if (variations_groups_id > 0) {
        $.ajax({
            url: base_url + 'variations-groups/get-content.json',
            data: {variations_groups_id: variations_groups_id},
            type: "post",
            dataType: 'json',
            beforeSend: function () {
                openModalLoading();
            },
            success: function (data) {
                if (data.json.status) {
                    $("#variations .list-variations-content .variation-content").hide('fast');
                    $("#variations .list-variations-content").append(data.json.content);
                    add_variation(variations_groups_id);
                } else {
                    alert('Não foi possivel renderizar esse grupo de variação. Por favor, tente novamente.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            },
            complete: function () {
                closeModalLoading();
            }
        })
    }
};

var add_variation = function (variations_groups_id) {
    if (variations_groups_id > 0) {
        $.ajax({
            url: base_url + 'variations-groups/new-variation-content.json',
            data: {variations_groups_id: variations_groups_id},
            type: "post",
            dataType: 'json',
            beforeSend: function () {
                openModalLoading();
            },
            success: function (data) {
                if (data.json.status) {
                    $("#variations .list-variations-content #variation-content-" + variations_groups_id + ' table tbody').append(data.json.content);
                } else {
                    alert('Não foi possivel renderizar esse grupo de variação. Por favor, tente novamente.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            },
            complete: function () {
                closeModalLoading();
            }
        })
    }
};

var delete_variation = function (element) {
    if (element.data('products-variations-id')) {
        $.ajax({
            url: base_url + 'products/delete-variations.json',
            data: {products_variations_id: element.data('products-variations-id')},
            type: "post",
            dataType: 'json',
            beforeSend: function () {
                openModalLoading();
            },
            success: function (data) {

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            },
            complete: function () {
                closeModalLoading();
            }
        })
    }
    element.closest('tr').remove();
};

var delete_variation_group = function (element) {
    if (element.data('products-variations-groups-id')) {
        $.ajax({
            url: base_url + 'products/delete-variations-groups.json',
            data: {variations_groups_id: element.data('products-variations-groups-id')},
            type: "post",
            dataType: 'json',
            beforeSend: function () {
                openModalLoading();
            },
            success: function (data) {

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            },
            complete: function () {
                closeModalLoading();
            }
        });
    }
};

$(document).ready(function(){
    $(function() {
        $("#weight").maskMoney({allowNegative: false, thousands:'', decimal:',', precision:3, affixesStay: false});
    })
});


