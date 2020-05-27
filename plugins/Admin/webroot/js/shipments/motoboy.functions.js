$(document).on("submit", "#modal-add-cep-interval form", function (e) {
    e.preventDefault()
    $.ajax({
        url: $(this).attr('action'),
        type: "post",
        data: $(this).serialize(),
        success: function (response) {
            console.log(response)

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown)
        }
    })
});

$(document).on('click', '#add-row-interval', function (e) {
    e.preventDefault()

    var row_number = $("#list-interval table tbody tr").length;
    var quantity = $(this).attr("data-quantity-row-fields");

    var row = "<tr>";
    row += "<td><input name='interval[" + row_number + "][]' type='text' class='form-control input-zipcode' required></td>";
    row += "<td><input name='interval[" + row_number + "][]' type='text' class='form-control input-zipcode' required></td>";
    row += "<td><input name='interval[" + row_number + "][]' type='number' class='form-control' required></td>";
    row += "<td><input name='interval[" + row_number + "][]' type='text' class='form-control input-price' required></td>";
    row += "<td><input name='interval[" + row_number + "][]' type='text' class='form-control input-price' required></td>";
    row += "<td><a href=\"#\" class=\"btn btn-sm btn-danger remove-interval\"><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
    row += "</tr>";

    $("#list-interval table tbody").append(row)
});

$(document).on('click', '.remove-interval', function (e) {
    e.preventDefault()
    $(this).parent().parent().find('input').remove();
    $(this).parent().parent().hide('fast')
});

$(document).on('submit', '#form-interval', function (e) {
    $("#list-interval table tbody tr[style*='display: none']").remove();

    $(this).submit()
});
