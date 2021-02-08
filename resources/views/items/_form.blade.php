@if (Request::route()->named('items.edit'))
	{{ method_field('PUT') }}
@endif
<div class="form-group mt-lg" id="div_code">
	<label class="col-sm-3 control-label">Kode Barang</label>
	<div class="col-sm-9">
		@if (Request::route()->named('items.edit'))
			<input type="text" id="code" name="code" class="form-control" value="{{ $item->code }}" required>
		@else
			<input type="text" id="code" name="code" class="form-control" required>
		@endif
		<label class="error" id="label_code"></label>
	</div>
</div>
<div class="form-group mt-lg" id="div_name">
	<label class="col-sm-3 control-label">Nama</label>
	<div class="col-sm-9">
		@if (Request::route()->named('items.edit'))
			<input type="text" id="name" name="name" class="form-control" value="{{ $item->name }}" required>
		@else
			<input type="text" id="name" name="name" class="form-control" required>
		@endif
		<label class="error" id="label_name"></label>
	</div>
</div>
<div class="form-group mt-lg" id="div_item_group_id">
	<label class="col-sm-3 control-label">Grup Barang</label>
	<div class="col-sm-9">
		<select class="form-control" id="item_group_id" name="item_group_id">
			<option>Grup Barang ...</option>
			@foreach ($item_groups as $key => $value)
				@if (Request::route()->named('items.edit'))
					@if ($key === $item->item_group_id)
						<option value="{{ $key }}" selected>{{ $value }}</option>
					@else
						<option value="{{ $key }}">{{ $value }}</option>
					@endif
				@else
					<option value="{{ $key }}">{{ $value }}</option>
				@endif
			@endforeach
		</select>
		<label class="error" id="label_item_group_id"></label>
	</div>
</div>
<div class="form-group mt-lg" id="div_item_brand_id">
	<label class="col-sm-3 control-label">Brand Barang</label>
	<div class="col-sm-9">
		<select class="form-control" id="item_brand_id" name="item_brand_id">
			<option value="">Brand Barang ...</option>
			@foreach ($item_brands as $key => $value)
				@if (Request::route()->named('items.edit'))
					@if ($key === $item->item_brand_id)
						<option value="{{ $key }}"selected>{{ $value }}</option>
					@else
						<option value="{{ $key }}">{{ $value }}</option>
					@endif
				@else
					<option value="{{ $key }}">{{ $value }}</option>
				@endif
			@endforeach
		</select>
		<label class="error" id="label_item_brand_id"></label>
	</div>
</div>
<div class="form-group mt-lg" id="div_supplier_id">
	<label class="col-sm-3 control-label">Supplier</label>
	<div class="col-sm-9">
		<select class="form-control" id="supplier_id" name="supplier_id" multiple="multiple" data-plugin-multiselect>
			@foreach ($suppliers as $key => $value)
				@if (Request::route()->named('items.edit'))
					@foreach ($item->suppliers as $supplier)
						@if ($key === $supplier->pivot->supplier_id)
							<option value="{{ $key }}" selected>{{ $value }}</option>
						@else
							<option value="{{ $key }}">{{ $value }}</option>
						@endif
					@endforeach
				@else
					<option value="{{ $key }}">{{ $value }}</option>
				@endif
			@endforeach
		</select>
		<label class="error" id="label_supplier_id"></label>
	</div>
</div>
<div class="form-group mt-lg" id="div_image_url">
	<label class="col-sm-3 control-label">Url gambar barang</label>
	<div class="col-sm-9">
		@if (Request::route()->named('items.edit'))
			<input type="text" id="image_url" name="image_url" class="form-control" value="{{ $item->image_url }}">
		@else
			<input type="text" id="image_url" name="image_url" class="form-control">
		@endif
		<label class="error" id="label_image_url"></label>
	</div>
</div>
<div class="form-group mt-lg" id="div_description">
	<label class="col-sm-3 control-label">Deskripsi</label>
	<div class="col-sm-9">
		@if (Request::route()->named('items.edit'))
			<textarea name="description" id="description" class="form-control">{{ $item->description }}</textarea>
		@else
			<textarea name="description" id="description" class="form-control"></textarea>
		@endif
		<label class="error" id="label_description"></label>
	</div>
</div>
