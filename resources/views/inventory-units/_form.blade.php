<div class="form-group" id="div-label">
	<label class="control-label col-sm-3 text-right">{{ ucfirst(e(__('nama satuan'))) }}</label>
	<div class="col-sm-9">
		<input type="text" class="form-control" id="label" name="label" required>
		<label class="error" id="error-label"></label>
	</div>
</div>
<div class="form-group" id="div-pieces">
	<label class="control-label col-sm-3 text-right">{{ ucfirst(e(__('jumlah satuan'))) }}</label>
	<div class="col-sm-9">
		<input type="number" class="form-control" id="pieces" name="pieces" required>
		<label class="error" id="error-pieces"></label>
	</div>
</div>
