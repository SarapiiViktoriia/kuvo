@component('components.modal', [
'modal_id' => 'modal-destroy-item',
'modal_title' => 'Hapus Barang',
])
@slot('modal_body')
<form method="POST" action="{{ route('items.destroy', 0) }}" id="form-destroy-item">
	@csrf
	@method('DELETE')	
Apakah anda yakin akan menghapus data ini?
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-danger" id="btn-destroy-item">Hapus</button>
</form>
@endslot
@endcomponent
