@component('components.modal', [
	'modal_id'    => 'modal-destroy-item-group',
	'modal_title' => 'hapus kategori produk',
])
	@slot('modal_body')
		<form method="post" action="{{ route('item-groups.destroy', 0) }}" id="form-destroy-item-group">
			@csrf
			@method('DELETE')
			<p>Apakah kamu yakin ingin menghapus data ini?</p>
	@endslot
	@slot('modal_button')
			<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
			<button type="button" class="btn btn-default" id="btn-destroy-item-group"><span class="fa fa-trash-o"></span> {{ ucwords(__('hapus data')) }}</button>
		</form>
	@endslot
@endcomponent
