@component('components.modal',
['modal_id'   => 'modal-edit-item-brand',
'modal_title' => 'Perbarui Brand Produk',
])
	@slot('modal_body')
		<form method="PUT" action="{{ route('item-brands.update', 0) }}" id="form-edit-item-brand">
			@csrf
			@include('item-brands._form')
	@endslot
	@slot('modal_button')
			<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-arrow-circle-left"></span> {{ ucwords(__('batal')) }}</button>
			<button type="button" class="btn btn-primary" id="btn-edit-item-brand"><span class="fa fa-edit"></span> {{ ucwords(__('perbarui')) }}</button>
		</form>
	@endslot
@endcomponent
