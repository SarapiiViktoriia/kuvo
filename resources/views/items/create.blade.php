@component('components.modal', [
'modal_id' => 'modal-add-item',
'modal_title' => 'Tambah Barang',
])
@slot('modal_body')
<form method="POST" action="{{ route('items.store') }}" id="form-add-item">
	@csrf
	@include('items._form')	
</form>
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="submit" class="btn btn-primary" id="btn-add-item">Simpan</button>
@endslot
@endcomponent
