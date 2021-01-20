@component('components.modal', [
'modal_id' => 'modal-add-item-bundling',
'modal_title' => 'Tambah Item Bundling',
])
@slot('modal_body')
<form method="POST" action="{{ route('item-bundlings.store') }}" id="form-add-item-bundling">
	@csrf
	@include('item-bundlings._form')	
</form>
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="submit" class="btn btn-primary" id="btn-add-item-bundling">Simpan</button>
@endslot
@endcomponent
