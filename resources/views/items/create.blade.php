@component('components.modal', [
	'modal_id'    => 'modal-add-item',
	'modal_title' => 'tambah produk'
])
	@slot('modal_body')
		<form action="{{ route('items.store') }}" method="post" id="form-add-item">
			@csrf
			@include('items._form')
		</form>
	@endslot
	@slot('modal_button')
		<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
		<button type="submit" class="btn btn-primary" id="btn-add-item"><span class="fa fa-save"></span> {{ ucwords(__('simpan')) }}</button>
	@endslot
@endcomponent
