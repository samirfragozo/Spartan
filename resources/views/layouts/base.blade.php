<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') . ' - ' }}@yield('title')</title>
    <script src="{{ asset('js/vendors.bundle.js') }}" defer></script>
    <script src="{{ asset('js/scripts.bundle.js') }}" defer></script>
    <script src="{{ asset('js/datatables.bundle.js') }}" defer></script>
    @stack('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link href="{{ asset('css/vendors.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<div id="app" class="m-grid m-grid--hor m-grid--root m-page">
    @yield('body')
</div>
</body>
</html>
