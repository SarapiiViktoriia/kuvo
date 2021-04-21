@extends('layouts.dashboard', ['page_title' => 'manajemen produk'])
@section('content')
	<p class="lead">
		Di sini kamu dapat mengatur supplier yang terdaftar
		dari produk yang kamu jual. Kamu dapat melihat daftar supplier,
		menambahkan supplier baru, dan memperbarui informasi supplier.
	</p>
	@component('components.panel', [
		'context'     => '',
		'panel_title' => 'daftar supplier'
	])
		<div class="mb-lg">
			<button class="btn btn-primary btn-model-add" data-toggle="modal" data-target="#modal-add-supplier" data-backdrop="static" data-keyboard="false">
				<span class="fa fa-plus"></span>
				{{ ucwords(__('supplier baru')) }}
			</button>
		</div>
		@component('components.datatable-ajax', [
			'table_id'      => 'suppliers',
			'table_headers' => ['kode supplier', 'nama supplier'],
			'condition'     => true,
			'data'          => [
				['name' => 'code', 'data' => 'code'],
				['name' => 'name', 'data' => 'name']
			]
		])
			@slot('data_send_ajax')
			@endslot
		@endcomponent
		@include('suppliers.create')
		@include('suppliers.edit')
		@include('suppliers.destroy')
	@endcomponent
@endsection
@push('vendorstyles')
	<link href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" rel="stylesheet" style="text/css">
	<link href="{{ asset('assets/vendor/select2/select2.css') }}" rel="stylesheet" style="text/css">
@endpush
@push('vendorscripts')
	<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendor/select2/select2.js') }}" type="text/javascript"></script>
@endpush
@push('appscripts')
	<script type="text/javascript">
		$(document).ready(function () {
			/*
			 * Menonaktifkan fungsi tombol `enter` sehingga tidak menutup jendela modal.
			 */
			$('form').bind("keypress", function(event) {
				if (event.keyCode == 13 || event.which == 13) {
					event.preventDefault();
				}
			});
			/*
			 * Memodifikasi tampilan formulir penambahan resource
			 * ketika modal penambahan resource dimunculkan.
			 */
			$('#modal-add-supplier').on('shown.bs.modal', function() {
				// Menghapus isian formulir.
				cleanModal('#form-add-supplier', true);
				$('#form-add-supplier #consumer-checkbox').remove();
				// Menghilangkan kotak centang consumer sehingga pengguna tidak kebingungan.
				$('#form-add-supplier [id^=error-]').empty();
				$('#form-add-supplier [id^=div-]').removeClass('has-error');
				// Menandai kotak centang untuk supplier dan menjadikannya tidak dapat diubah lagi.
				$('#form-add-supplier #type-supplier:checkbox').prop('checked', true);
				$('#form-add-supplier #type-supplier').prop('disabled', true);
				// Menyembunyikan bagian pemilihan jenis perusahaan.
				$('#form-add-supplier #div-type').hide();
			});
			/*
			 * Mengirim data pada form penambahan resource saat tombol submisi ditekan.
			 */
			$('#btn-add-supplier').click(function() {
				var form = $('#form-add-supplier');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-add-supplier').modal('hide');
						table.ajax.reload();
						new PNotify({
							type:  'success',
							title: 'Berhasil!',
							text:  response.data.name + ' berhasil ditambahkan sebagai supplier.',
						});
					},
					error: function(response) {
						if (response.status == 422) {
							var errors = response.responseJSON;
							new PNotify({
								type:  'warning',
								title: 'Peringatan!',
								text:  'Terdapat kesalahan pada data yang dimasukkan',
							});
							cleanModal('#form-add-supplier', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div-' + col_val).addClass('has-error');
								$('#error-' + col_val).html(msg[0]);
							});
							console.log(errors.errors);
						}
						else {
							systemError();
						}
					}
				});
			});
			/*
			 * Menampilkan jendela modal ketika tombol edit resource ditekan.
			 */
			$('#suppliers-table tbody').on('click', 'button[name="btn-edit-supplier"]', function() {
				// Ambil data supplier dari baris tombol yang ditekan.
				var data = table.row($(this).closest('tr')).data();
				// Mengisi nilai masing-masing bidang masukan formulir sesusai data yang diambil.
				$.each($('input, select, textarea', '#form-edit-supplier'), function() {
					if ($(this).attr('id')) {
						var id_element = $(this).attr('id');
						if (data[id_element]) {
							$('#' + id_element, '#form-edit-supplier').val(data[id_element]).trigger('change');
						}
						else {
							$('#' + id_element, '#form-edit-supplier').val('').trigger('change');
						}
					}
				});
				// Membatasi data yang boleh diubah pengguna dengan menghilangkan bidang yang dilindungi.
				$('#modal-edit-supplier #div-type').remove();
				// Menetapkan URL untuk pemrosesan form.
				$('#form-edit-supplier').attr('action', APP_URL + '/suppliers/'+ $(this).data('id'));
				// Menampilkan jendela modal kepada pengguna.
				$('#modal-edit-supplier').modal('show');
			});
			/*
			 * Memodifikasi tampilan formulir pengubahan resource
			 * ketika modal pengubahan resource dimunculkan.
			 */
			$('#modal-edit-supplier').on('shown.bs.modal', function() {
				// Menghapus isian formulir.
				cleanModal('#form-edit-supplier', false);
			});
			/*
			 * Mengirim data pada form pengubahan resource saat tombol submisi ditekan.
			 */
			$('#btn-edit-supplier').click(function () {
				var form = $('#form-edit-supplier');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-edit-supplier').modal('hide');
						table.ajax.reload();
						new PNotify({
							type:  'success',
							title: 'Berhasil!',
							text:  'Informasi supplier ' + response.data.name + ' berhasil diperbarui.',
						});
					},
					error: function(response) {
						if (response.status == 422) {
							var errors = response.responseJSON;
							new PNotify({
								type:  'warning',
								title: 'Peringatan!',
								text:  'Terdapat kesalahan pada data yang dimasukkan',
							});
							cleanModal('#form-edit-supplier', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div-' + col_val, '#form-edit-supplier').addClass('has-error');
								$('#error- ' + col_val, '#form-edit-supplier').html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
			/*
			 * Menampilkan jendela modal ketika tombol hapus resource ditekan.
			 */
			$('#suppliers-table tbody').on('click', 'button[name="btn-destroy-supplier"]', function() {
				// Menetapkan URL untuk pemrosesan form.
				$('#form-destroy-supplier').attr('action', APP_URL + '/suppliers/' + $(this).data('id'));
				// Menampilkan jendela modal.
				$('#modal-destroy-supplier').modal('show');
			});
			/*
			 * Mengirim data pada form penghapusan resource saat tombol submisi ditekan.
			 */
			$('#btn-destroy-supplier').click(function () {
				var form = $('#form-destroy-supplier');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-destroy-supplier').modal('hide');
						if (response.status == 'success') {
							new PNotify({
								type:  'success',
								title: 'Berhasil!',
								text:  response.message,
							});
							table.ajax.reload();
						}
						else {
							new PNotify({
								type:  'warning',
								title: 'Peringatan!',
								text:  response.message,
							});
							console.log(response);
						}
					},
					error: function(response) {
						console.log(response);
						systemError();
					}
				});
			});
		});
	</script>
@endpush
