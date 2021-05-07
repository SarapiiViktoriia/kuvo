@component('components.modal',
['modal_id'   => 'modal-edit-item-group',
'modal_title' => 'Perbarui Kategori Produk',
])
	@slot('modal_body')
		<form method="PUT" action="{{ route('api.item-groups.update', 0) }}" id="form-edit-item-group">
			@csrf
			@include('item-groups._form')
	@endslot
	@slot('modal_button')
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
			<button type="button" class="btn btn-primary" id="btn-edit-item-group"><span class="fa fa-edit"></span> {{ ucwords(__('perbarui')) }}</button>
		</form>
	@endslot
@endcomponent
