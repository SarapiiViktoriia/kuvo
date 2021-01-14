@component('components.modal', [
'modal_id' => 'modal-add-profile',
'modal_title' => 'Tambah Profil',
])
@slot('modal_body')
<form method="POST" action="{{ route('profiles.store') }}" id="form-add-profile">
	@csrf
	@include('profiles._form')	
</form>
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-primary" id="btn-add-profile">Simpan</button>
@endslot
@endcomponent
