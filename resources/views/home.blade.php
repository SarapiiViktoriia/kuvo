@extends('layouts.dashboard')
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <section class="panel">
                <div class="panel-body bg-primary">
                    <div class="widget-profile-info">
                        <div class="profile-picture">
                            <img src="{{ asset('assets/images/!logged-user.jpg') }}" alt="">
                        </div>
                        <div class="profile-info">
                            <h4 class="name text-semibold">{{ Auth::user()->profile->name }}</h4>
                            <h5 class="role">{{ Auth::user()->profile->getRoleNames()->first() }}</h5>
                            <div class="profile-footer">
                                <span>{{ ucfirst(__('ubah profile')) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @if (auth()->user()->profile->hasPermissionTo('Add User'))
        <div class="row">
            <div class="col-md-4">
                <section class="panel">
                    <div class="panel-body">
                        <p>
                            Terdapat <strong>{{ \App\User::count() }} pengguna</strong> yang didaftarkan pada sistem ini.
                            Untuk mengelola pengguna, silakan gunakan modul
                            <a href="{{ route('users.index') }}">manajemen pengguna</a>.
                        </p>
                    </div>
                </section>
            </div>
        </div>
    @endif
@endsection
