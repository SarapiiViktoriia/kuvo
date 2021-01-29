@extends('layouts.dashboard', ['page_title' => 'manajemen pengguna'])
@section('content')
	<p class="lead">
		Di sini kamu dapat mengatur pengguna aplikasi ini. Kamu dapat melihat
		daftar pengguna terdaftar, menambahkan pengguna, memperbarui informasi pengguna,
		dan menghapus pengguna yang ada.
	</p>
	@component('components.panel',
	['context'    => '',
	'panel_title' => 'daftar pengguna'])
		<div style="margin-bottom: 2em;">
			<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-user">
				<span class="fa fa-plus"></span>
				{{ ucwords(__('tambah pengguna')) }}
			</button>
		</div>
		@component('components.datatable-ajax',
		['table_id'     => 'users',
		'table_headers' => ['name', 'email', 'username', 'profile'],
		'condition'     => true,
		'data'          => [
			['name' => 'name', 'data' => 'name'],
			['name' => 'email', 'data' => 'email'],
			['name' => 'username', 'data' => 'username'],
			['name' => 'profile', 'data' => 'profile']]
		])
			@slot('data_send_ajax')
			@endslot
		@endcomponent
		@include('users.create')
		@include('users.edit')
		@include('users.destroy')
	@endcomponent
	<p>
		Kamu dapat menambahkan pengguna dan mengkaitkannya
		dengan profil pengguna yang ada. Perlu kamu ketahui,
		kamu harus membuat profil pengguna dulu sebelum
		bisa mengkaitkan profil. Untuk membuat profil, gunakan
		<a href="{{ route('profiles.index') }}">modul manajemen
		profil pengguna</a>.
	</p>
@endsection
@push('vendorstyles')
	<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}" />
@endpush
@push('appscripts')
	<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
	<script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			function fetch_profiles(form, selected, text_selected) {
				$.ajax({
					url: '{{ route('ajax.fetch_profiles') }}',
					method: 'GET',
					success: function(response) {
						$('select[name="profile_id"]', form).empty();
						$('select[name="profile_id"]', form).append($('<option value="">Pilih profil</option>'));
						$.each(response.profiles, function(key, value) {
							$('select[name="profile_id"]', form).append($('<option value="'+key+'">' + value + '</option>'));
						});
						if (selected) {
							$('select[name="profile_id"]', form).append($('<option value="'+selected+'">' + text_selected + '</option>'));
							$('select[name="profile_id"]', form).val(selected).trigger('change');
						}
						$('select[name="profile_id"]', form).select2({
							dropdownParent: $(form)
						});
					},
					error: function(response) {
						new PNotify({
							title: 'Peringatan!',
							text: 'Terdapat kesalahan saat mengambil data',
							type: 'warning'
						});
					}
				});
			}
			$('select').select2();
			$('#modal-add-user').on('shown.bs.modal', function() {
				cleanModal('#form-add-user', true);
				fetch_profiles('#form-add-user', null, null);
			});
			$('#btn-add-user').click(function() {
				var form = $('#form-add-user');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-add-user').modal('hide');
						table.ajax.reload();
						new PNotify({
							title: 'Sukses!',
							text: 'Data akun berhasil ditambahkan.',
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
							cleanModal('#form-add-user', false);
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
			$('#users-table tbody').on('click', 'button[name="btn-show-user"]', function() {
				var url = APP_URL + '/users/'+ $(this).data('id');
				$.ajax({
					url: url,
					method: 'GET',
					success: function(response) {
						$('.modal-body', '#modal-show-user').html(response);
					}
				});
				$('#modal-show-user').modal('show');
			});
			$('#users-table tbody').on('click', 'button[name="btn-edit-user"]', function() {
				var data = table.row($(this).closest('tr')).data();
				var selected = null;
				$.each($('input, select, textarea', '#form-edit-user'), function() {
					if ($(this).attr('id')) {
						var id_element = $(this).attr('id');
						if (data[id_element]) {
							$('#'+id_element, '#form-edit-user').val(data[id_element]).trigger('change');
						}
						else {
							$('#'+id_element, '#form-edit-user').val('').trigger('change');
						}
						if (id_element == 'profile_id') {
							selected = data[id_element];
						}
					}
				});
				$('#form-edit-user').attr('action', APP_URL + '/users/'+ $(this).data('id'));
				cleanModal('#form-edit-user', false);
				fetch_profiles('#form-edit-user', selected, data['profile']);
				$('#modal-edit-user').modal('show');
			});
			$('#btn-edit-user').click(function() {
				var form = $('#form-edit-user');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-edit-user').modal('hide');
						table.ajax.reload();
						new PNotify({
							title: 'Sukses!',
							text: 'Data akun berhasil diubah.',
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
							cleanModal('#form-edit-user', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div_'+col_val, '#form-edit-user').addClass('has-error');
								$('#label_'+col_val, '#form-edit-user').html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
			$('#users-table tbody').on('click', 'button[name="btn-destroy-user"]', function() {
				$('#form-destroy-user').attr('action', APP_URL + '/users/'+ $(this).data('id'));
				$('#modal-destroy-user').modal('show');
			});
			$('#btn-destroy-user').click(function () {
				var form = $('#form-destroy-user');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-destroy-user').modal('hide');
						if (response.status == 'destroyed') {
							new PNotify({
								title: 'Sukses!',
								text: response.message,
								type: 'success',
							});
							table.ajax.reload();
						}
						else {
							new PNotify({
								title: 'Peringatan!',
								text: response.message,
								type: 'warning',
							});
						}
					},
					error: function(response) {
						systemError();
					}
				});
			});
		});
	</script>
@endpush
