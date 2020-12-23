<!doctype html>
<html class="fixed" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" type="text/css">
        @stack('webfonts')
        <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" type="text/css">
        @stack('vendorstyles')
        <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/stylesheets/skins/default.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-custom.css') }}" type="text/css">
        @stack('themestyles')
        @stack('appstyles')
        <script src="{{ asset('js/modernizr.js')  }}"></script>
        @stack('headscripts')
    </head>
    <body>
        <section class="body">
            @include('components.topbar')
            <div class="inner-wrapper">
                @include('components.sidebar')
                <section class="content-body" role="main">
                    @include('components.page-header', ['page_title' => $page_title])
                    @yield('content')
                </section>
            </div>
            @include('components.rightbar')
        </section>
        <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
        <script src="{{ asset('assets/vendor/magnific-popup/magnific-popup.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
        @stack('vendorscripts')
        <script src="{{ asset('assets/javascripts/theme.js') }}"></script>
        <script src="{{ asset('assets/javascripts/theme.custom.js') }}"></script>
        <script src="{{ asset('assets/javascripts/theme.init.js') }}"></script>
        @stack('themescripts')
        @stack('appscripts')
    </body>
</html>
