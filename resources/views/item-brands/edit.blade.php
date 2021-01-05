@component('components.modal', [
'modal_id' => 'modal-edit-item-brand',
'modal_title' => 'Ubah Brand Barang',
])
@slot('modal_body')
<form method="PUT" action="{{ route('item-brands.update', 0) }}" id="form-edit-item-brand">
	@csrf
	@include('item-brands._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-edit-item-brand">Simpan</button>
</form>
@endslot
@endcomponent
