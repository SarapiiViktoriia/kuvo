@component('components.modal', [
'modal_id' => 'modal-destroy-role',
'modal_title' => 'Hapus Roles',
])
@slot('modal_body')
<form method="POST" action="{{ route('roles.destroy', 0) }}" id="form-destroy-role">
	@csrf
	@method('DELETE')	
Apakah anda yakin akan menghapus data ini?
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-danger" id="btn-destroy-role">Hapus</button>
</form>
@endslot
@endcomponent
