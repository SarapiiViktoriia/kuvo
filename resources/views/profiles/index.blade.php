@extends('layouts.template', ['header' => 'Profile', 'datatables' => TRUE])
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
		<h2 class="panel-title">Data Profil</h2>
	</header>
	<div class="panel-body">
		<a class="mb-xs mt-xs mr-xs btn btn-primary" href="#modal-add-profile" id="magnific-modal-add-profile">Tambah</a>
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
@push('scripts')
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#magnific-modal-add-profile').magnificPopup({
			type: 'inline',
			preloader: false,
			modal: true,
			callbacks: {
				beforeOpen: function(){
					/*$('select[name="user_id"]').select2({
						dropdownParent: $('#modal-add-profile')
					});*/
					cleanModal('#form-add-profile', true);
					$.each($('input[type="checkbox"]', '#form-add-profile'), function(){
						if ($(this).is(':checked')) {
							$(this).prop('checked', false);
							$(this).prop('disabled', false); 
						}
					})
				}
			}
		});
		$('#profiles-table tbody').on('click', '.magnific-modal-edit-profile', function (e) {
			$('.magnific-modal-edit-profile').magnificPopup({
				type: 'inline',
				preloader: false,
				modal: true,
				callbacks: {
					beforeOpen: function(){
						/*$('select[name="user_id"]').select2({
							dropdownParent: $('#modal-add-profile')
						});*/
						/*cleanModal('#form-edit-profile', true);
						$.each($('input[type="checkbox"]', '#form-edit-profile'), function(){
							if ($(this).is(':checked')) {
								$(this).prop('checked', false);
								$(this).prop('disabled', false); 
							}
						})
						var data = table.row($(this).closest('tr')).data();
						$.each($('input, select, textarea', '#form-edit-profile'), function(){
							if ($(this).attr('id')) {
								var id_element = $(this).attr('id');
								if(data[id_element]){
									$('#'+id_element, '#form-edit-profile').val(data[id_element]).trigger('change');
								}else{
									$('#'+id_element, '#form-edit-profile').val('').trigger('change');
								}
							}	
						});
						$('#form-edit-profile').attr('action', APP_URL + '/profiles/'+ $(this).data('id'));*/
					}
				}
			});
		});
		$('.role-checkboxes').change(function(){
			var checked_roles_add = [];
			$.each($('input[type="checkbox"][class="role-checkboxes"]', '#form-add-profile'), function(){
				if ($(this).is(':checked')) {
					checked_roles_add.push($(this).val());
				}
			})
			$.ajax({
				url: APP_URL + '/ajax/get-permissions-from-roles',
				method: 'post',
				data: {
					'role_ids' : checked_roles_add,
				},
				success: function(response){
					var array = response.permissions;
					$.each($('input[type="checkbox"][class="permission-checkboxes"]', '#form-add-profile'), function(){
						var search = parseInt($(this).val());
						if ((jQuery.inArray(search, array)) !== -1 ) {
							$('#permission_'+$(this).val(), '#form-add-profile').prop('checked', true);
							$('#permission_'+$(this).val(), '#form-add-profile').prop('disabled', true);
						}else{
							$('#permission_'+$(this).val(), '#form-add-profile').prop('checked', false);
							$('#permission_'+$(this).val(), '#form-add-profile').prop('disabled', false);
						}
					})
				},
				error: function(response){
					console.log(response);
					new PNotify({
						title: 'Error!',
						text: 'Sistem mengalami masalah',
						type: 'error'
					});
				}
			});
		});
		$('#btn-add-profile').click(function (){
			var form = $('#form-add-profile');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$.magnificPopup.close();
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Profil berhasil ditambahkan.',
						type: 'success'
					});
				},
				error: function(response){
					if (response.status == 422) {
						var errors = response.responseJSON;
						cleanModal('#form-add-profile', false);
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
	})
</script>
@endpush
