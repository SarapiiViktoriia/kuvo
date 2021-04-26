<!doctype html>
<html class="fixed sidebar-left-collapsed" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <link href="//fonts.gstatic.com" rel="dns-prefetch">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
        @stack('webfonts')
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/vendor/nanoscroller/nanoscroller.css') }}" rel="stylesheet" type="text/css">
        @stack('vendorstyles')
        <link href="{{ asset('assets/stylesheets/theme.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/stylesheets/skins/default.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/stylesheets/theme-custom.css') }}" rel="stylesheet" type="text/css">
        @stack('themestyles')
        @stack('appstyles')
        <script src="{{ asset('js/modernizr.js')  }}" style="text/javascript"></script>
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
        </section>
        <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendor/magnific-popup/magnific-popup.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var APP_URL = {!! json_encode(url('/')) !!};
        </script>
        @stack('vendorscripts')
        <script src="{{ asset('assets/javascripts/theme.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/javascripts/theme.custom.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/javascripts/theme.init.js') }}" type="text/javascript"></script>
        @stack('themescripts')
        @stack('appscripts')
    </body>
</html>
