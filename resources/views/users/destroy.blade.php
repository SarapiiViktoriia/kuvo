@component('components.modal',
['modal_id' => 'modal-destroy-user',
'modal_title' => ucwords(__('hapus pengguna'))])
	@slot('modal_body')
		<form method="POST" action="{{ route('users.destroy', 0) }}" id="form-destroy-user">
			@csrf
			@method('DELETE')
			<p>Apakah anda yakin akan menghapus data ini?</p>
	@endslot
	@slot('modal_button')
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ ucwords(__('batal')) }}</button>
			<button type="button" class="btn btn-danger" id="btn-destroy-user">{{ ucwords(__('hapus')) }}</button>
		</form>
	@endslot
@endcomponent
