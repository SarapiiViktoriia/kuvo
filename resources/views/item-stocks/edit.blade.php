@component('components.modal', [
'modal_id' => 'modal-edit-item-stock',
'modal_title' => 'Ubah Stock',
])
@slot('modal_body')
<form method="PUT" action="{{ route('item-stocks.update', 0) }}" id="form-edit-item-stock">
	@csrf
	@include('item-stocks._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-edit-item-stock">Simpan</button>
</form>
@endslot
@endcomponent
