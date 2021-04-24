@component('components.modal', [
	'modal_id'    => 'modal-destroy-item',
	'modal_title' => 'hapus produk terpilih',
])
	@slot('modal_body')
		<form method="post" action="{{ route('items.destroy', 0) }}" id="form-destroy-item">
			@csrf
			@method('DELETE')
			<p>Apakah anda yakin akan menghapus data ini?</p>
	@endslot
	@slot('modal_button')
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
			<button type="button" class="btn btn-danger" id="btn-destroy-item"><span class="fa fa-trash-o"></span> {{ ucwords(__('hapus data')) }}</button>
		</form>
	@endslot
@endcomponent
