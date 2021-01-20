@component('components.modal', [
'modal_id' => 'modal-destroy-item-bundling',
'modal_title' => 'Hapus Item Bundling',
])
@slot('modal_body')
<form method="POST" action="{{ route('item-bundlings.destroy', 0) }}" id="form-destroy-item-bundling">
	@csrf
	@method('DELETE')	
Apakah anda yakin akan menghapus data ini?
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-danger" id="btn-destroy-item-bundling">Hapus</button>
</form>
@endslot
@endcomponent
