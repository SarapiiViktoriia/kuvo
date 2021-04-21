@component('components.modal', [
	'modal_id'    => 'modal-add-supplier',
	'modal_title' => 'tambah pemasok produk'
])
	@slot('modal_body')
		<form method="post" action="{{ route('suppliers.store') }}" id="form-add-supplier">
			@csrf
			@include('suppliers._form')
		</form>
	@endslot
	@slot('modal_button')
		<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
		<button type="submit" class="btn btn-primary" id="btn-add-supplier"><span class="fa fa-save"></span> {{ ucwords(__('simpan')) }}</button>
	@endslot
@endcomponent
