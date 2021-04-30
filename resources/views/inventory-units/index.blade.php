@extends('layouts.dashboard', ['page_title' => 'manajemen produk'])
@section('content')
	<p class="lead">
		Di sini kamu dapat mengatur informasi tentang satuan produk
		yang kamu miliki. Kamu dapat melihat daftar satuan produk,
		menambahkan satuan baru, memperbarui informasi satuan yang ada,
		dan menghapus satuan yang sudah ada.
	</p>
	@component('components.panel', [
		'context'     => '',
		'panel_title' => 'daftar satuan produk'
	])
		<div class="mb-lg">
			<button class="btn btn-primary btn-model-add" data-toggle="modal" data-target="#modal-add-inventory-unit" data-backdrop="static" data-keyboard="false">
				<span class="fa fa-plus"></span>
				{{ ucwords(__('satuan baru')) }}
			</button>
		</div>
		@component('components.datatable-ajax', [
			'table_id'      => 'units',
			'table_headers' => ['nama satuan', 'jumlah satuan (pieces)'],
			'condition'     => true,
			'data'          => [
				['name' => 'label', 'data' => 'label'],
				['name' => 'pieces', 'data' => 'pieces'],
			]
		])
			@slot('data_send_ajax')
			@endslot
		@endcomponent
		@include('inventory-units.create')
		@include('inventory-units.edit')
		@include('inventory-units.destroy')
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
		$(document).ready(function () {
			/*
			 * Memodifikasi tampilan formulir penambahan resource
			 * ketika modal penambahan resource dimunculkan.
			 */
			$('#modal-add-inventory-unit').on('shown.bs.modal', function () {
				cleanModal('#form-add-inventory-unit', true);
			})
			/*
			 * Mengirim data pada form penambahan resource saat tombol submisi ditekan.
			 */
			$('#btn-add-inventory-unit').click(function () {
				var form = $('#form-add-inventory-unit');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-add-inventory-unit').modal('hide');
						table.ajax.reload();
						new PNotify({
							type:  'success',
							title: 'Berhasil!',
							text:  response.data.label + ' ' + response.data.pieces + ' pieces berhasil ditambahkan dalam daftar satuan.',
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
							cleanModal('#form-add-inventory-unit', false);
							$.each(errors.errors, function(col_val, msg){
								$('#div-' + col_val).addClass('has-error');
								$('#error-' + col_val).html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			})
			/*
			 * Menampilkan jendela modal ketika tombol show resource ditekan.
			 */
			$('#units-table tbody').on('click', 'button[name="btn-edit-inventory-unit"]', function () {
				// Ambil data supplier dari baris tombol yang ditekan.
				var data = table.row($(this).closest('tr')).data();
				// Mengisi nilai masing-masing bidang masukan formulir sesusai data yang diambil.
				$.each($('input, select, textarea', '#form-edit-inventory-unit'), function () {
					if ($(this).attr('id')) {
						var id_element = $(this).attr('id');
						if (data[id_element]){
							$('#' + id_element, '#form-edit-inventory-unit').val(data[id_element]).trigger('change');
						}
						else {
							$('#' + id_element, '#form-edit-inventory-unit').val('').trigger('change');
						}
					}
				});
				// Menetapkan URL untuk pemrosesan form.
				$('#form-edit-inventory-unit').attr('action', APP_URL + '/inventory-units/'+ $(this).data('id'));
				// Menampilkan jendela modal kepada pengguna.
				$('#modal-edit-inventory-unit').modal('show');
			})
			/*
			 * Memodifikasi tampilan formulir pengubahan resource
			 * ketika modal pengubahan resource dimunculkan.
			 */
			$('#modal-edit-inventory-unit').on('shown.bs.modal', function() {
				// Menghapus isian formulir.
				cleanModal('#form-edit-inventory-unit', false);
			})
			/*
			 * Menampilkan jendela modal ketika tombol edit resource ditekan.
			 */
			$('#btn-edit-inventory-unit').click(function () {
				var form = $('#form-edit-inventory-unit');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-edit-inventory-unit').modal('hide');
						table.ajax.reload();
						new PNotify({
							type:  'success',
							title: 'Sukses!',
							text:  'Informasi satuan ' + response.data.label + ' ' + response.data.pieces + ' berhasil diubah.',
						});
					},
					error: function (response) {
						console.log(response);
						if (response.status == 422) {
							var errors = response.responseJSON;
							new PNotify({
								type:  'warning',
								title: 'Peringatan!',
								text:  'Terdapat kesalahan pada data yang dimasukkan',
							});
							cleanModal('#form-edit-inventory-unit', false);
							$.each(errors.errors, function(col_val, msg){
								$('#div-' + col_val, '#form-edit-inventory-unit').addClass('has-error');
								$('#error-' + col_val, '#form-edit-inventory-unit').html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			})
			/*
			 * Menampilkan jendela modal ketika tombol hapus resource ditekan.
			 */
			$('#units-table tbody').on('click', 'button[name="btn-destroy-inventory-unit"]', function() {
				// Menetapkan URL untuk pemrosesan form.
				$('#form-destroy-inventory-unit').attr('action', APP_URL + '/inventory-units/'+ $(this).data('id'));
				// Menampilkan jendela modal.
				$('#modal-destroy-inventory-unit').modal('show');
			})
			/*
			 * Mengirim data pada form penghapusan resource saat tombol submisi ditekan.
			 */
			$('#btn-destroy-inventory-unit').click(function (){
				var form = $('#form-destroy-inventory-unit');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-destroy-inventory-unit').modal('hide');
						if (response.status == 'destroyed') {
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
					error: function(response){
						systemError();
					}
				});
			});
		});
	</script>
@endpush
