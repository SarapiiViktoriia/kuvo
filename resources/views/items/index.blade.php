@extends('layouts.dashboard', ['page_title' => 'manajemen produk'])
@section('content')
	<p class="lead">
		Di sini kamu dapat mengatur informasi produk yang kamu miliki.
		Kamu dapat melihat daftar produk, menambahkan produk,
		memperbarui informasi produk, dan menghapus produk yang ada.
	</p>
	@component('components.panel',
	['context'    => '',
	'panel_title' => 'daftar produk'])
		<div class="mb-lg">
			<button class="btn btn-primary btn-model-add" data-toggle="modal" data-target="#modal-add-item" data-backdrop="static" data-keyboard="false">
				<span class="fa fa-plus"></span>
				{{ ucwords(__('produk baru')) }}
			</button>
		</div>
		@component('components.datatable-ajax',
		['table_id'     => 'items',
		'table_headers' => ['kategori produk', 'merek produk', 'nama produk', 'supplier', 'hpp'],
		'condition'     => true,
		'data'          => [
			['name' => 'itemGroup.name', 'data' => 'item_group.name'],
			['name' => 'itemBrand.name', 'data' => 'item_brand.name'],
			['name' => 'name', 'data' => 'name'],
			['name' => 'supplier.name', 'data' => 'supplier.name'],
			['name' => 'capitalPrices.value', 'data' => 'hpp']]
		])
				@slot('data_send_ajax')
				@endslot
		@endcomponent
		@include('items.create')
		@include('items.show')
		@include('items.edit')
		@include('items.destroy')
	@endcomponent
@endsection
@push('vendorstyles')
	<link href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/vendor/select2/select2.css') }}" rel="stylesheet" type="text/css">
@endpush
@push('vendorscripts')
	<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendor/select2/select2.js') }}" type="text/javascript"></script>
@endpush
@push('appscripts')
	<script type="text/javascript">
		$(document).ready(function() {
			/*
			 * Menggunakan select2 untuk semua pilihan.
			 */
			$('select').select2();
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
			$('#modal-add-item').on('shown.bs.modal', function() {
				cleanModal('#modal-add-item #form-add-item', true);
			});
			/*
			 * Mengirim data pada form penambahan resource saat tombol submisi ditekan.
			 */
			$('#btn-add-item').click(function() {
				var form = $('#form-add-item');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function (response) {
						$('#modal-add-item').modal('hide');
						table.ajax.reload();
						new PNotify({
							type:  'success',
							title: 'Berhasil!',
							text:  response.data.name + ' berhasil ditambahkan dalam daftar produk.',
						});
					},
					error: function (response) {
						if (response.status == 422) {
							var errors = response.responseJSON;
							new PNotify({
								title: 'Peringatan!',
								text: 'Terdapat kesalahan pada data yang dimasukkan',
								type: 'warning'
							});
							cleanModal('#form-add-item', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div-'+col_val).addClass('has-error');
								$('#error-'+col_val).html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
			/*
			 * Menampilkan jendela modal ketika tombol show resource ditekan.
			 */
			$('#items-table tbody').on('click', 'button[name="btn-show-item"]', function() {
				var url = APP_URL + '/items/' + $(this).data('id');
				$.ajax({
					url:    url,
					method: 'GET',
					success: function (response) {
						$('.modal-body', '#modal-show-item').html(response);
					}
				});
				$('#modal-show-item').modal('show');
			});
			/*
			 * Menampilkan jendela modal ketika tombol edit resource ditekan.
			 */
			$('#items-table tbody').on('click', 'button[name="btn-edit-item"]', function() {
				// Menjaga agar modal tetap tampil ketika pengguna meng-klik di luar modal.
				$('#modal-edit-item').modal({backdrop: "static", keyboard: false});
				// Ambil data produk dari baris tombol yang ditekan.
				var data = table.row($(this).closest('tr')).data();
				// Mengisi nilai masing-masing bidang masukan formulir sesusai data yang diambil.
				$.each($('input, select, textarea', '#form-edit-item'), function() {
					if ($(this).attr('id')) {
						var id_element = $(this).attr('id');
						if (data[id_element]) {
							$('#' + id_element, '#form-edit-item').val(data[id_element]).trigger('change');
						}
						else {
							$('#' + id_element, '#form-edit-item').val('').trigger('change');
						}
					}
				});
				// Menetapkan URL untuk pemrosesan form.
				$('#form-edit-item').attr('action', APP_URL + '/items/' + $(this).data('id'));
				// Menampilkan jendela modal kepada pengguna.
				$('#modal-edit-item').modal('show');
			});
			/*
			 * Mengirim data pada form pengubahan resource saat tombol submisi ditekan.
			 */
			$('#btn-edit-item').click(function () {
				var form = $('#form-edit-item');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-edit-item').modal('hide');
						table.ajax.reload();
						new PNotify({
							type:  'success',
							title: 'Berhasil!',
							text:  'Informasi produk ' + response.data.name + ' berhasil diperbarui.',
						});
					},
					error: function(response) {
						console.log(response);
						if (response.status == 422) {
							var errors = response.responseJSON;
							new PNotify({
								type:  'warning',
								title: 'Peringatan!',
								text:  'Terdapat kesalahan pada data yang dimasukkan',
							});
							cleanModal('#form-edit-item', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div-' + col_val, '#form-edit-item').addClass('has-error');
								$('#error-' + col_val, '#form-edit-item').html(msg[0]);
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
			$('#items-table tbody').on('click', 'button[name="btn-destroy-item"]', function() {
				// Menetapkan URL untuk pemrosesan form.
				$('#form-destroy-item').attr('action', APP_URL + '/items/' + $(this).data('id'));
				// Menampilkan jendela modal.
				$('#modal-destroy-item').modal('show');
			});
			/*
			 * Mengirim data pada form penghapusan resource saat tombol submisi ditekan.
			 */
			$('#btn-destroy-item').click(function () {
				var form = $('#form-destroy-item');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-destroy-item').modal('hide');
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
