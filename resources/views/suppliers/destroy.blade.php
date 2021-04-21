@component('components.modal', [
	'modal_id'    => 'modal-destroy-supplier',
	'modal_title' => 'penghapusan supplier',
])
	@slot('modal_body')
		<form method="post" action="{{ route('suppliers.destroy', 0) }}" id="form-destroy-supplier">
			@csrf
			@method('DELETE')
			<p>Apakah kamu yakin ingin menghapus data ini?</p>
	@endslot
	@slot('modal_button')
		<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
		<button type="button" class="btn btn-default" id="btn-destroy-supplier"><span class="fa fa-trash-o"></span> {{ ucwords(__('hapus data')) }}</button>
	</form>
	@endslot
@endcomponent
