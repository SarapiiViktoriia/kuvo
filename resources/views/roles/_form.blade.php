<div class="form-group mt-lg" id="div_name">
	<label class="col-sm-3 control-label">Nama</label>
	<div class="col-sm-9">
		<input type="text" name="name" id="name" class="form-control" required/>
		<span class="help-block text-muted">Wajib diisi.</span>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label" for="inputSuccess">Perizinan</label>
	<div class="col-sm-9">
		<div class="row">
			@foreach ($permissions as $key => $value)
				<div class="col-md-6">
					<div class="checkbox-custom checkbox-default">
						<input type="checkbox" class="permission-checkboxes" id="permission_{{ $key }}" value="{{ $key }}" name="permissions[]">
						<label> {{ $value }}</label>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
