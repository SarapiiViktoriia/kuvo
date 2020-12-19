function cleanModal(form, empty){
	$.each($('input, select, textarea', form), function(){
		var type = $(this).attr('type');
		if (type != 'checkbox') {
			var name_element = $(this).attr('name');
			if (empty) {
				$('#'+name_element).val('').trigger('change');
			}
			$('#div_'+name_element, form).removeClass('has-error');
			$('#label_'+name_element, form).empty();
		}
	});
}
$(document).on('click', '.modal-dismiss', function (e) {
	e.preventDefault();
	$.magnificPopup.close();
});
