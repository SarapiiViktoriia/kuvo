@component('components.modal', [
	'modal_id'    => 'modal-edit-supplier',
	'modal_title' => 'perbarui informasi pemasok'
])
	@slot('modal_body')
		<form method="put" action="{{ route('suppliers.update', 0) }}" id="form-edit-supplier">
			@csrf
			@include('suppliers._form')
	@endslot
	@slot('modal_button')
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
			<button type="button" class="btn btn-primary" id="btn-edit-supplier"><span class="fa fa-edit"></span> {{ ucwords(__('perbarui')) }}</button>
		</form>
	@endslot
@endcomponent
