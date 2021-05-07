<div class="form-group mt-lg" id="div_code">
	<label class="col-sm-3 control-label">Kode perusahaan</label>
	<div class="col-sm-9">
		<input type="text" id="code" name="code" class="form-control" required>
		<span class="help-block text-muted">Wajib diisi</span>
		<span class="help-block text-error" id="label_code"></span>
	</div>
</div>
<div class="form-group mt-lg" id="div_name">
	<label class="col-sm-3 control-label">Nama perusahaan</label>
	<div class="col-sm-9">
		<input type="text" id="name" name="name" class="form-control" required>
		<span class="help-block text-muted">Wajib diisi</span>
		<span class="help-block text-error" id="label_name"></span>
	</div>
</div>
<div class="form-group mt-lg" id="div_type">
	<label class="col-sm-3 control-label">Jenis perusahaan</label>
	<div class="col-sm-9">
		<div class="checkbox-custom checkbox-default" id="supplier_checkbox">
			<input type="checkbox" name="type[]" id="type_supplier" value="supplier">
			<label for="supplier">{{ ucfirst(__('pemasok')) }}</label>
		</div>
		<div class="checkbox-custom checkbox-default" id="consumer_checkbox">
			<input type="checkbox" name="type[]" id="type_consumer" value="consumer">
			<label for="consumer">{{ ucfirst(__('pelanggan')) }}</label>
		</div>
		<span class="help-block text-muted">Wajib diisi.</span>
		<span class="help-block text-error" id="label_type"></span>
	</div>
</div>
