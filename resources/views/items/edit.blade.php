@component('components.modal', [
'modal_id' => 'modal-edit-item',
'modal_title' => 'Ubah Barang',
])
@slot('modal_body')
<form method="PUT" action="{{ route('items.update', 0) }}" id="form-edit-item">
	@csrf
	@include('items._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-edit-item">Simpan</button>
</form>
@endslot
@endcomponent
