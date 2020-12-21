<!doctype html>
    <html class="fixed" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name') }}</title>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
        <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('css/default.css') }}">
        <link rel="stylesheet" href="{{ asset('css/theme-custom.css') }}">
        <script src="{{ asset('js/modernizr.js')  }}"></script>
    </head>
    <body>
        <section class="body">
            @component('components.topbar')
            @endcomponent
            <div class="inner-wrapper">
                @component('components.sidebar')
                @endcomponent
                <section class="content-body" role="main">
                    @component('components.page-header')
                    @endcomponent
                    @yield('content')
                </section>
            </div>
            <aside class="sidebar-right" id="sidebar-right"></aside>
        </section>
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/jquery.browser.mobile.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/nanoscroller.js') }}"></script>
        <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('js/magnific-popup.js') }}"></script>
        <script src="{{ asset('js/jquery.placeholder.js') }}"></script>
        <script src="{{ asset('js/theme.js') }}"></script>
        <script src="{{ asset('js/theme.custom.js') }}"></script>
        <script src="{{ asset('js/theme.init.js') }}"></script>
    </body>
</html>
