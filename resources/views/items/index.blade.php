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
		<div style="margin-bottom: 2em;">
			<button class="btn btn-primary btn-model-add" data-toggle="modal" data-target="#modal-add-item">
				<span class="fa fa-plus"></span>
				{{ ucwords(__('produk baru')) }}
			</button>
		</div>
		@component('components.datatable-ajax',
		['table_id'     => 'items',
		'table_headers' => ['sku', 'kategori', 'brand', 'nama', 'pemasok' ],
		'condition'     => true,
		'data'          => [
			['name' => 'sku', 'data' => 'sku'],
			['name' => 'itemGroup.name', 'data' => 'item_group.name'],
			['name' => 'itemBrand.name', 'data' => 'item_brand.name'],
			['name' => 'name', 'data' => 'name'],
			['name' => 'supplier.name', 'data' => 'supplier.name']]
		])
				@slot('data_send_ajax')
				@endslot
		@endcomponent
		@include('items.show')
		@include('items.destroy')
		@include('items.create')
		@include('items.edit')
		@include('items.show')
	@endcomponent
@endsection
@push('vendorstyles')
	<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}" />
@endpush
@push('appscripts')
	<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
	<script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			/* Menggunakan select2 untuk semua pilihan. */
			$('select').select2();
			/* Tidak boleh menggunakan tombol enter pada form. */
			$('form').bind("keypress", function(event) {
				if (event.keyCode == 13 || event.which == 13) {
					event.preventDefault();
				}
			});
			/* Aksi untuk tombol penambahan produk baru. */
			$('#modal-add-item').on('shown.bs.modal', function() {
				cleanModal('#modal-add-item #form-add-item', true);
			});
			/* Aksi tombol untuk submisi formulir penambahan produk baru. */
			$('#btn-add-item').click(function() {
				var form = $('#form-add-item');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-add-item').modal('hide');
						table.ajax.reload();
						new PNotify({
							title: 'Sukses!',
							text: response.data.name + ' berhasil ditambahkan dalam daftar produk.',
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
							cleanModal('#form-add-item', false);
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
			/* Aksi untuk tombol melihat deatail produk. */
			$('#items-table tbody').on('click', 'button[name="btn-show-item"]', function() {
				var url = APP_URL + '/items/' + $(this).data('id');
				$.ajax({
					url: url,
					method: 'GET',
					success: function(response) {
						$('.modal-body', '#modal-show-item').html(response);
					}
				});
				$('#modal-show-item').modal('show');
			});
			/* Aksi tombol untuk memperbarui informasi produk. */
			$('#items-table tbody').on('click', 'button[name="btn-edit-item"]', function() {
				/* Ambil data produk dari baris tombol yang ditekan. */
				var data = table.row($(this).closest('tr')).data();
				/* Mengisi nilai masing-masing bidang masukan formulir sesusai data yang diambil. */
				$.each($('input, select, textarea', '#form-edit-item'), function() {
					if ($(this).attr('id')) {
						var id_element = $(this).attr('id');
						if (data[id_element]) {
							$('#'+id_element, '#form-edit-item').val(data[id_element]).trigger('change');
						}
						else {
							$('#'+id_element, '#form-edit-item').val('').trigger('change');
						}
					}
				});
				/* Membatasi data yang boleh diubah pengguna dengan menghilangkan bidang yang dilindungi. */
				$('#modal-edit-item #div_sku').remove();
				$('#form-edit-item').attr('action', APP_URL + '/items/' + $(this).data('id'));
				cleanModal('#form-edit-item', false);
				var url = APP_URL + '/ajax/fetch-id-suppliers-for-item/' + $(this).data('id');
				$.ajax({
					url: url,
					method: 'GET',
					success: function(response) {
						var supplier_ids = response.supplier_ids;
						$('#supplier_id > option', '#form-edit-item').each(function () {
							$(this).prop('selected', false);
							var val = parseInt($(this).val());
							if ($.inArray(val, supplier_ids) != -1) {
								$(this).prop('selected', true);
							}
						});
						$('#supplier_id', '#form-edit-item').trigger('change');
					},
					error: function(response) {
						console.log(response);
					}
				});
				$('#modal-edit-item').modal('show');
			});
			$('#btn-edit-item').click(function () {
				var form = $('#form-edit-item');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-edit-item').modal('hide');
						table.ajax.reload();
						new PNotify({
							title: 'Sukses!',
							text: 'Data grup barang berhasil diubah.',
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
							cleanModal('#form-edit-item', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div_'+col_val, '#form-edit-item').addClass('has-error');
								$('#label_'+col_val, '#form-edit-item').html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
			$('#items-table tbody').on('click', 'button[name="btn-destroy-item"]', function() {
				$('#form-destroy-item').attr('action', APP_URL + '/items/' + $(this).data('id'));
				$('#modal-destroy-item').modal('show');
			});
			$('#btn-destroy-item').click(function () {
				var form = $('#form-destroy-item');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-destroy-item').modal('hide');
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
