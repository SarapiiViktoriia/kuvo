@component('components.modal', [
'modal_id' => 'modal-edit-user',
'modal_title' => 'Ubah User',
])
@slot('modal_body')
<form method="PUT" action="{{ route('users.update', 0) }}" id="form-edit-user">
	@csrf
	@include('users._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-edit-user">Simpan</button>
</form>
@endslot
@endcomponent
