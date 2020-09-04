<DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (session()->has('auth_info'))
    <title>@lang('html.' . session('auth_info')->SCREEN_ID . '.title')</title>
    @else
    <title>@yield('title')</title>
    @endif
    {{-- 画面共通 --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/child.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    {{-- 画面依存CSS --}}
    @yield('pageCss')
</head>
<body>
    <div id="app">
        {{--  Progress --}}
        <appprogress ref="appProgress"> </appprogress>

        {{-- コンテンツ --}}
        <div class="container">
        @yield('content')
        </div>
    </div>
    {{-- Vue --}}
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/js/leadtime.js') }}"></script>
</body>
</html>