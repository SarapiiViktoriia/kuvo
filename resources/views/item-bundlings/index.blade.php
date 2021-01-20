@extends('layouts.dashboard', ['page_title' => 'Data Item Bundling'])
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
		<h2 class="panel-title">Data Item Bundling</h2>
	</header>
	<div class="panel-body">
		<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-item-bundling">Tambah</button>
		@component('components.datatable-ajax', [
		'table_id' => 'item_bundlings',
		'table_headers' => ['inventory unit', 'name', 'description'],
		'condition' => TRUE,
		'data' => [
		['name' => 'inventoryUnit.name', 'data' => 'inventory_unit.name'],
		['name' => 'name', 'data' => 'name'],
		['name' => 'description', 'data' => 'description'],
		]
		])
		@slot('data_send_ajax')
		@endslot
		])
		@endcomponent
		@include('item-bundlings.create')
		@include('item-bundlings.edit')
		@include('item-bundlings.destroy')
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
		function fetch_inventory_units(form, selected){
			$.ajax({
				url: '{{ route('ajax.fetch_inventory_units') }}',
				method: 'GET',
				success: function(response){
					$('select[name="inventory_unit_id"]', form).empty();
					$('select[name="inventory_unit_id"]', form).append($('<option value="">Inventory Unit ...</option>'));
					$.each(response.inventory_units, function(key, value){
						$('select[name="inventory_unit_id"]', form).append($('<option value="'+key+'">' + value + '</option>'));
					});
					if (selected) {
						$('select[name="inventory_unit_id"]', form).val(selected).trigger('change');
					}
					$('select[name="inventory_unit_id"]', form).select2({
						dropdownParent: $(form)
					});
				}, error: function(response){
					new PNotify({
						title: 'Peringatan!',
						text: 'Terdapat kesalahan saat mengambil data',
						type: 'warning'
					});
				}
			})
		}
		$('#modal-add-item-bundling').on('shown.bs.modal', function(){
			cleanModal('#form-add-item-bundling', true);
			fetch_inventory_units('#form-add-item-bundling', null);
		})
		$('#btn-add-item-bundling').click(function(){
			var form = $('#form-add-item-bundling');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-add-item-bundling').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data item bundling berhasil ditambahkan.',
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
						cleanModal('#form-add-item-bundling', false);
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
		$('#item_bundlings-table tbody').on('click', 'button[name="btn-edit-item-bundling"]', function(){
			var data = table.row($(this).closest('tr')).data();
			var selected = null;
			$.each($('input, select, textarea', '#form-edit-item-bundling'), function(){
				if ($(this).attr('id')) {
					var id_element = $(this).attr('id');
					if(data[id_element]){
						$('#'+id_element, '#form-edit-item-bundling').val(data[id_element]).trigger('change');
					}else{
						$('#'+id_element, '#form-edit-item-bundling').val('').trigger('change');
					}
					if (id_element == 'inventory_unit_id') {
						selected = data[id_element];
					}
				}	
			});
			cleanModal('#form-edit-item-bundling', false);
			fetch_inventory_units('#form-edit-item-bundling', selected);
			$('#form-edit-item-bundling').attr('action', APP_URL + '/item-bundlings/'+ $(this).data('id'));
			$('#modal-edit-item-bundling').modal('show');
		})
		$('#btn-edit-item-bundling').click(function (){
			var form = $('#form-edit-item-bundling');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-edit-item-bundling').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data item bundling berhasil diubah.',
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
						cleanModal('#form-edit-item-bundling', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val, '#form-edit-item-bundling').addClass('has-error');
							$('#label_'+col_val, '#form-edit-item-bundling').html(msg[0]);
						});
					}else{
						systemError();
					}
				}
			});
		})
		$('#item_bundlings-table tbody').on('click', 'button[name="btn-destroy-item-bundling"]', function(){
			$('#form-destroy-item-bundling').attr('action', APP_URL + '/item-bundlings/'+ $(this).data('id'));
			$('#modal-destroy-item-bundling').modal('show');
		})
		$('#btn-destroy-item-bundling').click(function (){
			var form = $('#form-destroy-item-bundling');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-destroy-item-bundling').modal('hide');
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
