@component('components.modal',
['modal_id'   => 'modal-edit-company',
'modal_title' => 'Ubah Data Perusahaan',
])
	@slot('modal_body')
		<form method="POST" action="{{ route('companies.update', 0) }}" id="form-edit-company">
			@csrf
			@method('PUT')
			@include('companies._form')
	@endslot
	@slot('modal_button')
			<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
			<button type="button" class="btn btn-primary" id="btn-edit-company">Simpan</button>
		</form>
	@endslot
@endcomponent
