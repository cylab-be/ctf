<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
        @yield('title') | Capture the Flag
        @else
        Capture the Flag
        @endif
    </title>

    <!-- Flashed toastr message (see app/helpers.php) -->
    @if (session('flash'))
        <script>window.__flash = @json(session('flash'));</script>
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body @hasSection('body-class') class='@yield('body-class')' @endif>
    @include("layouts.partials.navbar")

    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
