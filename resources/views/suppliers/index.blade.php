@extends('layouts.dashboard', ['page_title' => 'Data Supplier'])
@push('vendorstyles')
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />
@endpush
@section('content')
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a>
			<a href="#" class="fa fa-times"></a>
		</div>
		<h2 class="panel-title">Data Supplier</h2>
	</header>
	<div class="panel-body">
		<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-supplier">Tambah</button>
		@component('components.datatable-ajax', [
		'table_id' => 'suppliers',
		'table_headers' => ['code', 'name'],
		'condition' => TRUE,
		'data' => [
		['name' => 'code', 'data' => 'code'],
		['name' => 'name', 'data' => 'name'],
		]
		])
		@slot('data_send_ajax')
		@endslot
		])
		@endcomponent
		@include('suppliers.create')
		@include('suppliers.edit')
		@include('suppliers.destroy')
	</div>
</section>
@endsection
@push('appscripts')
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function (){
		$('#modal-add-supplier').on('shown.bs.modal', function(){
			cleanModal('#form-add-supplier', true);
		})
		$('#btn-add-supplier').click(function(){
			var form = $('#form-add-supplier');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-add-supplier').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data supplier berhasil ditambahkan.',
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
						cleanModal('#form-add-supplier', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val).addClass('has-error');
							$('#label_'+col_val).html(msg[0]);
						});
					}else{
						systemError();
					}
				}
			});
		})
		$('#suppliers-table tbody').on('click', 'button[name="btn-edit-supplier"]', function(){
			var data = table.row($(this).closest('tr')).data();
			$.each($('input, select, textarea', '#form-edit-supplier'), function(){
				if ($(this).attr('id')) {
					var id_element = $(this).attr('id');
					if(data[id_element]){
						$('#'+id_element, '#form-edit-supplier').val(data[id_element]).trigger('change');
					}else{
						$('#'+id_element, '#form-edit-supplier').val('').trigger('change');
					}
				}	
			});
			$('#form-edit-supplier').attr('action', APP_URL + '/suppliers/'+ $(this).data('id'));
			$('#modal-edit-supplier').modal('show');
		})
		$('#modal-edit-supplier').on('shown.bs.modal', function(){
			cleanModal('#form-edit-supplier', false);
		})
		$('#btn-edit-supplier').click(function (){
			var form = $('#form-edit-supplier');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-edit-supplier').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data supplier berhasil diubah.',
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
						cleanModal('#form-edit-supplier', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val, '#form-edit-supplier').addClass('has-error');
							$('#label_'+col_val, '#form-edit-supplier').html(msg[0]);
						});
					}else{
						systemError();
					}
				}
			});
		})
		$('#suppliers-table tbody').on('click', 'button[name="btn-destroy-supplier"]', function(){
			$('#form-destroy-supplier').attr('action', APP_URL + '/suppliers/'+ $(this).data('id'));
			$('#modal-destroy-supplier').modal('show');
		})
		$('#btn-destroy-supplier').click(function (){
		var form = $('#form-destroy-supplier');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-destroy-supplier').modal('hide');
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
