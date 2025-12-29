<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{{ env('APP_NAME') }}</title>

        <!-- Styles -->
        @vite(['resources/css/app.css'])

        <style>[x-cloak] { display: none !important; }</style>

        <link rel="icon" type="image/x-icon" href="{{ url(asset('assets/img/logo.jpg')) }}">

        <!-- Scripts -->
        <script defer src="https://unpkg.com/alpinejs@3.4.2/dist/cdn.min.js"></script>
        <script defer src="https://unpkg.com/@alpinejs/collapse@3.4.2/dist/cdn.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
        @vite(['resources/css/app.css'])
        @stack('top')
        @livewireStyles
    </head>
    <body>
        @yield('content')

        @stack('bottom')
    </body>
</html>