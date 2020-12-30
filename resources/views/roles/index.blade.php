@extends('layouts.template', ['header' => 'Role', 'datatables' => TRUE])
@push('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />
@endpush
@section('content')
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a>
			<a href="#" class="fa fa-times"></a>
		</div>
		<h2 class="panel-title">Data Role</h2>
	</header>
	<div class="panel-body">
		<a class="mb-xs mt-xs mr-xs modal-basic btn btn-primary" href="#modal-add-role">Tambah</a>
		@component('components.datatable-ajax', [
		'table_id' => 'roles',
		'table_headers' => ['name'],
		'condition' => TRUE,
		'data' => [
		['name' => 'name', 'data' => 'name'],
		]
		])
		@slot('data_send_ajax')
		@endslot
		])
		@endcomponent
		@include('roles.create')
		@include('roles.edit')
	</div>
</section>
@endsection
@push('scripts')
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#btn-add-role').click(function (){
			var form = $('#form-add-role');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$.magnificPopup.close();
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Role berhasil ditambahkan.',
						type: 'success'
					});
				},
				error: function(response){
					if (response.status == 422) {
						var errors = response.responseJSON;
						/*new PNotify({
							title: 'Peringatan!',
							text: 'Terdapat kesalahan pada data yang dimasukkan',
							type: 'warning'
						});*/
						cleanModal('#form-add-role', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val).addClass('has-error');
							$('#label_'+col_val).html(msg[0]);
						});
					}else{
						new PNotify({
							title: 'Error!',
							text: 'Sistem mengalami masalah',
							type: 'error'
						});
					}
				}
			});
		})
		$('#roles-table tbody').on('click', 'button[name="btn-edit-role"]', function(){
			var data = table.row($(this).closest('tr')).data();
			$.each($('input, select, textarea', '#form-edit-role'), function(){
				if ($(this).attr('id')) {
					var id_element = $(this).attr('id');
					if(data[id_element]){
						$('#'+id_element, '#form-edit-role').val(data[id_element]).trigger('change');
					}else{
						$('#'+id_element, '#form-edit-role').val('').trigger('change');
					}
				}	
			});
			$('#form-edit-role').attr('action', APP_URL + '/roles/'+ $(this).data('id'));
			$('.modal-edit-role').magnificPopup({
				type: 'inline',
				preloader: false,
				modal: true
			});
		})
	})
</script>
@endpush
