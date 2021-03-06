<div class="form-group mt-lg" id="div_name">
	<label class="col-sm-3 control-label">Nama</label>
	<div class="col-sm-9">
		<input type="text" id="name" name="name" class="form-control" required>
		<span class="help-block text-muted">Wajib diisi</span>
		<span class="help-block text-error" id="label_name"></span>
	</div>
</div>
<div class="form-group mt-lg" id="div_description">
	<label class="col-sm-3 control-label">Deskripsi</label>
	<div class="col-sm-9">
		<textarea name="description" id="description" class="form-control"></textarea>
		<span class="help-block text-error" id="label_description"></span>
	</div>
</div>
<hr>
<div class="form-group mt-lg" id="div_parent_id">
	<label class="col-sm-3 control-label">Induk kategori</label>
	<div class="col-sm-9">
		<select class="form-control" id="parent_id" name="parent_id">
			<option value="">Induk kategori ...</option>
		</select>
		<span class="help-block text-muted">Pilih kategori induk jika kamu membuat subkategori.</span>
		<span class="help-block text-error" id="label_parent_id"></span>
	</div>
</div>
