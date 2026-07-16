<!DOCTYPE html>
<html class="bg-slate-200">
    <head>
        <meta charset="utf-8">
        <title>{{ env('APP_NAME') }}</title>

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>[x-cloak] { display: none !important; }</style>

        <link rel="icon" type="image/x-icon" href="{{ url(asset('assets/img/logo.jpg')) }}">

        <!-- Scripts -->
        <script defer src="https://unpkg.com/alpinejs@3.4.2/dist/cdn.min.js"></script>
        <script defer src="https://unpkg.com/@alpinejs/collapse@3.4.2/dist/cdn.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
        @stack('top')
    </head>
    <body class="font-helvetica-neue">
        @yield('content')
        @stack('bottom')
    </body>
</html>