<aside 
    :class="menuOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" 
    class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 overflow-y-auto lg:translate-x-0 lg:inset-0 bg-[#182430]"
>
    <!-- Logo -->
    <div class="flex items-center justify-center bg-black bg-opacity-30 h-16">
        <h1 class="text-gray-100 text-lg font-bold uppercase tracking-widest">
            {{ Auth::user()->role == 'admin' ? 'ADMIN' : 'TERAPIS' }}
        </h1>
    </div>

    <!-- Navigation -->
    <nav class="py-6 text-gray-400">

        <!-- Dashboard -->
        <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('therapist.dashboard') }}"
           class="flex items-center px-6 py-3 transition
           {{ request()->routeIs('admin.dashboard','therapist.dashboard')
                ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
                : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
            <!-- Home Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 12l8.954-8.955a1.125 1.125 0 011.591 0L21.75 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21h4.125v-4.875a1.125 1.125 0 011.125-1.125h2.25A1.125 1.125 0 0114.25 16.125V21h4.125A1.125 1.125 0 0019.5 19.875V9.75"/>
            </svg>
            <span class="ml-3">Dashboard</span>
        </a>

        <!-- Data -->
        <p class="text-xs text-gray-600 mt-8 mb-2 px-6 uppercase">Data</p>

        <!-- Reservasi -->
        <a href="{{ route('data.reservasi') }}"
           class="flex items-center px-6 py-3 transition
           {{ request()->routeIs('data.reservasi*')
                ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
                : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
            <!-- Database Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <ellipse cx="12" cy="5" rx="8" ry="3"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 5v6c0 1.7 3.6 3 8 3s8-1.3 8-3V5M4 11v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"/>
            </svg>
            <span class="ml-3">Reservasi</span>
        </a>

        <!-- Users -->
        <a href="{{ route('data.users') }}"
           class="flex items-center px-6 py-3 transition
           {{ request()->routeIs('data.users')
                ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
                : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
            <!-- Users Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 19c0-2.2-2.7-4-6-4s-6 1.8-6 4"/>
                <circle cx="9" cy="8" r="4"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 11a3 3 0 100-6"/>
            </svg>
            <span class="ml-3">Users</span>
        </a>

        <!-- Notifikasi -->
        <a href="{{ route('data.notifikasi') }}"
           class="flex items-center px-6 py-3 transition
           {{ request()->routeIs('data.notifikasi*')
                ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
                : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
            <!-- Bell Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 21a3 3 0 006 0"/>
            </svg>
            <span class="ml-3">Notifikasi</span>
        </a>

        <!-- Services -->
        <p class="text-xs text-gray-600 mt-8 mb-2 px-6 uppercase">Services</p>

        <!-- Layanan Terapi -->
        <a href="{{ route('data.layanan') }}"
           class="flex items-center px-6 py-3 transition
           {{ request()->routeIs('data.layanan*')
                ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
                : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
            <!-- Briefcase Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V6a2 2 0 012-2h4a2 2 0 012 2v1"/>
                <rect x="4" y="7" width="16" height="13" rx="2"/>
            </svg>
            <span class="ml-3">Layanan Terapi</span>
        </a>

        <!-- Jenis Terapi -->
        <a href="{{ route('data.jenis.terapi') }}"
           class="flex items-center px-6 py-3 transition
           {{ request()->routeIs('data.jenis.terapi*')
                ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
                : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
            <!-- Heart Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 8.5c0-2.5-2-4.5-4.5-4.5-2 0-3.7 1.2-4.5 3-0.8-1.8-2.5-3-4.5-3C5 4 3 6 3 8.5 3 15 12 20 12 20s9-5 9-11.5z"/>
            </svg>
            <span class="ml-3">Jenis Terapi</span>
        </a>

        <!-- Connections -->
        <p class="text-xs text-gray-600 mt-8 mb-2 px-6 uppercase">Connections</p>

        <!-- WA Devices -->
        <a href="{{ route('devices.index') }}"
           class="flex items-center px-6 py-3 transition
           {{ request()->routeIs('devices.*')
                ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
                : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
            <!-- WA Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6.75A2.25 2.25 0 016.25 4.5h11.5A2.25 2.25 0 0120 6.75v6.5A2.25 2.25 0 0117.75 15.5H6.25A2.25 2.25 0 014 13.25v-6.5z"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 18.5h6"/>
            </svg>
            <span class="ml-3">WA Devices</span>
        </a>

        <!-- Settings -->
        <p class="text-xs text-gray-600 mt-8 mb-2 px-6 uppercase">Settings</p>

        <!-- Profil -->
        <a href="{{ route('profile.edit') }}"
           class="flex items-center px-6 py-3 transition
           {{ request()->routeIs('profile.*')
                ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
                : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
            <!-- Profile Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4.5 20.25a7.5 7.5 0 0115 0"/>
            </svg>
            <span class="ml-3">Profil</span>
        </a>

    </nav>
</aside>
