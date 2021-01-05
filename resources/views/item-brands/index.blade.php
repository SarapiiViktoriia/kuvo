@extends('layouts.dashboard', ['page_title' => 'Data Brand Barang'])
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
		<h2 class="panel-title">Data Brand Barang</h2>
	</header>
	<div class="panel-body">
		<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-item-brand">Tambah</button>
		@component('components.datatable-ajax', [
		'table_id' => 'item_brands',
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
		@include('item-brands.create')
		@include('item-brands.edit')
		@include('item-brands.destroy')
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
		$('#modal-add-item-brand').on('shown.bs.modal', function(){
			cleanModal('#form-add-item-brand', true);
		})
		$('#btn-add-item-brand').click(function(){
			var form = $('#form-add-item-brand');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-add-item-brand').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data brand barang berhasil ditambahkan.',
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
						cleanModal('#form-add-item-brand', false);
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
		$('#item_brands-table tbody').on('click', 'button[name="btn-edit-item-brand"]', function(){
			var data = table.row($(this).closest('tr')).data();
			$.each($('input, select, textarea', '#form-edit-item-brand'), function(){
				if ($(this).attr('id')) {
					var id_element = $(this).attr('id');
					if(data[id_element]){
						$('#'+id_element, '#form-edit-item-brand').val(data[id_element]).trigger('change');
					}else{
						$('#'+id_element, '#form-edit-item-brand').val('').trigger('change');
					}
				}	
			});
			$('#form-edit-item-brand').attr('action', APP_URL + '/item-brands/'+ $(this).data('id'));
			$('#modal-edit-item-brand').modal('show');
		})
		$('#modal-edit-item-brand').on('shown.bs.modal', function(){
			cleanModal('#form-edit-item-brand', false);
		})
		$('#btn-edit-item-brand').click(function (){
			var form = $('#form-edit-item-brand');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-edit-item-brand').modal('hide');
					table.ajax.reload();
					new PNotify({
						title: 'Sukses!',
						text: 'Data brand barang berhasil diubah.',
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
						cleanModal('#form-edit-item-brand', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val, '#form-edit-item-brand').addClass('has-error');
							$('#label_'+col_val, '#form-edit-item-brand').html(msg[0]);
						});
					}else{
						systemError();
					}
				}
			});
		})
		$('#item_brands-table tbody').on('click', 'button[name="btn-destroy-item-brand"]', function(){
			$('#form-destroy-item-brand').attr('action', APP_URL + '/item-brands/'+ $(this).data('id'));
			$('#modal-destroy-item-brand').modal('show');
		})
		$('#btn-destroy-item-brand').click(function (){
			var form = $('#form-destroy-item-brand');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-destroy-item-brand').modal('hide');
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
