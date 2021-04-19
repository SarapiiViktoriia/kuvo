@extends('layouts.dashboard', ['page_title' => 'manajemen produk'])
@section('content')
	<p class="lead">
		Di sini kamu dapat mengatur kategori produk yang kamu sediakan.
		Kamu dapat melihat daftar semua kategori, menambahkan
		kategori baru, dan memperbarui informasi kategori produk.
	</p>
	@component('components.panel', [
		'context'     => '',
		'panel_title' => 'daftar kategori produk'
	])
		<div class="mb-lg">
			<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-item-group" data-backdrop="static" data-keyboard="false">
				<span class="fa fa-plus"></span>
				{{ ucwords(__('kategori baru')) }}
			</button>
		</div>
		@component('components.datatable-ajax', [
			'table_id'      => 'item-groups',
			'table_headers' => ['induk kategori', 'nama kategori'],
			'condition'     => true,
			'data'          => [
				['name' => 'parent_name', 'data' => 'parent_name'],
				['name' => 'name', 'data' => 'name']
			]
		])
			@slot('data_send_ajax')
			@endslot
		@endcomponent
		@include('item-groups.create')
		@include('item-groups.show')
		@include('item-groups.edit')
		@include('item-groups.destroy')
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
			/* Mengambil semua kategori induk. */
			function fetch_item_groups(form, selected, disabled) {
				$.ajax({
					url:    '{{ route('api.item-groups.index') }}',
					method: 'GET',
					success: function(response) {
						$('select[name="parent_id"]', form).empty();
						$('select[name="parent_id"]', form).append($('<option value="">Pilih kategori induk ...</option>'));
						$.each(response.data, function(key, value) {
							if (key == disabled) {
								$('select[name="parent_id"]', form).append($('<option value="' + value.id + '" disabled>' + value.name + '</option>'));
							}
							else {
								$('select[name="parent_id"]', form).append($('<option value="' + value.id + '">' + value.name + '</option>'));
							}
						});
						if (selected) {
							$('select[name="parent_id"]', form).val(selected).trigger('change');
						}
						$('select[name="parent_id"]', form).select2({
							dropdownParent: $(form)
						});
					},
					error: function(response) {
						new PNotify({
							type:  'warning',
							title: 'Peringatan!',
							text:  'Terdapat kesalahan saat mengambil data kategori produk',
						});
					}
				});
			}
			/* Menampilkan induk kategori pada formulir penambahan resource. */
			$('#modal-add-item-group').on('shown.bs.modal', function() {
				cleanModal('#form-add-item-group', true);
				fetch_item_groups('#form-add-item-group', null, null);
			});
			/* Memproses submisi formulir penambahan resource. */
			$('#btn-add-item-group').click(function() {
				var form = $('#form-add-item-group');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-add-item-group').modal('hide');
						table.ajax.reload();
						new PNotify({
							type:  'success',
							title: 'Sukses!',
							text:  'Kategori produk ' + response.data.name + ' berhasil ditambahkan.',
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
							cleanModal('#form-add-item-group', false);
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
			});
			/* Menampilkan modal untuk melihat detail data resource. */
			$('#item-groups-table tbody').on('click', 'button[name="btn-show-item-group"]', function() {
				var data = table.row($(this).closest('tr')).data();
				$('#show-item-group-title', '#modal-show-item-group').empty();
				$('#show-item-group-description', '#modal-show-item-group').empty();
				$('#show-item-group-description', '#modal-show-item-group').append(data.description);
				if (null !== data.parent_name) {
					$('#show-item-group-title', '#modal-show-item-group').append(data.parent_name + ' > ' + data.name);
				}
				else {
					$('#show-item-group-title', '#modal-show-item-group').append(data.name);
				}
				$('#modal-show-item-group').modal('show');
			});
			/* Menampilkan formulir pengubahan data resource. */
			$('#item-groups-table tbody').on('click', 'button[name="btn-edit-item-group"]', function() {
				$('#modal-edit-item-group').modal({backdrop: "static", keyboard: false});
				var data     = table.row($(this).closest('tr')).data();
				var selected = null;
				$.each($('input, select, textarea', '#form-edit-item-group'), function() {
					if ($(this).attr('id')) {
						var id_element = $(this).attr('id');
						if (data[id_element]) {
							$('#' + id_element, '#form-edit-item-group').val(data[id_element]).trigger('change');
						}
						else {
							$('#' + id_element, '#form-edit-item-group').val('').trigger('change');
						}
						if (id_element == 'parent_id') {
							selected = data[id_element];
						}
					}
				});
				cleanModal('#form-edit-item-group', false);
				fetch_item_groups('#form-edit-item-group', selected, $(this).data('id') - 1);
				$('#form-edit-item-group').attr('action', APP_URL + '/item-groups/' + $(this).data('id'));
				$('#modal-edit-item-group').modal('show');
			});
			/* Memproses data submisi pengubahan resource. */
			$('#btn-edit-item-group').click(function () {
				var form = $('#form-edit-item-group');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-edit-item-group').modal('hide');
						table.ajax.reload();
						new PNotify({
							type:  'success',
							title: 'Berhasil!',
							text:  'Informasi kategori produk ' + response.data.name + ' berhasil diperbarui.',
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
							cleanModal('#form-edit-item-group', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div-' + col_val, '#form-edit-item-group').addClass('has-error');
								$('#error-' + col_val, '#form-edit-item-group').html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
			/* Menampilkan formulir penghapusan resource. */
			$('#item-groups-table tbody').on('click', 'button[name="btn-destroy-item-group"]', function() {
				$('#form-destroy-item-group').attr('action', APP_URL + '/item-groups/'+ $(this).data('id'));
				$('#modal-destroy-item-group').modal('show');
			});
			/* Memproses data submisi penghapusan resource. */
			$('#btn-destroy-item-group').click(function () {
				var form = $('#form-destroy-item-group');
				$.ajax({
					url:    form.attr('action'),
					method: form.attr('method'),
					data:   form.serialize(),
					success: function(response) {
						$('#modal-destroy-item-group').modal('hide');
						if (response.status == 'success') {
							new PNotify({
								type:  'success',
								title: 'Berhasil!',
								text:   response.message,
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
