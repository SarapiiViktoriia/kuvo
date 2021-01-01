@component('components.modal', [
'modal_id' => 'modal-destroy-supplier',
'modal_title' => 'Hapus Supplier',
])
@slot('modal_body')
<form method="POST" action="{{ route('suppliers.destroy', 0) }}" id="form-destroy-supplier">
	@csrf
	@method('DELETE')	
Apakah anda yakin akan menghapus data ini?
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-danger" id="btn-destroy-supplier">Hapus</button>
</form>
@endslot
@endcomponent
