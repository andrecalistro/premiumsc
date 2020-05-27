$(document).ready(function () {
    let discountGroupId = $("input#id").val();
    $('#name').autocomplete({
        source: base_url + 'discounts-groups/find-customer/' + discountGroupId,
        minLenght: 4,
        select: function (event, ui) {
            event.preventDefault();
            $("#name").val(ui.item.label);
            $("#customers-id").val(ui.item.id);
        }, focus: function (event, ui) {
            event.preventDefault();
            $("#name").val(ui.item.label);
        }
    });
});