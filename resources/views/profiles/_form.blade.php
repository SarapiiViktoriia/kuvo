<div class="form-group mt-lg" id="div_name">
	<label class="col-md-3 control-label">Nama</label>
	<div class="col-md-9">
		<input type="text" id="name" name="name" class="form-control" required>
		<span class="help-block text-muted">Wajib diisi.</span>
	</div>
</div>
<div class="form-group mt-lg" id="div_user_id">
	<label class="col-md-3 control-label">Akun</label>
	<div class="col-md-9">
		<select class="form-control" id="user_id" name="user_id">
			<option value="">Akun ...</option>
			@foreach($users as $key => $value)
				<option value="{{ $key }}">{{ $value }}</option>
			@endforeach
		</select>
		<span class="help-block">Pilih akun pengguna yang sesuai jika ada.</span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">Peran</label>
	<div class="col-md-9">
		<div class="row">
			@foreach($roles as $key => $value)
				<div class="col-md-6">
					<div class="checkbox-custom checkbox-default">
						<input type="checkbox" class="role-checkboxes" id="role_{{ $key }}" value="{{ $key }}" name="roles[]">
						<label>{{ $value }}</label>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">Perizinan</label>
	<div class="col-md-9"">
		<div class="row">
			@foreach($permissions as $key => $value)
				<div class="col-md-6">
					<div class="checkbox-custom checkbox-default">
						<input type="checkbox" class="permission-checkboxes" id="permission_{{ $key }}" value="{{ $key }}" name="permissions[]">
						<label>{{ $value }}</label>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
