<div class="form-group mt-lg" id="div-name">
	<label class="control-label col-sm-3">{{ ucfirst(e(__('nama merek'))) }}</label>
	<div class="col-sm-9">
		<input type="text" name="name" class="form-control" id="name" required>
		<span class="help-block text-muted">Wajib diisi</span>
		<span class="help-block text-error" id="error-name"></span>
	</div>
</div>
<div class="form-group mt-lg" id="div-description">
	<label class="control-label col-sm-3">Deskripsi</label>
	<div class="col-sm-9">
		<textarea name="description" class="form-control" id="description"></textarea>
		<span class="help-block text-error" id="error-description"></span>
	</div>
</div>
