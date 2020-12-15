@extends('layouts.template-sign')
@section('content')
<div class="panel panel-sign">
    <div class="panel-title-sign mt-xl text-right">
        <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-envelope mr-xs"></i> {{ __('Reset Password') }}</h2>
    </div>
    <div class="panel-body">
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <div class="form-group mb-lg">
                <label>Email</label>
                <div class="input-group input-group-icon">
                    <input name="email" type="email" class="form-control input-lg {{ $errors->has('email') ? 'has-error' : '' }}" value="{{ $email ?? old('email') }}" required autofocus />
                    <span class="input-group-addon">
                        <span class="icon icon-lg">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </span>
                </div>
                @if ($errors->has('email'))
                <label class="error">{{ $errors->first('email') }}</label>
                @endif
            </div>
            <div class="form-group mb-lg {{ $errors->has('password') ? 'has-error' : '' }}">
                <div class="clearfix">
                    <label class="pull-left">Kata Sandi</label>
                </div>
                <div class="input-group input-group-icon">
                    <input name="password" type="password" class="form-control input-lg" required />
                    <span class="input-group-addon">
                        <span class="icon icon-lg">
                            <i class="fa fa-lock"></i>
                        </span>
                    </span>
                </div>
                @if ($errors->has('password'))
                <label class="error">{{ $errors->first('password') }}</label>
                @endif
            </div>
            <div class="form-group mb-lg">
                <div class="clearfix">
                    <label class="pull-left">Konfirmasi Kata Sandi</label>
                </div>
                <div class="input-group input-group-icon">
                    <input name="password_confirmation" type="password" class="form-control input-lg" required />
                    <span class="input-group-addon">
                        <span class="icon icon-lg">
                            <i class="fa fa-lock"></i>
                        </span>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary hidden-xs">Reset Password</button>
                    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Reset Password</button>
                </div>
                <div class="col-sm-12 text-left">
                    <a href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
