@extends('layouts.dashboard', ['page_title' => 'tambah produk'])
@section('content')
	<form method="post" action="{{ route('items.store') }}" id="form-add-item">
		@csrf
		@include('items._form')
		<div class="form-group mt-lg" id="div_description">
			<div class="col-sm-9 col-sm-offset-3 text-right">
				<a href="{{ route('items.index') }}" class="btn btn-default">{{ ucwords(__('batal')) }}</a>
				<button type="submit" class="btn btn-primary" id="btn-add-item">{{ ucwords(__('tambah')) }}</button>
			</div>
		</div>
	</form>
@endsection
@push('vendorstyles')
	<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}" />
@endpush
@push('appscripts')
	<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
	<script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$('select').select2();
		});
	</script>
@endpush
