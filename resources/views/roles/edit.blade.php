@component('components.modal', [
'modal_id' => 'modal-edit-role',
'modal_title' => 'Ubah Role',
])
@slot('modal_body')
<form method="PUT" action="{{ route('roles.update', 0) }}" id="form-edit-role">
	@csrf
	@include('roles._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-edit-role">Simpan</button>
</form>
@endslot
@endcomponent
