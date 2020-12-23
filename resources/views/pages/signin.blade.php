@extends('layouts.page')
@section('page')
    <section class="body-sign">
        <div class="center-sign">
            <a href="#" class="logo pull-left">
                <img src="{{ asset('img/logo.png') }}" alt="" height="54">
            </a>
            @yield('content')
            <p class="text-center text-muted mt-md mb-md">{{ config('app.name') }} built by <a href="https://limavolt.web.id">Limavolt</a> with <i class="fa fa-heart"></i> and <i class="fa fa-coffee"></i>.</p>
        </div>
    </section>
@endsection
