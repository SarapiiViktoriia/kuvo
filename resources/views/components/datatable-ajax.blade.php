<table class="table table-striped table-condensed" id="{{ $table_id }}-table" style="width: 100%;">
	<thead>
		<tr>
			<th class="col-sm-1">NO</th>
			@foreach($table_headers as $table_header)
				<th>{{ strtoupper(e(__($table_header))) }}</th>
			@endforeach
			@if($condition)
				<th class="col-sm-3">{{ strtoupper(e(__('aksi'))) }}</th>
			@endif
		</tr>
	</thead>
</table>
@push('vendorstyles')
	<link href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" rel="stylesheet" type="text/css">
@endpush
@push('vendorscripts')
	<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}" type="text/javascript"></script>
@endpush
@push('appscripts')
	<script type="text/javascript">
		$(document).ready(function() {
			/* Mempersiapkan data untuk ditampilkan oleh datatable. */
			table = $("#{{ $table_id }}-table").DataTable({
				processing: true,
				serverSide: true,
				responsive: true,
				ajax: {
					url: '{{ route('ajax.' . $table_id . '.data') }}',
					dataType: "json",
					type: "POST",
					data: function(d) {
						{{ $data_send_ajax }}
					}
				},
				columns: [
					{ targets: 0, data: 'null', defaultContent: '', orderable: false, searchable: false },
					@foreach ($data as $value)
						{ data: '{{ $value['data'] }}', name: '{{ $value['name'] }}', orderable: {{ isset($value['orderable']) ? $value['orderable'] : 'true' }}, searchable: {{ isset($value['searchable']) ? $value['searchable'] : 'true' }}, },
					@endforeach
					@if ($condition)
						{ data: 'action', name : 'action', orderable: false, searchable: false },
					@endif
				],
				columnDefs: [
					{ responsivePriority: 1, targets: 0 },
				],
				order: [1, 'asc'],
			});
			/* Membuat nomor urut pada datatable. */
			table.on('draw.dt', function () {
				var info = table.page.info();
				table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
					cell.innerHTML = i + 1 + info.start;
				});
			});
		});
	</script>
@endpush
