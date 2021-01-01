@component('components.modal', [
'modal_id' => 'modal-add-supplier',
'modal_title' => 'Tambah Supplier',
])
@slot('modal_body')
<form method="POST" action="{{ route('suppliers.store') }}" id="form-add-supplier">
	@csrf
	@include('suppliers._form')	
</form>
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="submit" class="btn btn-primary" id="btn-add-supplier">Simpan</button>
@endslot
@endcomponent
