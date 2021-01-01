@extends('layouts.dashboard', ['page_title' => 'Users'])
@push('vendorstyles')
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
@endpush
@section('content')
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a>
			<a href="#" class="fa fa-times"></a>
		</div>
		<h2 class="panel-title">Data User</h2>
	</header>
	<div class="panel-body">
		<a class="mb-xs mt-xs mr-xs modal-basic btn btn-primary" href="#modal-add-user">Tambah</a>
		@component('components.datatable-ajax', [
		'table_id' => 'users',
		'table_headers' => ['name', 'email', 'username', 'profile'],
		'condition' => TRUE,
		'data' => [
		['name' => 'name', 'data' => 'name'],
		['name' => 'email', 'data' => 'email'],
		['name' => 'username', 'data' => 'username'],
		['name' => 'profile', 'data' => 'profile'],
		]
		])
		@slot('data_send_ajax')
		@endslot
		])
		@endcomponent
		@include('users.create')
		@include('users.edit')
	</div>
</section>
@endsection
@push('appscripts')
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#btn-add-user').click(function (){
			var form = $('#form-add-user');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$.magnificPopup.close();
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'User berhasil ditambahkan.',
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
						cleanModal('#form-add-user', false);
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
		$('#users-table tbody').on('click', 'button[name="btn-edit-user"]', function(){
			var data = table.row($(this).closest('tr')).data();
			$.each($('input, select, textarea', '#form-edit-user'), function(){
				if ($(this).attr('id')) {
					var id_element = $(this).attr('id');
					if(data[id_element]){
						$('#'+id_element, '#form-edit-user').val(data[id_element]).trigger('change');
					}else{
						$('#'+id_element, '#form-edit-user').val('').trigger('change');
					}
				}	
			});
			$('#form-edit-user').attr('action', APP_URL + '/users/'+ $(this).data('id'));
			$('.modal-edit-user').magnificPopup({
				type: 'inline',
				preloader: false,
				modal: true
			});
		})
	})
</script>
@endpush
