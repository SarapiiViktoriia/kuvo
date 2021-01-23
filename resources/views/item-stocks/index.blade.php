@extends('layouts.dashboard', ['page_title' => 'Data Stok Barang'])
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
		<h2 class="panel-title">Data Stok Barang</h2>
	</header>
	<div class="panel-body">
		<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-item-stock">Tambah</button>
		@component('components.datatable-ajax', [
		'table_id' => 'item_stocks',
		'table_headers' => ['barang', 'inventory unit', 'jumlah'],
		'condition' => TRUE,
		'data' => [
		['name' => 'item.name', 'data' => 'item.name'],
		['name' => 'inventoryUnit.name', 'data' => 'inventory_unit.name'],
		['name' => 'count', 'data' => 'count'],
		]
		])
		@slot('data_send_ajax')
		@endslot
		])
		@endcomponent
		@include('item-stocks.create')
		@include('item-stocks.edit')
		@include('item-stocks.destroy')
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
						text: 'Terdapat kesalahan saat mengambil data inventory unit',
						type: 'warning'
					});
				}
			})
		}
		function fetch_items(form, selected){
			$.ajax({
				url: '{{ route('ajax.fetch_items') }}',
				method: 'GET',
				success: function(response){
					$('select[name="item_id"]', form).empty();
					$('select[name="item_id"]', form).append($('<option value="">Barang ...</option>'));
					$.each(response.items, function(key, value){
						$('select[name="item_id"]', form).append($('<option value="'+key+'">' + value + '</option>'));
					});
					if (selected) {
						$('select[name="item_id"]', form).val(selected).trigger('change');
					}
					$('select[name="item_id"]', form).select2({
						dropdownParent: $(form)
					});
				}, error: function(response){
					new PNotify({
						title: 'Peringatan!',
						text: 'Terdapat kesalahan saat mengambil data barang',
						type: 'warning'
					});
				}
			})
		}
		$('#modal-add-item-stock').on('shown.bs.modal', function(){
			cleanModal('#form-add-item-stock', true);
			fetch_inventory_units('#form-add-item-stock', null);
			fetch_items('#form-add-item-stock', null);
		})
		$('#btn-add-item-stock').click(function(){
			var form = $('#form-add-item-stock');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-add-item-stock').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data stok barang berhasil ditambahkan.',
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
						cleanModal('#form-add-item-stock', false);
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
		$('#item_stocks-table tbody').on('click', 'button[name="btn-edit-item-stock"]', function(){
			var data = table.row($(this).closest('tr')).data();
			var selected = null;
			$.each($('input, select, textarea', '#form-edit-item-stock'), function(){
				if ($(this).attr('id')) {
					var id_element = $(this).attr('id');
					if(data[id_element]){
						$('#'+id_element, '#form-edit-item-stock').val(data[id_element]).trigger('change');
					}else{
						$('#'+id_element, '#form-edit-item-stock').val('').trigger('change');
					}
				}	
			});
			cleanModal('#form-edit-item-stock', false);
			fetch_inventory_units('#form-edit-item-stock', data['inventory_unit_id']);
			fetch_items('#form-edit-item-stock', data['item_id']);
			$('#form-edit-item-stock').attr('action', APP_URL + '/item-stocks/'+ $(this).data('id'));
			$('#modal-edit-item-stock').modal('show');
		})
		$('#btn-edit-item-stock').click(function (){
			var form = $('#form-edit-item-stock');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-edit-item-stock').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data stok barang berhasil diubah.',
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
						cleanModal('#form-edit-item-stock', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val, '#form-edit-item-stock').addClass('has-error');
							$('#label_'+col_val, '#form-edit-item-stock').html(msg[0]);
						});
					}else{
						systemError();
					}
				}
			});
		})
		$('#item_stocks-table tbody').on('click', 'button[name="btn-destroy-item-stock"]', function(){
			$('#form-destroy-item-stock').attr('action', APP_URL + '/item-stocks/'+ $(this).data('id'));
			$('#modal-destroy-item-stock').modal('show');
		})
		$('#btn-destroy-item-stock').click(function (){
			var form = $('#form-destroy-item-stock');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-destroy-item-stock').modal('hide');
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
