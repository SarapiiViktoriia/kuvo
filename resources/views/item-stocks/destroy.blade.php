@component('components.modal', [
'modal_id' => 'modal-destroy-item-stock',
'modal_title' => 'Hapus Item Stock',
])
@slot('modal_body')
<form method="POST" action="{{ route('item-stocks.destroy', 0) }}" id="form-destroy-item-stock">
	@csrf
	@method('DELETE')	
Apakah anda yakin akan menghapus data ini?
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-danger" id="btn-destroy-item-stock">Hapus</button>
</form>
@endslot
@endcomponent
