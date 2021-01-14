@extends('layouts.dashboard', ['page_title' => 'Data Profil'])
@push('vendorstyles')
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}" />
@endpush
@section('content')
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a>
			<a href="#" class="fa fa-times"></a>
		</div>
		<h2 class="panel-title">Data Profil</h2>
	</header>
	<div class="panel-body">
		<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-profile">Tambah</button>
		@component('components.datatable-ajax', [
		'table_id' => 'profiles',
		'table_headers' => ['name', 'akun'],
		'condition' => TRUE,
		'data' => [
		['name' => 'name', 'data' => 'name'],
		['name' => 'account', 'data' => 'account', 'searchable' => 'false', 'orderable' => 'false']
		]
		])
		@slot('data_send_ajax')
		@endslot
		])
		@endcomponent
		@include('profiles.create')
		@include('profiles.edit')
	</div>
</section>
@endsection
@push('appscripts')
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('select').select2();
		$('#modal-add-profile').on('shown.bs.modal', function(){
			cleanModal('#form-add-profile', true);
		})
		$('#btn-add-profile').click(function(){
			var form = $('#form-add-profile');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-add-profile').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data profil berhasil ditambahkan.',
						type: 'success',
					});
				},
				error: function(response){
					if (response.status == 422) {
						var errors = response.responseJSON;
						new PNotify({
							title: 'Peringatan!',
							text: 'Terdapat kesalahan pada data yang dimasukkan',
							type: 'warning'
						});
						cleanModal('#form-add-profile', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val).addClass('has-error');
							$('#label_'+col_val).html(msg[0]);
						});
					}else{
						systemError();
					}
				}
			});
		})
		$('#profiles-table tbody').on('click', 'button[name="btn-show-profile"]', function(){
			var url = APP_URL + '/profiles/'+ $(this).data('id');
			$.ajax({
				url: url,
				method: 'GET',
				success: function(response){
					$('.modal-body', '#modal-show-profile').html(response);
				}
			})
			$('#modal-show-profile').modal('show');
		})
		$('#profiles-table tbody').on('click', 'button[name="btn-edit-profile"]', function(){
			var data = table.row($(this).closest('tr')).data();
			console.log(data);
			$.each($('input, select, textarea', '#form-edit-profile'), function(){
				if ($(this).attr('id')) {
					var id_element = $(this).attr('id');
					if(data[id_element]){
						$('#'+id_element, '#form-edit-profile').val(data[id_element]).trigger('change');
					}else{
						if ($(this).attr('type') != 'checkbox') {
							$('#'+id_element, '#form-edit-profile').val('').trigger('change');
						}
					}
				}	
			});
			$('select[name="user_id"]', '#form-edit-profile').val(data['profile_id']).trigger('change');
			$('#form-edit-profile').attr('action', APP_URL + '/profiles/'+ $(this).data('id'));
			cleanModal('#form-edit-profile', false);
			//fetch permissions by profile
			var url = APP_URL + '/ajax/fetch-id-permissions-for-profile/'+ $(this).data('id');
			$.ajax({
				url: url,
				method: 'GET',
				success: function(response){
					var permission_ids = response.permission_ids;
					$('input[name="permissions[]"]', '#form-edit-profile').each(function (){
						$(this).prop('checked', false);
						var val = parseInt($(this).val());
						if ($.inArray(val, permission_ids) != -1) {
							$(this).prop('checked', true);
						}
					})
				}, error: function(response){
					console.log(response);
				}
			})
			//fetch roles
			var url = APP_URL + '/ajax/fetch-id-roles-for-profile/'+ $(this).data('id');
			var role_ids = {};
			$.ajax({
				url: url,
				method: 'GET',
				success: function(response){
					role_ids = response.role_ids;
					$('input[name="roles[]"]', '#form-edit-profile').each(function (){
						$(this).prop('checked', false);
						var val = parseInt($(this).val());
						if ($.inArray(val, role_ids) != -1) {
							$(this).prop('checked', true);
						}
					})
					//fetch permissions by roles
					var url = APP_URL + '/ajax/fetch-id-permissions-for-roles';
					$.ajax({
						url: url,
						method: 'POST',
						data: {
							'role_ids' : role_ids
						}, success: function(response){
							var permission_ids = response.permission_ids;
							$('input[name="permissions[]"]', '#form-edit-profile').each(function (){
								var val = parseInt($(this).val());
								if ($.inArray(val, permission_ids) != -1) {
									$(this).prop('checked', true);
									$(this).prop('disabled', true);
								}
							})
						}, error: function(response){
							console.log(response);
						}
					})
				}, error: function(response){
					console.log(response);
				}
			})
			$('#modal-edit-profile').modal('show');
		})
		$('#btn-edit-profile').click(function (){
			var form = $('#form-edit-profile');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-edit-profile').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data profil berhasil diubah.',
						type: 'success',
					});
				},
				error: function(response){
					if (response.status == 422) {
						var errors = response.responseJSON;
						new PNotify({
							title: 'Peringatan!',
							text: 'Terdapat kesalahan pada data yang dimasukkan',
							type: 'warning'
						});
						cleanModal('#form-edit-profile', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val, '#form-edit-profile').addClass('has-error');
							$('#label_'+col_val, '#form-edit-profile').html(msg[0]);
						});
					}else{
						systemError();
					}
				}
			});
		})
		$('#profiles-table tbody').on('click', 'button[name="btn-destroy-profile"]', function(){
			$('#form-destroy-profile').attr('action', APP_URL + '/profiles/'+ $(this).data('id'));
			$('#modal-destroy-profile').modal('show');
		})
		$('#btn-destroy-profile').click(function (){
			var form = $('#form-destroy-profile');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-destroy-profile').modal('hide');
					if (response.status == 'destroyed') {
						new PNotify({
							title: 'Sukses!',
							text: response.message,
							type: 'success',
						});
						table.ajax.reload();
					}else{
						new PNotify({
							title: 'Peringatan!',
							text: response.message,
							type: 'warning',
						});
					}
				},
				error: function(response){
					systemError();
				}
			});
		});
		function handleRoleCheckboxesOnChange(form)
		{
			var checked_roles_add = [];
			$.each($('input[type="checkbox"][class="role-checkboxes"]', form), function(){
				if ($(this).is(':checked')) {
					checked_roles_add.push($(this).val());
				}
			})
			console.log(checked_roles_add);
			$.ajax({
				url: APP_URL + '/ajax/fetch-id-permissions-for-roles',
				method: 'post',
				data: {
					'role_ids' : checked_roles_add,
				},
				success: function(response){
					var array = response.permission_ids;
					$.each($('input[type="checkbox"][class="permission-checkboxes"]', form), function(){
						var search = parseInt($(this).val());
						if ((jQuery.inArray(search, array)) !== -1 ) {
							$('#permission_'+$(this).val(), form).prop('checked', true);
							$('#permission_'+$(this).val(), form).prop('disabled', true);
						}else{
							$('#permission_'+$(this).val(), form).prop('checked', false);
							$('#permission_'+$(this).val(), form).prop('disabled', false);
						}
					})
				},
				error: function(response){
					new PNotify({
						title: 'Error!',
						text: 'Sistem mengalami masalah',
						type: 'error'
					});
				}
			});
		}
		$('.role-checkboxes', '#form-add-profile').change(function(){
			handleRoleCheckboxesOnChange('#form-add-profile');
		});
		$('.role-checkboxes', '#form-edit-profile').change(function(){
			handleRoleCheckboxesOnChange('#form-edit-profile');
		});
	})
</script>
@endpush
