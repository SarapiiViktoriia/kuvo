@extends('layouts.dashboard', ['page_title' => 'Data Inventory Unit'])
@push('vendorstyles')
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}" />
@endpush
@section('content')
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a>
			<a href="#" class="fa fa-times"></a>
		</div>
		<h2 class="panel-title">Data Inventory Unit</h2>
	</header>
	<div class="panel-body">
		<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-inventory-unit">Tambah</button>
		@component('components.datatable-ajax', [
		'table_id' => 'inventory_units',
		'table_headers' => ['name', 'description'],
		'condition' => TRUE,
		'data' => [
		['name' => 'name', 'data' => 'name'],
		['name' => 'description', 'data' => 'description'],
		]
		])
		@slot('data_send_ajax')
		@endslot
		])
		@endcomponent
		@include('inventory-units.create')
		@include('inventory-units.edit')
		@include('inventory-units.destroy')
	</div>
</section>
@endsection
@push('appscripts')
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function (){
		$('#modal-add-inventory-unit').on('shown.bs.modal', function(){
			cleanModal('#form-add-inventory-unit', true);
		})
		$('#btn-add-inventory-unit').click(function(){
			var form = $('#form-add-inventory-unit');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-add-inventory-unit').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data Inventory unit berhasil ditambahkan.',
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
						cleanModal('#form-add-inventory-unit', false);
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
		$('#inventory_units-table tbody').on('click', 'button[name="btn-edit-inventory-unit"]', function(){
			var data = table.row($(this).closest('tr')).data();
			$.each($('input, select, textarea', '#form-edit-inventory-unit'), function(){
				if ($(this).attr('id')) {
					var id_element = $(this).attr('id');
					if(data[id_element]){
						$('#'+id_element, '#form-edit-inventory-unit').val(data[id_element]).trigger('change');
					}else{
						$('#'+id_element, '#form-edit-inventory-unit').val('').trigger('change');
					}
				}	
			});
			$('#form-edit-inventory-unit').attr('action', APP_URL + '/inventory-units/'+ $(this).data('id'));
			$('#modal-edit-inventory-unit').modal('show');
		})
		$('#modal-edit-inventory-unit').on('shown.bs.modal', function(){
			cleanModal('#form-edit-inventory-unit', false);
		})
		$('#btn-edit-inventory-unit').click(function (){
			var form = $('#form-edit-inventory-unit');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-edit-inventory-unit').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data inventory unit berhasil diubah.',
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
						cleanModal('#form-edit-inventory-unit', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val, '#form-edit-inventory-unit').addClass('has-error');
							$('#label_'+col_val, '#form-edit-inventory-unit').html(msg[0]);
						});
					}else{
						systemError();
					}
				}
			});
		})
		$('#inventory_units-table tbody').on('click', 'button[name="btn-destroy-inventory-unit"]', function(){
			$('#form-destroy-inventory-unit').attr('action', APP_URL + '/inventory-units/'+ $(this).data('id'));
			$('#modal-destroy-inventory-unit').modal('show');
		})
		$('#btn-destroy-inventory-unit').click(function (){
			var form = $('#form-destroy-inventory-unit');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-destroy-inventory-unit').modal('hide');
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
