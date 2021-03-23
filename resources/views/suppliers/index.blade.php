@extends('layouts.dashboard', ['page_title' => 'manajemen produk'])
@section('content')
	<p class="lead">
		Di sini kamu dapat mengatur pemasok (<em>supplier</em>) yang terdaftar
		dari produk yang kamu jual. Kamu dapat melihat daftar pemasok,
		menambahkan pemasok baru, dan memperbarui informasi pemasok.
	</p>
	@component('components.panel',
	['context'    => '',
	'panel_title' => 'daftar pemasok produk'])
		<div style="margin-bottom: 2em;">
			<button class="btn btn-primary btn-model-add" data-toggle="modal" data-target="#modal-add-supplier">
				<span class="fa fa-plus"></span>
				{{ ucwords(__('pemasok baru')) }}
			</button>
		</div>
		@component('components.datatable-ajax',
		['table_id'     => 'suppliers',
		'table_headers' => ['kode', 'nama'],
		'condition'     => true,
		'data'          => [
			['name' => 'code', 'data' => 'code'],
			['name' => 'name', 'data' => 'name']]
		])
			@slot('data_send_ajax')
			@endslot
		])
		@endcomponent
		@include('suppliers.create')
		@include('suppliers.edit')
		@include('suppliers.destroy')
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
		$(document).ready(function () {
			/* Tidak boleh menggunakan tombol enter pada form. */
			$('form').bind("keypress", function(event) {
				if (event.keyCode == 13 || event.which == 13) {
					event.preventDefault();
				}
			});
			$('#modal-add-supplier').on('shown.bs.modal', function() {
				cleanModal('#form-add-supplier', true);
			});
			$('#btn-add-supplier').click(function() {
				var form = $('#form-add-supplier');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-add-supplier').modal('hide');
						table.ajax.reload();
						new PNotify({
							title: 'Sukses!',
							text: response.data.name + ' berhasil ditambahkan dalam daftar pemasok.',
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
							cleanModal('#form-add-supplier', false);
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
			$('#suppliers-table tbody').on('click', 'button[name="btn-edit-supplier"]', function() {
				var data = table.row($(this).closest('tr')).data();
				$.each($('input, select, textarea', '#form-edit-supplier'), function() {
					if ($(this).attr('id')) {
						var id_element = $(this).attr('id');
						if (data[id_element]) {
							$('#'+id_element, '#form-edit-supplier').val(data[id_element]).trigger('change');
						}
						else {
							$('#'+id_element, '#form-edit-supplier').val('').trigger('change');
						}
					}
				});
				$('#form-edit-supplier').attr('action', APP_URL + '/api/suppliers/'+ $(this).data('id'));
				$('#modal-edit-supplier').modal('show');
			});
			$('#modal-edit-supplier').on('shown.bs.modal', function() {
				cleanModal('#form-edit-supplier', false);
			});
			$('#btn-edit-supplier').click(function () {
				var form = $('#form-edit-supplier');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-edit-supplier').modal('hide');
						table.ajax.reload();
						new PNotify({
							title: 'Sukses!',
							text: 'Informasi pemasok ' + response.data.name + ' berhasil diperbarui.',
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
							cleanModal('#form-edit-supplier', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div_'+col_val, '#form-edit-supplier').addClass('has-error');
								$('#label_'+col_val, '#form-edit-supplier').html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
			$('#suppliers-table tbody').on('click', 'button[name="btn-destroy-supplier"]', function() {
				$('#form-destroy-supplier').attr('action', APP_URL + '/api/suppliers/'+ $(this).data('id'));
				$('#modal-destroy-supplier').modal('show');
			});
			$('#btn-destroy-supplier').click(function () {
				var form = $('#form-destroy-supplier');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-destroy-supplier').modal('hide');
						if (response.status == 'success') {
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
