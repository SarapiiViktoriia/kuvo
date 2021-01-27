@component('components.modal',
['modal_id' => 'modal-add-user',
'modal_title' => ucwords(__('tambah pengguna'))])
	@slot('modal_body')
		<form method="POST" action="{{ route('users.store') }}" id="form-add-user">
			@csrf
			@include('users._form')
	@endslot
	@slot('modal_button')
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ ucwords(__('batal')) }}</button>
			<button type="button" class="btn btn-primary" id="btn-add-user">{{ ucwords(__('tambah')) }}</button>
		</form>
	@endslot
@endcomponent
