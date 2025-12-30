<html class="mx-auto">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/daisyui@1.14.0/dist/full.css" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
        <style>[x-cloak] { display: none !important; }</style>
        <!-- Google Fonts -->
        <link rel="icon" type="image/x-icon" href="{{ url(asset('assets/img/logo.jpg')) }}">
        
        <title>{{ env('APP_NAME') }}</title>
        @stack('top')
        @livewireStyles
        
    </head>
    
    
    <body class="font-open-sans bg-gray-100">
        @include('partials.HomeNavigation')
        @yield('content')
    
    
        @if ($marginBottom == true)
        @include('partials.BottomFooterWithMargin')
        @else
        @include('partials.BottomFooter')
        @endif
    
        @stack('bottom')
        @livewireScripts
    </body>
    
</html>
    