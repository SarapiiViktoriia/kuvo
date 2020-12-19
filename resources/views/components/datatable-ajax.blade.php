<table class="table table-bordered table-striped" id="{{ $table_id }}-table" style="width: 100%">
	<thead>
		<tr>
			<th>No</th>
			@foreach($table_headers as $table_header)
			<th>{{ ucwords(e(__($table_header))) }}</th>
			@endforeach
			@if($condition)
			<th style="text-align: center;">{{ ucwords(e(__('action'))) }}</th>
			@endif
		</tr>
	</thead>
</table>
@push('scripts')
<script>
	var table;
	$(function() {
		table = $("#{{ $table_id }}-table").DataTable({
			processing: true,
			serverSide: true,
			responsive: true,
			ajax: {
				url : '{{ route('ajax.'.$table_id.'.data') }}',
				dataType : "json",
				type : "POST",
				data : function(d){
					{{ $data_send_ajax }}
				}
			},
			columns: [
			{ targets: 0, data: 'null', defaultContent: '', orderable: false, searchable: false },
			@foreach($data as $value)
			{ data: '{{ $value['data'] }}', name: '{{ $value['name'] }}', orderable: {{ isset($value['orderable']) ? $value['orderable'] : 'true' }}, searchable: {{ isset($value['searchable']) ? $value['searchable'] : 'true' }}, },
			@endforeach
			@if($condition)
			{ data: 'action', name : 'action', orderable: false, searchable: false },
			@endif
			],
			columnDefs: [
			{ responsivePriority: 1, targets: 0 },
			],
			order: [1, 'asc'],
		}
		);
		table.on('draw.dt', function () {
			var info = table.page.info();
			table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
				cell.innerHTML = i + 1 + info.start;
			});
		});
		function filter()
		{
			table.draw();
		}
		$('button[name="btn-reset"]').on('click', function(){
			reset();
		})
		function reset()
		{
			$(".js-example-basic-single").val("");
			$(".js-example-basic-single").select2();
			table.search('');
			table.columns().search('');
			table.draw();
		}
		$('select').on('change', function (){
			table.draw();
		})
	});
</script>
@endpush
