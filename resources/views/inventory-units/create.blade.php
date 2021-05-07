@component('components.modal', [
'modal_id' => 'modal-add-inventory-unit',
'modal_title' => 'Tambah Inventory Unit',
])
@slot('modal_body')
<form method="POST" action="{{ route('inventory-units.store') }}" id="form-add-inventory-unit">
	@csrf
	@include('inventory-units._form')	
</form>
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="submit" class="btn btn-primary" id="btn-add-inventory-unit">Simpan</button>
@endslot
@endcomponent
