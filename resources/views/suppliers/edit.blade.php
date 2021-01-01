@component('components.modal', [
'modal_id' => 'modal-edit-supplier',
'modal_title' => 'Ubah Supplier',
])
@slot('modal_body')
<form method="PUT" action="{{ route('suppliers.update', 0) }}" id="form-edit-supplier">
	@csrf
	@include('suppliers._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-edit-supplier">Simpan</button>
</form>
@endslot
@endcomponent
