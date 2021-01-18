@component('components.modal', [
'modal_id' => 'modal-edit-inventory-unit',
'modal_title' => 'Ubah Inventory Unit',
])
@slot('modal_body')
<form method="PUT" action="{{ route('inventory-units.update', 0) }}" id="form-edit-inventory-unit">
	@csrf
	@include('inventory-units._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-edit-inventory-unit">Simpan</button>
</form>
@endslot
@endcomponent
