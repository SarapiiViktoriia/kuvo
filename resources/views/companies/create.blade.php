@component('components.modal',
['modal_id'   => 'modal-add-company',
'modal_title' => 'Tambah Perusahaan'])
	@slot('modal_body')
		<form method="post" action="{{ route('companies.store') }}" id="form-add-company">
			@csrf
			@include('companies._form')
		</form>
	@endslot
	@slot('modal_button')
		<button type="button" class="btn btn-default" data-dismiss="modal">{{ ucwords(__('batal')) }}</button>
		<button type="button" class="btn btn-primary" id="btn-add-company">{{ ucwords(__('simpan')) }}</button>
	@endslot
@endcomponent
