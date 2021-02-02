@component('components.modal',
['modal_id'   => 'modal-edit-item-group',
'modal_title' => 'Ubah Kategori Produk',
])
	@slot('modal_body')
		<form method="PUT" action="{{ route('item-groups.update', 0) }}" id="form-edit-item-group">
			@csrf
			@include('item-groups._form')
	@endslot
	@slot('modal_button')
			<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
			<button type="button" class="btn btn-primary" id="btn-edit-item-group">Simpan</button>
		</form>
	@endslot
@endcomponent
