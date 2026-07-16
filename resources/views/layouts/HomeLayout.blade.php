<html class="mx-auto">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
        <style>
        [x-cloak] { display: none !important; }
        </style>
        <link rel="icon" type="image/x-icon" href="{{ url(asset('assets/img/logo.jpg')) }}">
        
        <title>{{ env('APP_NAME') }}</title>
        @stack('top')

    </head>
    
    <body class="font-open-sans bg-slate-200 overflow-x-hidden">
        @include('partials.HomeNavigation')
        @yield('content')
    
    
        @if ($marginBottom == true)
        @include('partials.BottomFooterWithMargin')
        @else
        @include('partials.BottomFooter')
        @endif
    
        @stack('bottom')
    </body>
    
</html>
    