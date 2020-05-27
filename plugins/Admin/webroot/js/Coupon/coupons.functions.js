$(document).on('change', '#type', function () {
	var value = $("#type").val();
	if(value == 'free_shipping'){
		$("#value").val("");
		$("#value").prop("readonly", true);
	} else {
		$("#value").prop("readonly", false);
	}
});