@component('components.modal',
['modal_id'   => 'modal-add-item-group',
'modal_title' => 'Tambah Kategori Produk',
])
	@slot('modal_body')
		<form method="POST" action="{{ route('api.item-groups.store') }}" id="form-add-item-group">
			@csrf
			@include('item-groups._form')
		</form>
	@endslot
	@slot('modal_button')
		<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-primary" id="btn-add-item-group">Simpan</button>
	@endslot
@endcomponent
