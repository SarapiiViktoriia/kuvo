@component('components.modal', [
	'modal_id'    => 'modal-add-item-group',
	'modal_title' => 'tambah kategori produk',
])
	@slot('modal_body')
		<form method="post" action="{{ route('item-groups.store') }}" id="form-add-item-group">
			@csrf
			@include('item-groups._form')
		</form>
	@endslot
	@slot('modal_button')
		<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
		<button type="submit" class="btn btn-primary" id="btn-add-item-group"><span class="fa fa-save"></span> {{ ucwords(__('simpan')) }}</button>
	@endslot
@endcomponent
