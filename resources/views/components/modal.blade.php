<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">{{ ucwords(__($modal_title)) }}</h4>
			</div>
			<div class="modal-body">
				{{ $modal_body }}
			</div>
			<div class="modal-footer">
				{{ $modal_button }}
			</div>
		</div>
	</div>
</div>
