@component('components.modal', [
'modal_id' => 'modal-destroy-item-group',
'modal_title' => 'Hapus Grup Barang',
])
@slot('modal_body')
<form method="POST" action="{{ route('item-groups.destroy', 0) }}" id="form-destroy-item-group">
	@csrf
	@method('DELETE')	
Apakah anda yakin akan menghapus data ini?
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-danger" id="btn-destroy-item-group">Hapus</button>
</form>
@endslot
@endcomponent
