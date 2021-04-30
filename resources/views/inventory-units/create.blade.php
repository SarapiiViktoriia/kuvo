@component('components.modal', [
	'modal_id'    => 'modal-add-inventory-unit',
	'modal_title' => 'menambah satuan',
])
	@slot('modal_body')
		<form method="post" action="{{ route('inventory-units.store') }}" id="form-add-inventory-unit">
			@csrf
			@include('inventory-units._form')
		</form>
	@endslot
	@slot('modal_button')
		<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
		<button type="submit" class="btn btn-primary" id="btn-add-inventory-unit"><span class="fa fa-save"></span> {{ ucwords(__('simpan')) }}</button>
	@endslot
@endcomponent
