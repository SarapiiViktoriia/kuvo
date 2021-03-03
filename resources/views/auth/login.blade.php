@extends('layouts.page')
@section('content')
    <section class="body-sign">
        <div class="center-sign">
            <a class="logo pull-left">
                <img src="{{ asset('assets/images/logo.png') }}" height="54" alt="Porto Admin" />
            </a>
            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-bold m-none">
                        <i class="fa fa-user mr-xs"></i> Masuk
                    </h2>
                </div>
                <div class="panel-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-lg {{ $errors->has('email') || $errors->has('username') ? 'has-error' : '' }}">
                            <label for="login">Email/Username</label>
                            <div class="input-group input-group-icon">
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </span>
                                <input name="login" type="text" class="form-control input-lg" value="{{ old('email') ?: old('username') }}" required autofocus>
                            </div>
                            @if ($errors->has('email') || $errors->has('username'))
                                <span class="error help-block">{{ $errors->first() }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-lg {{ $errors->has('password') ? 'has-error' : '' }}">
                            <div class="clearfix">
                                <label for="password" class="pull-left">Kata Sandi</label>
                                <a href="{{ route('password.request') }}" class="pull-right">Lupa kata sandi?</a>
                            </div>
                            <div class="input-group input-group-icon">
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </span>
                                <input class="form-control input-lg" type="password" name="password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="checkbox-custom checkbox-default">
                                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">Ingat saya</label>
                                </div>
                                <div class="pull-right"></div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <button class="btn btn-primary hidden-xs" type="submit">Masuk</button>
                                <button class="btn btn-primary btn-block btn-lg visible-xs mt-lg" type="submit">Masuk</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted mt-md mb-md">{{ config('app.name') }} built by <a href="https://limavolt.web.id">Limavolt</a> with <i class="fa fa-heart"></i> and <i class="fa fa-coffee"></i>.</p>
        </div>
    </section>
@endsection
