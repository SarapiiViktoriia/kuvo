@extends('layouts.dashboard', ['page_title' => 'daftar perusahaan'])
@section('content')
    @component('components.panel',
    ['context'    => '',
    'panel_title' => 'daftar perusahaan'])
        <div style="margin-bottom: 2em;">
            <button class="btn btn-primary btn-model-add" data-toggle="modal" data-target="#modal-add-company">
                <span class="fa fa-plus"></span>
                {{ ucwords(__('tambah perusahaan')) }}
            </button>
        </div>
        @component('components.datatable-ajax',
        ['table_id'     => 'companies',
        'table_headers' => ['kode', 'nama'],
        'condition'     => true,
        'data'          => [
			['name' => 'code', 'data' => 'code'],
			['name' => 'name', 'data' => 'name']]
        ])
            @slot('data_send_ajax')
            @endslot
        @endcomponent
        @include('companies.create')
        @include('companies.edit')
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
            /* Menggunakan select2 */
			$('select').select2();
            /* Modal penambahan data */
			$('#modal-add-company').on(
                'shown.bs.modal',
                function() {
                    cleanModal('#form-add-company', true);
                }
            );
            /* Penyimpanan data modal penambahan data. */
			$('#btn-add-company').click(function() {
				var form = $('#form-add-company');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
                        $('#modal-add-company').modal('hide');
						table.ajax.reload();
						new PNotify({
							title: 'Sukses!',
							text: 'Data perusahaan berhasil ditambahkan.',
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
                            cleanModal('#form-add-company', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div_' + col_val).addClass('has-error');
								$('#label_' + col_val).html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
            /*
			$('#companies-table tbody').on('click', 'button[name="btn-show-company"]', function() {
				var url = APP_URL + '/companies/'+ $(this).data('id');
				$.ajax({
					url: url,
					method: 'GET',
					success: function(response) {
						$('.modal-body', '#modal-show-company').html(response);
					}
				});
				$('#modal-show-company').modal('show');
            });
            */
            /* Menampilkan modal ubah data. */
			$('#companies-table tbody').on('click', 'button[name="btn-edit-company"]', function() {
				var data = table.row($(this).closest('tr')).data();
				$.each($('input, select, textarea', '#form-edit-company'), function() {
					if ($(this).attr('id')) {
                        var id_element = $(this).attr('id');
						if (data[id_element]) {
							$('#' + id_element, '#form-edit-company').val(data[id_element]).trigger('change');
						}
						else {
							if ($(this).attr('type') != 'checkbox') {
								$('#' + id_element, '#form-edit-company').val('').trigger('change');
							}
						}
					}
				});
				$('select[name="user_id"]', '#form-edit-company').val(data['company_id']).trigger('change');
				$('#form-edit-company').attr('action', APP_URL + '/companies/' + $(this).data('id'));
				cleanModal('#form-edit-company', false);
				$('#modal-edit-company').modal('show');
			});
            /* Menyimpan data modal pengubahan data. */
			$('#btn-edit-company').click(function () {
				var form = $('#form-edit-company');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
                        $('#modal-edit-company').modal('hide');
						table.ajax.reload();
						new PNotify({
							title: 'Sukses!',
							text: 'Data profil berhasil diubah.',
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
                            cleanModal('#form-edit-company', false);
							$.each(errors.errors, function(col_val, msg) {
								$('#div_' + col_val, '#form-edit-company').addClass('has-error');
								$('#label_' + col_val, '#form-edit-company').html(msg[0]);
							});
						}
						else {
							systemError();
						}
					}
				});
			});
            /* Menampilkan modal penghapusan data. */
			$('#companies-table tbody').on('click', 'button[name="btn-destroy-company"]', function() {
				$('#form-destroy-company').attr('action', APP_URL + '/companies/' + $(this).data('id'));
				$('#modal-destroy-company').modal('show');
			});
            /* Memproses data modal penghapusan. */
			$('#btn-destroy-company').click(function () {
				var form = $('#form-destroy-company');
				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					success: function(response) {
						$('#modal-destroy-company').modal('hide');
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
