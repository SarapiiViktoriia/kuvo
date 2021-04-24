<div class="form-group mt-lg" id="div-item_group_id">
	<label class="col-sm-3 control-label">Kategori produk</label>
	<div class="col-sm-9">
		<select class="form-control" id="item_group_id" name="item_group_id">
			<option value="">Pilih kategori ...</option>
			@foreach ($item_groups as $item_group)
				<option value="{{ $item_group->id }}">{{ $item_group->name }}</option>
			@endforeach
		</select>
		<span class="help-block text-muted text-left">Wajib diisi</span>
		<span class="help-block text-error" id="error-item_group_id"></span>
	</div>
</div>
<div class="form-group mt-lg" id="div-item_brand_id">
	<label class="col-sm-3 control-label">Merek produk</label>
	<div class="col-sm-9">
		<select class="form-control" id="item_brand_id" name="item_brand_id">
			<option value="">Pilih merek ...</option>
			@foreach ($item_brands as $brand)
				<option value="{{ $brand->id }}">{{ $brand->name }}</option>
			@endforeach
		</select>
		<span class="help-block text-muted">Wajib diisi</span>
		<span class="help-block text-error" id="error-item_brand_id"></span>
	</div>
</div>
<div class="form-group mt-lg" id="div-supplier_id">
	<label class="col-sm-3 control-label">Supplier</label>
	<div class="col-sm-9">
		<select class="form-control" id="supplier_id" name="supplier_id">
			<option value="">Pilih supplier ...</option>
			@foreach ($suppliers as $supplier)
				<option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
			@endforeach
		</select>
		<span class="help-block text-muted">Wajib diisi</span>
		<span class="help-block text-error" id="error-supplier_id"></span>
	</div>
</div>
<hr>
<div class="form-group mt-lg" id="div-name">
	<label class="col-sm-3 control-label">Nama produk</label>
	<div class="col-sm-9">
		<input type="text" id="name" name="name" class="form-control" required>
		<span class="help-block text-muted">Wajib diisi</span>
		<span class="help-block text-error" id="error-name"></span>
	</div>
</div>
<div class="form-group mt-lg" id="div-description">
	<label class="col-sm-3 control-label">Deskripsi</label>
	<div class="col-sm-9">
		<textarea name="description" id="description" class="form-control"></textarea>
		<span class="help-block text-error" id="error-description"></span>
	</div>
</div>
