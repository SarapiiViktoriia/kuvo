<div class="form-group mt-lg" id="div_name">
	<label class="col-sm-3 control-label">Nama</label>
	<div class="col-sm-9">
		<input type="text" name="name" id="name" class="form-control" required/>
		<label class="error" id="label_name"></label>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 control-label" for="inputSuccess">Permission</label>
	@foreach($permissions as $key => $value)
	<div class="col-md-6">
		<label class="checkbox-inline">
			<input type="checkbox" class="permission-checkboxes" id="permission_{{ $key }}" value="{{ $key }}" name="permissions[]"> {{ $value }}
		</label>
	</div>
	@endforeach
</div>
