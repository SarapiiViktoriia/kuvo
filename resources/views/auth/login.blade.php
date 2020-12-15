@extends('layouts.template-sign')
@section('content')
<div class="panel panel-sign">
    <div class="panel-title-sign mt-xl text-right">
        <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-envelope mr-xs"></i> Masuk</h2>
    </div>
    <div class="panel-body">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group mb-lg {{ $errors->has('email') || $errors->has('username') ? 'has-error' : '' }}">
                <label>Email</label>
                <div class="input-group input-group-icon">
                    <input name="login" type="text" class="form-control input-lg" value="{{ old('email') ?: old('username') }}" required />
                    <span class="input-group-addon">
                        <span class="icon icon-lg">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </span>
                </div>
                @if ($errors->has('email') || $errors->has('username'))
                <label class="error">{{ $errors->first('email') ?: $errors->first('username') }}</label>
                @endif
            </div>
            <div class="form-group mb-lg {{ $errors->has('password') ? 'has-error' : '' }}">
                <div class="clearfix">
                    <label class="pull-left">Kata Sandi</label>
                    <a href="{{ route('password.request') }}" class="pull-right">Lupa Kata Sandi?</a>
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
            <div class="row">
                <div class="col-sm-8">
                    <div class="checkbox-custom checkbox-default">
                        <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} />
                        <label for="RememberMe">Ingat Saya</label>
                    </div>
                    <div class="pull-right">
                    </div>
                </div>
                <div class="col-sm-4 text-right">
                    <button type="submit" class="btn btn-primary hidden-xs">Masuk</button>
                    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Masuk</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
