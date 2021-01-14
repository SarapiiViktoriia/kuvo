<div class="form-group mt-lg" id="div_name">
	<label class="col-sm-3 control-label">Nama</label>
	<div class="col-sm-9">
		<input type="text" id="name" name="name" class="form-control" required/>
		<label class="error" id="label_name"></label>
	</div>
</div>
<div class="form-group mt-lg" id="div_email">
	<label class="col-sm-3 control-label">Email</label>
	<div class="col-sm-9">
		<input type="email" id="email" name="email" class="form-control" required/>
		<label class="error" id="label_email"></label>
	</div>
</div>
<div class="form-group mt-lg" id="div_username">
	<label class="col-sm-3 control-label">Username</label>
	<div class="col-sm-9">
		<input type="text" id="username" name="username" class="form-control" required/>
		<label class="error" id="label_username"></label>
	</div>
</div>
<div class="form-group mt-lg" id="div_user_id">
	<label class="col-md-3 control-label">Profil</label>
	<div class="col-md-6">
		<select class="form-control" id="profile_id" name="profile_id">
			<option value="">Profil ...</option>
			@foreach($profiles as $key => $value)
			<option value="{{ $key }}">{{ $value }}</option>
			@endforeach
		</select>
		<label class="error" id="label_profile_id"></label>
	</div>
</div>
