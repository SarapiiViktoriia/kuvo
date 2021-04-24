function cleanModal(form, empty) {
	$.each($('input, select, textarea', form), function () {
		var type = $(this).attr('type');
		if (type != 'checkbox') {
			var name_element = $(this).attr('name');
			if (empty) {
				$('#' + name_element).val('').trigger('change');
			}
			$('#div_' + name_element, form).removeClass('has-error');
			$('#label_' + name_element, form).empty();
			$('#div-' + name_element, form).removeClass('has-error');
			$('#error-' + name_element, form).empty();
		}
		if (type == 'checkbox') {
			$(this).prop('checked', false);
			$(this).prop('disabled', false);
		}
	});
}
$(document).on('click', '.modal-dismiss', function (e) {
	e.preventDefault();
	$.magnificPopup.close();
});
