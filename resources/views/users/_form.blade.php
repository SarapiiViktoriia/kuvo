<div class="form-group mt-lg" id="div_name">
	<label class="col-sm-3 control-label">Nama</label>
	<div class="col-sm-9">
		<input type="text" id="name" name="name" class="form-control" required autofocus>
		<span class="help-block text-muted">Wajib diisi</span>
	</div>
</div>
<div class="form-group mt-lg" id="div_email">
	<label class="col-sm-3 control-label">Email</label>
	<div class="col-sm-9">
		<input type="email" id="email" name="email" class="form-control" required>
		<span class="help-block text-muted">Wajib diisi</span>
	</div>
</div>
<div class="form-group mt-lg" id="div_username">
	<label class="col-sm-3 control-label">Username</label>
	<div class="col-sm-9">
		<input type="text" id="username" name="username" class="form-control" required>
		<span class="help-block text-muted">Wajib diisi</span>
	</div>
</div>
<div class="form-group mt-lg" id="div_user_id">
	<label class="col-md-3 control-label">Profil</label>
	<div class="col-sm-9">
		<select class="form-control" id="profile_id" name="profile_id">
			<option value="">Profil ...</option>
			@foreach($profiles as $key => $value)
				<option value="{{ $key }}">{{ $value }}</option>
			@endforeach
		</select>
		<span class="help-block text-muted">Pilih profil pengguna yang sesuai jika ada.
		<a href="{{ route('users.create') }}">Atau buat baru</a>.</span>
	</div>
</div>
