@component('components.modal', [
'modal_id' => 'modal-add-item-stock',
'modal_title' => 'Tambah Item Stock',
])
@slot('modal_body')
<form method="POST" action="{{ route('item-stocks.store') }}" id="form-add-item-stock">
	@csrf
	@include('item-stocks._form')	
</form>
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="submit" class="btn btn-primary" id="btn-add-item-stock">Simpan</button>
@endslot
@endcomponent
