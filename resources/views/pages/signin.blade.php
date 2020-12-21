@extends('layouts.page')
@section('content')
    <section class="body-sign">
        <div class="center-sign">
            <a href="#" class="logo pull-left">
                <img src="{{ asset('img/logo.png') }}" alt="" height="54">
            </a>
            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-bold m-none">
                        <i class="fa fa-user mr-xs"></i> Sign In
                    </h2>
                </div>
                <div class="panel-body">
                    <form action="#" method="post">
                        @component('components.form-input',
                            ['name' => 'username',
                            'label' => 'Username',
                            'icon'  => 'user',
                            'type'  => 'text'])
                        @endcomponent
                        @component('components.form-input',
                            ['name' => 'password',
                            'label' => 'Password',
                            'icon'  => 'lock',
                            'type'  => 'password'])
                        @endcomponent
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="checkbox-custom checkbox-default">
                                    <input type="checkbox" name="rememberme" id="rememberme">
                                    <label for="rememberm">Remember me</label>
                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                                <button type="submit" class="btn btn-primary btn-block visible-xs mt-lg">Sign In</button>
                            </div>
                        </div>
                        <p class="text-center">Don't have account yet? <a href="#">Sign up!</a></p>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted mt-md mb-md">{{ config('app.name') }} built by <a href="https://limavolt.web.id">Limavolt</a> with <i class="fa fa-heart"></i> and <i class="fa fa-coffee"></i>.</p>
        </div>
    </section>
@endsection
