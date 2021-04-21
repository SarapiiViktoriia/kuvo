<div class="form-group mt-lg" id="div-code">
	<label class="col-sm-3 control-label">Kode supplier</label>
	<div class="col-sm-9">
		<input type="text" id="code" name="code" class="form-control" required>
		<span class="help-block text-muted">Wajib diisi. Kode tidak boleh sama dengan perusahaan lainnya.</span>
		<span class="help-block text-error" id="error-code"></span>
	</div>
</div>
<div class="form-group mt-lg" id="div-name">
	<label class="col-sm-3 control-label">Nama perusahaan</label>
	<div class="col-sm-9">
		<input type="text" id="name" name="name" class="form-control" required>
		<span class="help-block text-muted">Wajib diisi</span>
		<span class="help-block text-error" id="error-name"></span>
	</div>
</div>
<div class="form-group mt-lg" id="div-type">
	<label class="col-sm-3 control-label">Jenis perusahaan</label>
	<div class="col-sm-9">
		<div class="checkbox-custom checkbox-default" id="supplier-checkbox">
			<input type="checkbox" name="type[]" id="type-supplier" value="supplier">
			<label for="supplier">{{ ucfirst(__('supplier')) }}</label>
		</div>
		<div class="checkbox-custom checkbox-default" id="consumer-checkbox">
			<input type="checkbox" name="type[]" id="type-consumer" value="consumer">
			<label for="consumer">{{ ucfirst(__('pelanggan')) }}</label>
		</div>
		<span class="help-block text-muted">Wajib diisi.</span>
		<span class="help-block text-error" id="error-type"></span>
	</div>
</div>
