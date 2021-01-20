@component('components.modal', [
'modal_id' => 'modal-edit-item-bundling',
'modal_title' => 'Ubah Inventory Bundling',
])
@slot('modal_body')
<form method="PUT" action="{{ route('item-bundlings.update', 0) }}" id="form-edit-item-bundling">
	@csrf
	@include('item-bundlings._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-edit-item-bundling">Simpan</button>
</form>
@endslot
@endcomponent
