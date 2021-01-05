@component('components.modal', [
'modal_id' => 'modal-add-item-brand',
'modal_title' => 'Tambah Brand Barang',
])
@slot('modal_body')
<form method="POST" action="{{ route('item-brands.store') }}" id="form-add-item-brand">
	@csrf
	@include('item-brands._form')	
</form>
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="submit" class="btn btn-primary" id="btn-add-item-brand">Simpan</button>
@endslot
@endcomponent
