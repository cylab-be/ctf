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

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body @hasSection('body-class') class='@yield('body-class')' @endif>
    @include("layouts.partials.navbar")

    <main class="py-4">
        @yield('content')
    </main>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function(){
            {!! toastr()->options().toastr()->notificationsAsString() !!}
        });
    </script>
</body>
</html>
