@extends('layouts.dashboard', ['page_title' => 'manajemen produk'])
@section('content')
	<p class="lead">
		Di sini kamu dapat mengelola merek dari produk yang kamu sediakan.
		Kamu dapat melihat daftar merek, menambah merek, dan memperbarui
		informasi merek.
	</p>
	@component('components.panel', [
		'context'     => '',
		'panel_title' => 'daftar merek'
	])
		<div class="mb-lg">
			<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-item-brand" data-backdrop="static" data-keyboard="false">
				<span class="fa fa-plus"></span>
				{{ ucwords(__('merek baru')) }}
			</button>
		</div>
		@component('components.datatable-ajax', [
			'table_id'       => 'item-brands',
			'table_headers'  => ['nama merek'],
			'condition'      => true,
			'data'           => [
				['name' => 'name', 'data' => 'name']
			]
		])
			@slot('data_send_ajax')
			@endslot
		@endcomponent
		@include('item-brands.create')
		@include('item-brands.show')
		@include('item-brands.edit')
		@include('item-brands.destroy')
	@endcomponent
@endsection
@push('vendorstyles')
	<link href="{{ asset('assets/vendor/select2/select2.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" rel="stylesheet" type="text/css">
@endpush
@push('vendorscripts')
	<script src="{{ asset('assets/vendor/select2/select2.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}" type="text/javascript"></script>
@endpush
@push('appscripts')
	<script type="text/javascript">
		$(document).ready(function () {
			/* Tidak boleh menggunakan tombol enter pada form. */
			$('form').bind("keypress", function(event) {
				if (event.keyCode == 13 || event.which == 13) {
					event.preventDefault();
				}
			});
			/* Membersihkan data pada form penambahan resource saat ditampilkan. */
			$('#modal-add-item-brand').on('shown.bs.modal', function() {
				cleanModal('#form-add-item-brand', true);
			});
			/* Mengirim data pada form penambahan resource saat tombol ditekan. */
			$('#btn-add-item-brand').click(function() {
				var form = $('#form-add-item-brand');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-add-item-brand').modal('hide');
						table.ajax.reload();
						new PNotify({
							type:  'success',
							title: 'Berhasil!',
							text:  response.data.name + ' berhasil ditambahkan dalam daftar merek.',
						});
					},
					error: function(response) {
						if (response.status == 422) {
							var errors = response.responseJSON;
							new PNotify({
								type:  'warning',
								title: 'Peringatan!',
								text:  'Terdapat kesalahan pada data yang dimasukkan.',
							});
							cleanModal('#form-add-item-brand', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div-' + col_val).addClass('has-error');
								$('#error-' + col_val).html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
			/* Menampilkan modal untuk melihat detail data resource. */
			$('#item-brands-table tbody').on('click', 'button[name="btn-show-item-brand"]', function() {
				var data = table.row($(this).closest('tr')).data();
				$('#show-item-brand-title', '#modal-show-item-brand').empty();
				$('#show-item-brand-description', '#modal-show-item-brand').empty();
				$('#show-item-brand-title', '#modal-show-item-brand').append(data.name);
				$('#show-item-brand-description', '#modal-show-item-brand').append(data.description);
				$('#modal-show-item-brand').modal('show');
			});
			/* Menampilkan modal untuk mengubah data resource. */
			$('#item-brands-table tbody').on('click', 'button[name="btn-edit-item-brand"]', function() {
				/* Menjaga agar modal tetap tampil ketika pengguna meng-klik di luar modal. */
				$('#modal-edit-item-brand').modal({backdrop: "static", keyboard: false});
				var data = table.row($(this).closest('tr')).data();
				$.each($('input, select, textarea', '#form-edit-item-brand'), function() {
					if ($(this).attr('id')) {
						var id_element = $(this).attr('id');
						if (data[id_element]) {
							$('#' + id_element, '#form-edit-item-brand').val(data[id_element]).trigger('change');
						}
						else {
							$('#' + id_element, '#form-edit-item-brand').val('').trigger('change');
						}
					}
				});
				$('#form-edit-item-brand').attr('action', APP_URL + '/item-brands/' + $(this).data('id'));
				$('#modal-edit-item-brand').modal('show');
			});
			/* Membersihkan data pada form pengubahan resource saat ditampilkan. */
			$('#modal-edit-item-brand').on('shown.bs.modal', function() {
				cleanModal('#form-edit-item-brand', false);
			});
			/* Mengirim data pada form pengubahan resource saat tombol ditekan. */
			$('#btn-edit-item-brand').click(function () {
				var form = $('#form-edit-item-brand');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-edit-item-brand').modal('hide');
						table.ajax.reload();
						new PNotify({
							type:  'success',
							title: 'Berhasil!',
							text:  'Informasi merek ' + response.data.name + ' berhasil diperbarui.',
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
							cleanModal('#form-edit-item-brand', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div-' + col_val, '#form-edit-item-brand').addClass('has-error');
								$('#error-' + col_val, '#form-edit-item-brand').html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
			/* Menampilkan modal untuk penghapusan data resource. */
			$('#item-brands-table tbody').on('click', 'button[name="btn-destroy-item-brand"]', function() {
				$('#form-destroy-item-brand').attr('action', APP_URL + '/item-brands/' + $(this).data('id'));
				$('#modal-destroy-item-brand').modal('show');
			});
			/* Mengirim data pada form penghapusan resource saat tombol ditekan. */
			$('#btn-destroy-item-brand').click(function () {
				var form = $('#form-destroy-item-brand');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-destroy-item-brand').modal('hide');
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
