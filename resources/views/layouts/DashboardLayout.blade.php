<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <body>
                {{-- <div 
        x-data="{ menuOpen: false }" 
        class="flex min-h-screen custom-scrollbar bg-gray-200"
        >
            <!-- start::Black overlay -->
            <div :class="menuOpen ? 'block' : 'hidden'" @click="menuOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
            <!-- end::Black overlay -->

                <div class="lg:pl-64 w-full flex flex-col">
                    <!-- start::Topbar -->
                        <div class="h-full flex flex-col bg-gray-200">
                            <!-- start:Page content -->
                            @include('partials.DashboardNavigation')
                            @include('partials.DashboardSidebar')
                            <div class="h-full bg-gray-200 p-8">
                        
                            @yield('content')
                            @livewireScripts
                            @stack('bottom')

                            </div>
                        </div>
                    </div>
                </div> --}}
                <div 
            x-data="{ menuOpen: false }" 
            class="flex min-h-screen custom-scrollbar"
        >
            <!-- start::Black overlay -->
            <div :class="menuOpen ? 'block' : 'hidden'" @click="menuOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
            <!-- end::Black overlay -->

            @include('partials.DashboardSidebar')

            <div class="lg:pl-64 w-full flex flex-col">
                <!-- start::Topbar -->
                <div class="flex flex-col">
                    @include('partials.DashboardNavigation')
                </div>
                <!-- end::Topbar -->

                <!-- start:Page content -->
                <div class="h-full bg-gray-200 p-8">

                    @yield('content')

                </div>
                <!-- end:Page content -->
            </div>
        </div>
        <script>
         </script>
        @stack('bottom')
    </body>
</html>