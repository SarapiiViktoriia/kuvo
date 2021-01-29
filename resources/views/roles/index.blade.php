@extends('layouts.dashboard', ['page_title' => 'manajemen peran pengguna'])
@section('content')
	<p class="lead">
		Di sini kamu dapat mengatur peran pengguna aplikasi ini.
		Kamu dapat melihat daftar peran, menambahkan peran,
		memperbarui informasi peran, dan menghapus peran pengguna.
	</p>
	@component('components.panel',
	['context'    => '',
	'panel_title' => 'daftar peran pengguna'])
		<div style="margin-bottom: 2em;">
			<button class="btn btn-primary btn-model-add" data-toggle="modal" data-target="#modal-add-role">
				<span class="fa fa-plus"></span>
				{{ ucwords(__('tambah peran')) }}
			</button>
		</div>
		@component('components.datatable-ajax',
		['table_id'     => 'roles',
		'table_headers' => ['name'],
		'condition'     => true,
		'data'          => [['name' => 'name', 'data' => 'name']]])
			@slot('data_send_ajax')
			@endslot
		@endcomponent
		@include('roles.create')
		@include('roles.edit')
		@include('roles.destroy')
	@endcomponent
@endsection
@push('vendorstyles')
	<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}">
@endpush
@push('appscripts')
	<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
	<script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#modal-add-role').on('shown.bs.modal', function() {
				cleanModal('#form-add-role', true);
			});
			$('#btn-add-role').click(function() {
				var form = $('#form-add-role');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-add-role').modal('hide');
						table.ajax.reload();
						new PNotify({
							title: 'Sukses!',
							text: 'Data role berhasil ditambahkan.',
							type: 'success',
						});
					},
					error: function(response) {
						if (response.status == 422) {
							var errors = response.responseJSON;
							new PNotify({
								title: 'Peringatan!',
								text: 'Terdapat kesalahan pada data yang dimasukkan',
								type: 'warning'
							});
							cleanModal('#form-add-role', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div_'+col_val).addClass('has-error');
								$('#label_'+col_val).html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
			$('#roles-table tbody').on('click', 'button[name="btn-show-role"]', function() {
				var url = APP_URL + '/roles/'+ $(this).data('id');
				$.ajax({
					url: url,
					method: 'GET',
					success: function(response) {
						$('.modal-body', '#modal-show-role').html(response);
					}
				});
				$('#modal-show-role').modal('show');
			});
			$('#roles-table tbody').on('click', 'button[name="btn-edit-role"]', function() {
				var data = table.row($(this).closest('tr')).data();
				$.each($('input, select, textarea', '#form-edit-role'), function() {
					if ($(this).attr('id')) {
						var id_element = $(this).attr('id');
						if (data[id_element]) {
							$('#'+id_element, '#form-edit-role').val(data[id_element]).trigger('change');
						}
						else {
							if ($(this).attr('type') != 'checkbox') {
								$('#'+id_element, '#form-edit-role').val('').trigger('change');
							}
						}
					}
				});
				$('#form-edit-role').attr('action', APP_URL + '/roles/'+ $(this).data('id'));
				cleanModal('#form-edit-role', false);
				var url = APP_URL + '/ajax/fetch-id-permissions-for-role/'+ $(this).data('id');
				$.ajax({
					url: url,
					method: 'GET',
					success: function(response) {
						var permission_ids = response.permission_ids;
						$('input[name="permissions[]"]', '#form-edit-role').each(function () {
							$(this).prop('checked', false);
							var val = parseInt($(this).val());
							if ($.inArray(val, permission_ids) != -1) {
								$(this).prop('checked', true);
							}
						});
					},
					error: function(response) {
						console.log(response);
					}
				});
				$('#modal-edit-role').modal('show');
			});
			$('#btn-edit-role').click(function () {
				var form = $('#form-edit-role');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response){
						$('#modal-edit-role').modal('hide');
						table.ajax.reload();
						new PNotify({
							title: 'Sukses!',
							text: 'Data role berhasil diubah.',
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
							cleanModal('#form-edit-role', false);
							$.each(errors.errors, function(col_val, msg){
								$('#div_'+col_val, '#form-edit-role').addClass('has-error');
								$('#label_'+col_val, '#form-edit-role').html(msg[0]);
							});
						}else{
							systemError();
						}
					}
				});
			})
			$('#roles-table tbody').on('click', 'button[name="btn-destroy-role"]', function(){
				$('#form-destroy-role').attr('action', APP_URL + '/roles/'+ $(this).data('id'));
				$('#modal-destroy-role').modal('show');
			})
			$('#btn-destroy-role').click(function (){
				var form = $('#form-destroy-role');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response){
						$('#modal-destroy-role').modal('hide');
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
		})
	</script>
@endpush
