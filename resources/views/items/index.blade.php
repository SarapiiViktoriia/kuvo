@extends('layouts.dashboard', ['page_title' => 'Data Barang'])
@push('vendorstyles')
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}" />
@endpush
@section('content')
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a>
			<a href="#" class="fa fa-times"></a>
		</div>
		<h2 class="panel-title">Data Barang</h2>
	</header>
	<div class="panel-body">
		<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-item">Tambah</button>
		@component('components.datatable-ajax', [
		'table_id' => 'items',
		'table_headers' => ['kode', 'nama', 'grup barang', 'brand'],
		'condition' => TRUE,
		'data' => [
		['name' => 'code', 'data' => 'code'],
		['name' => 'name', 'data' => 'name'],
		['name' => 'itemGroup.name', 'data' => 'item_group.name'],
		['name' => 'itemBrand.name', 'data' => 'item_brand.name'],
		]
		])
		@slot('data_send_ajax')
		@endslot
		])
		@endcomponent
		@include('items.create')
		@include('items.edit')
		@include('items.destroy')
		@include('items.show')
	</div>
</section>
@endsection
@push('appscripts')
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/javascripts/forms/examples.advanced.form.js') }}" /></script>
<script type="text/javascript">
	$(document).ready(function (){
		$('select').select2();
		$('#modal-add-item').on('shown.bs.modal', function(){
			cleanModal('#form-add-item', true);
		})
		$('#btn-add-item').click(function(){
			var form = $('#form-add-item');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-add-item').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data grup barang berhasil ditambahkan.',
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
						cleanModal('#form-add-item', false);
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
		$('#items-table tbody').on('click', 'button[name="btn-show-item"]', function(){
			var url = APP_URL + '/items/'+ $(this).data('id');
			$.ajax({
				url: url,
				method: 'GET',
				success: function(response){
					$('.modal-body', '#modal-show-item').html(response);
				}
			})
			$('#modal-show-item').modal('show');
		})
		$('#items-table tbody').on('click', 'button[name="btn-edit-item"]', function(){
			var data = table.row($(this).closest('tr')).data();
			$.each($('input, select, textarea', '#form-edit-item'), function(){
				if ($(this).attr('id')) {
					var id_element = $(this).attr('id');
					if(data[id_element]){
						$('#'+id_element, '#form-edit-item').val(data[id_element]).trigger('change');
					}else{
						$('#'+id_element, '#form-edit-item').val('').trigger('change');
					}
				}	
			});
			$('#form-edit-item').attr('action', APP_URL + '/items/'+ $(this).data('id'));
			cleanModal('#form-edit-item', false);
			var url = APP_URL + '/ajax/fetch-id-suppliers-for-item/'+ $(this).data('id');
			$.ajax({
				url: url,
				method: 'GET',
				success: function(response){
					var supplier_ids = response.supplier_ids;
					$('#supplier_id > option', '#form-edit-item').each(function (){
						$(this).prop('selected', false);
						var val = parseInt($(this).val());
						if ($.inArray(val, supplier_ids) != -1) {
							$(this).prop('selected', true);
						}
					})
					$('#supplier_id', '#form-edit-item').trigger('change');
				}, error: function(response){
					console.log(response);
				}
			})
			$('#modal-edit-item').modal('show');
		})
		$('#btn-edit-item').click(function (){
			var form = $('#form-edit-item');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-edit-item').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data grup barang berhasil diubah.',
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
						cleanModal('#form-edit-item', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val, '#form-edit-item').addClass('has-error');
							$('#label_'+col_val, '#form-edit-item').html(msg[0]);
						});
					}else{
						systemError();
					}
				}
			});
		})
		$('#items-table tbody').on('click', 'button[name="btn-destroy-item"]', function(){
			$('#form-destroy-item').attr('action', APP_URL + '/items/'+ $(this).data('id'));
			$('#modal-destroy-item').modal('show');
		})
		$('#btn-destroy-item').click(function (){
			var form = $('#form-destroy-item');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-destroy-item').modal('hide');
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
