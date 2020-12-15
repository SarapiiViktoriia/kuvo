<!doctype html>
<html class="fixed">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="author" content="okler.net">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/skins/default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-custom.css') }}">
    <script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
</head>
<body>
    <section class="body-sign">
        <div class="center-sign">
            <a class="logo pull-left">
                <img src="{{ asset('assets/images/logo.png') }}" height="54" alt="Porto Admin" />
            </a>
            @yield('content')
            <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
        </div>
    </section>
    <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
    <script src="{{ asset('assets/vendor/magnific-popup/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
    <script src="{{ asset('assets/javascripts/theme.js') }}"></script>
    <script src="{{ asset('assets/javascripts/theme.custom.js') }}"></script>
    <script src="{{ asset('assets/javascripts/theme.init.js') }}"></script>
</body>
</html>
