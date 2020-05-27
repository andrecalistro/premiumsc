$(document).on('click', '#variations-groups-form .add-variation-item', function (e) {
    e.preventDefault();

    var html = '<tr>';
    html += '<td valign="middle"><div class="input text required"><input type="text" name="variations[][name]" class="form-control" required="required" maxlength="255" id="variations-name"></div></td>';
    html += '<td align="right"><a href="javascript:void(0)" class="btn btn-sm btn-danger remove-variation-item" title="Excluir Variação"><i class="fa fa-trash-o"></i></a></td>';
    html += '</tr>';

    $("#variations-groups-form #list-variations tbody").append(html)
});

$(document).on('click', '#variations-groups-form .remove-variation-item', function (e) {
    e.preventDefault();

    var input = $(this);
    var id = input.data('variation-id');


    if (id > 0) {
        $.ajax({
            url: base_url + 'variations-groups/delete-variation/' + id + '.json',
            type: "post",
            beforeSend: function () {
                openModalLoading()
            },
            complete: function () {
                closeModalLoading()
            },
            success: function (data) {
                if (data.response.status) {
                    input.parent().parent().remove()
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            }
        })
    } else {
        input.parent().parent().remove()
    }
});