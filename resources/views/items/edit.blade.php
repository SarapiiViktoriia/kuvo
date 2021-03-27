@component('components.modal', [
	'modal_id'    => 'modal-edit-item',
	'modal_title' => 'perbarui informasi produk'
])
	@slot('modal_body')
		<form action="{{ route('suppliers.update', 0) }}" method="put" id="form-edit-item">
			@csrf
			@include('items._form')
	@endslot
	@slot('modal_button')
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
			<button type="button" class="btn btn-primary" id="btn-edit-item"><span class="fa fa-edit"></span> {{ ucwords(__('perbarui')) }}</button>
		</form>
	@endslot
@endcomponent
