@extends('layouts.dashboard', ['page_title' => 'Data Grup Barang'])
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
		<h2 class="panel-title">Data Grup Barang</h2>
	</header>
	<div class="panel-body">
		<button type="button" class="btn btn-primary btn-modal-add" data-toggle="modal" data-target="#modal-add-item-group">Tambah</button>
		@component('components.datatable-ajax', [
		'table_id' => 'item_groups',
		'table_headers' => ['parent', 'name', 'description'],
		'condition' => TRUE,
		'data' => [
		['name' => 'parent_name', 'data' => 'parent_name'],
		['name' => 'name', 'data' => 'name'],
		['name' => 'description', 'data' => 'description'],
		]
		])
		@slot('data_send_ajax')
		@endslot
		])
		@endcomponent
		@include('item-groups.create')
		@include('item-groups.edit')
		@include('item-groups.destroy')
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
		function fetch_item_groups(form, selected, disabled){
			$.ajax({
				url: '{{ route('ajax.fetch_item_groups') }}',
				method: 'GET',
				success: function(response){
					$('select[name="parent_id"]', form).empty();
					$('select[name="parent_id"]', form).append($('<option value="">Parent ...</option>'));
					$.each(response.item_groups, function(key, value){
						if (key == disabled) {
							$('select[name="parent_id"]', form).append($('<option value="'+key+'" disabled>' + value + '</option>'));
						}else{
							$('select[name="parent_id"]', form).append($('<option value="'+key+'">' + value + '</option>'));
						}
					});
					if (selected) {
						$('select[name="parent_id"]', form).val(selected).trigger('change');
					}
					$('select[name="parent_id"]', form).select2({
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
		$('#modal-add-item-group').on('shown.bs.modal', function(){
			cleanModal('#form-add-item-group', true);
			fetch_item_groups('#form-add-item-group', null, null);
		})
		$('#btn-add-item-group').click(function(){
			var form = $('#form-add-item-group');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-add-item-group').modal('hide');
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
						cleanModal('#form-add-item-group', false);
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
		$('#item_groups-table tbody').on('click', 'button[name="btn-edit-item-group"]', function(){
			var data = table.row($(this).closest('tr')).data();
			var selected = null;
			$.each($('input, select, textarea', '#form-edit-item-group'), function(){
				if ($(this).attr('id')) {
					var id_element = $(this).attr('id');
					if(data[id_element]){
						$('#'+id_element, '#form-edit-item-group').val(data[id_element]).trigger('change');
					}else{
						$('#'+id_element, '#form-edit-item-group').val('').trigger('change');
					}
					if (id_element == 'parent_id') {
						selected = data[id_element];
					}
				}	
			});
			fetch_item_groups('#form-edit-item-group', selected, $(this).data('id'));
			cleanModal('#form-edit-item-group', false);
			$('#form-edit-item-group').attr('action', APP_URL + '/item-groups/'+ $(this).data('id'));
			$('#modal-edit-item-group').modal('show');
		})
		$('#btn-edit-item-group').click(function (){
			var form = $('#form-edit-item-group');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-edit-item-group').modal('hide');
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
						cleanModal('#form-edit-item-group', false);
						$.each(errors.errors, function(col_val, msg){
							$('#div_'+col_val, '#form-edit-item-group').addClass('has-error');
							$('#label_'+col_val, '#form-edit-item-group').html(msg[0]);
						});
					}else{
						systemError();
					}
				}
			});
		})
		$('#item_groups-table tbody').on('click', 'button[name="btn-destroy-item-group"]', function(){
			$('#form-destroy-item-group').attr('action', APP_URL + '/item-groups/'+ $(this).data('id'));
			$('#modal-destroy-item-group').modal('show');
		})
		$('#btn-destroy-item-group').click(function (){
			var form = $('#form-destroy-item-group');
			$.ajax({
				url: form.attr('action'),
				method: form.attr('method'),
				data: form.serialize(),
				success: function(response){
					$('#modal-destroy-item-group').modal('hide');
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
