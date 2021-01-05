@component('components.modal', [
'modal_id' => 'modal-destroy-item-brand',
'modal_title' => 'Hapus Brand Barang',
])
@slot('modal_body')
<form method="POST" action="{{ route('item-brands.destroy', 0) }}" id="form-destroy-item-brand">
	@csrf
	@method('DELETE')	
Apakah anda yakin akan menghapus data ini?
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-danger" id="btn-destroy-item-brand">Hapus</button>
</form>
@endslot
@endcomponent
