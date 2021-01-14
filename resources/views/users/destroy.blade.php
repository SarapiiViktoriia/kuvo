@component('components.modal', [
'modal_id' => 'modal-destroy-user',
'modal_title' => 'Hapus User',
])
@slot('modal_body')
<form method="POST" action="{{ route('users.destroy', 0) }}" id="form-destroy-user">
	@csrf
	@method('DELETE')	
Apakah anda yakin akan menghapus data ini?
@endslot
@slot('modal_button')
<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<button type="button" class="btn btn-danger" id="btn-destroy-user">Hapus</button>
</form>
@endslot
@endcomponent
