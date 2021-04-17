@component('components.modal', [
	'modal_id'    => 'modal-add-item-brand',
	'modal_title' => 'Tambah Merek',
])
	@slot('modal_body')
		<form method="post" action="{{ route('item-brands.store') }}" id="form-add-item-brand">
			@csrf
			@include('item-brands._form')
		</form>
	@endslot
	@slot('modal_button')
		<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
		<button type="submit" class="btn btn-primary" id="btn-add-item-brand"><span class="fa fa-save"></span> {{ ucwords(__('simpan')) }}</button>
	@endslot
@endcomponent
