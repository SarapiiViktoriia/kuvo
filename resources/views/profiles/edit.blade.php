@component('components.modal', [
'modal_id' => 'modal-edit-profile',
'modal_title' => 'Ubah Profil',
])
@slot('modal_body')
<form method="PUT" action="{{ route('profiles.update', 0) }}" id="form-edit-profile">
	@csrf
	@include('profiles._form')	
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default modal-dismiss">Cancel</button>
<button type="button" class="btn btn-primary" id="btn-edit-profile">Simpan</button>
</form>
@endslot
@endcomponent
