@component('components.modal', [
'modal_id' => 'modal-destroy-inventory-unit',
'modal_title' => 'Hapus Inventory Unit',
])
@slot('modal_body')
<form method="POST" action="{{ route('inventory-units.destroy', 0) }}" id="form-destroy-inventory-unit">
	@csrf
	@method('DELETE')	
Apakah anda yakin akan menghapus data ini?
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-danger" id="btn-destroy-inventory-unit">Hapus</button>
</form>
@endslot
@endcomponent
