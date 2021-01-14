@component('components.modal', [
'modal_id' => 'modal-add-role',
'modal_title' => 'Tambah Role',
])
@slot('modal_body')
<form method="POST" action="{{ route('roles.store') }}" id="form-add-role">
	@csrf
	@include('roles._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-add-role">Simpan</button>
</form>
@endslot
@endcomponent
