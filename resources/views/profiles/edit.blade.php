@component('components.modal', [
'modal_id' => 'modal-edit-profile',
'modal_title' => 'Ubah Profil',
])
@slot('modal_body')
<form method="POST" action="{{ route('profiles.update', 0) }}" id="form-edit-profile">
	@csrf
	@method('PUT')
	@include('profiles._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-edit-profile">Simpan</button>
</form>
@endslot
@endcomponent
