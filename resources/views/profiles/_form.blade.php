<div class="form-group mt-lg" id="div_name">
	<label class="col-sm-3 control-label">Nama</label>
	<div class="col-sm-9">
		<input type="text" id="name" name="name" class="form-control" required/>
		<label class="error" id="label_name"></label>
	</div>
</div>
<div class="form-group mt-lg" id="div_user_id">
	<label class="col-md-3 control-label">Akun</label>
	<div class="col-md-6">
		<select class="form-control" id="user_id" name="user_id">
			<option value="">Akun ...</option>
			@foreach($users as $key => $value)
			<option value="{{ $key }}">{{ $value }}</option>
			@endforeach
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 control-label" for="inputSuccess">Role</label>
	@foreach($roles as $key => $value)
	<div class="col-md-6">
		<label class="checkbox-inline">
			<input type="checkbox" class="role-checkboxes" id="role_{{ $key }}" value="{{ $key }}" name="roles[]"> {{ $value }}
		</label>
	</div>
	@endforeach
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
