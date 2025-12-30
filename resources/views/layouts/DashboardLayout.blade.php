<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="api-token" content="{{ session('token') }}">
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
         let token = document.querySelector('meta[name="api-token"]').getAttribute('content');

        function loadNotifikasi() {

                fetch('/api/get-count', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                    }
                })
                .then(res => {
                    if (res.status === 401) throw 'Unauthenticated';
                    return res.json();
                })
                .then(data => {
                    const badge1 = document.getElementById('notif-badge-luar-1');
                    const badge2 = document.getElementById('notif-badge-luar-2');

                    if (data.count_notifikasi > 0) {
                        badge1.textContent = data.count_notifikasi;
                        badge1.classList.remove('hidden');
                        badge2.textContent = data.count_notifikasi;
                        badge2.classList.remove('hidden');

                    } else {
                        badge1.classList.add('hidden');
                        badge2.classList.add('hidden');
                    }
                })
                .catch(err => console.error(err));
            }

        loadNotifikasi();
        setInterval(loadNotifikasi, 1000);

            function loadNotifikasiList() {

            fetch('/api/get-notifikasi', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                const list = document.getElementById('notif-list');
                const empty = document.getElementById('no-notif-message');

            list.innerHTML = '';

            if (!data.notifikasi || data.notifikasi.length === 0) {
                empty.classList.remove('hidden');
                return;
            }

            empty.classList.add('hidden');

                data.notifikasi.forEach(notif => {
                    list.innerHTML += `
                                        <a 
                                        x-data="{ linkHover: false }"
                                        class="flex items-center justify-between py-4 px-3 hover:bg-gray-100 bg-opacity-20"
                                        @mouseover="linkHover = true"
                                        @mouseleave="linkHover = false"
                                        
                                    >
                                        <div class="flex items-center">
                                            <svg class="w-8 h-8 bg-primary bg-opacity-20 text-primary px-1.5 py-0.5 rounded-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <div class="text-sm ml-3">
                                                <p 
                                                    class="text-gray-600 font-bold capitalize"
                                                    :class=" linkHover ? 'text-primary' : ''"
                                                >${notif.data.status}</p>
                                                <p class="text-xs">${notif.data.message}</p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold">
                                            ${notif.created_at}
                                        </span>
                                    </a>   
                                    <button data-id="${notif.id}" class="btn bg-amber-400 justify-end rounded-2xl text-xs m-1 p-1">Tandai dibaca</button>                                 
                    `;
                });
            });
        }

        loadNotifikasiList();
        setInterval(loadNotifikasiList, 5000);

        </script>
        @stack('bottom')
    </body>
</html>