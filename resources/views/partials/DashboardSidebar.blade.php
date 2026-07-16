<aside 
    :class="menuOpen ? 'translate-x-0 ease-out custom-scrollbar' : '-translate-x-full ease-in'" 
    class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 overflow-y-auto custom-scrollbar lg:translate-x-0 lg:inset-0 bg-[#182430]"
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

        <!-- Terapis -->
        <a href="{{ route('data.terapis') }}"
        class="flex items-center px-6 py-3 transition
        {{ request()->routeIs('data.terapis*')
            ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
            : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4.5 20.25a7.5 7.5 0 0115 0"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17 11l1.5 1.5L21 10"/>
        </svg>        
        <span class="ml-3">Terapis</span>
        </a>

        <!-- Pendaftaran Terapis -->
        <a href="{{ route('data.pendaftaran.terapis') }}"
        class="flex items-center px-6 py-3 transition
        {{ request()->routeIs('data.pendaftaran.terapis*')
            ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
            : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4.5 20.25a7.5 7.5 0 0115 0"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M19 8v6M16 11h6"/>
        </svg>
        <span class="ml-3">Pendaftaran</span>
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

        <!-- Notifikasi -->
        <a href="{{ route('data.whatsapp.log') }}"
           class="flex items-center px-6 py-3 transition
           {{ request()->routeIs('data.whatsapp.*')
                ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
                : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
            <!-- Bell Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 21a3 3 0 006 0"/>
            </svg>
            <span class="ml-3">WhatsApp Logs</span>
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
                      d="M8 7V6a2 2 0 012-2h4a2 2 0 012 2v1"/>
                <rect x="4" y="7" width="16" height="13" rx="2"/>
            </svg>
            <span class="ml-3">Jenis Terapi</span>
        </a>

        <!-- Keahlian -->
        <a href="{{ route('data.keahlian') }}"
        class="flex items-center px-6 py-3 transition
        {{ request()->routeIs('data.keahlian*')
            ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
            : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.5 12.5l-2.5 8 6-3 6 3-2.5-8"/>
        </svg>        
        <span class="ml-3">Keahlian</span>
        </a>

        <!-- Promo -->
        <a href="{{ route('data.promo') }}"
        class="flex items-center px-6 py-3 transition
        {{ request()->routeIs('data.promo*')
            ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
            : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
        <!-- Tag / Discount Icon -->
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17 7l-10 10"/>
            <circle cx="7" cy="7" r="2"/>
            <circle cx="17" cy="17" r="2"/>
        </svg>
        
        <span class="ml-3">Promo</span>
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
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-4 h-4">
            <path d="M20.52 3.48A11.91 11.91 0 0012.01 0C5.38 0 .02 5.36.02 11.99c0 2.11.55 4.17 1.6 5.99L0 24l6.18-1.61a11.96 11.96 0 005.83 1.49h.01c6.63 0 11.99-5.36 11.99-11.99 0-3.2-1.25-6.2-3.49-8.41zM12.02 21.7h-.01a9.76 9.76 0 01-4.98-1.37l-.36-.21-3.67.96.98-3.58-.23-.37a9.74 9.74 0 01-1.5-5.14c0-5.39 4.38-9.77 9.77-9.77 2.61 0 5.06 1.02 6.9 2.86a9.7 9.7 0 012.87 6.91c0 5.39-4.38 9.77-9.77 9.77zm5.36-7.33c-.29-.14-1.72-.85-1.99-.94-.27-.1-.47-.14-.67.14-.2.29-.76.94-.94 1.13-.17.2-.35.22-.64.07-.29-.14-1.22-.45-2.32-1.42-.86-.77-1.44-1.72-1.61-2.01-.17-.29-.02-.45.13-.59.14-.14.29-.35.43-.52.14-.17.19-.29.29-.49.1-.2.05-.37-.02-.52-.07-.14-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.29-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.14.2 2.1 3.2 5.08 4.49.71.31 1.27.49 1.7.63.71.23 1.35.2 1.86.12.57-.09 1.72-.7 1.96-1.38.24-.69.24-1.27.17-1.38-.07-.12-.27-.2-.56-.34z"/>
            </svg>

            <span class="ml-3">WA Devices</span>
        </a>

        <!-- Inbox -->
        <a href="{{ route('inbox.index') }}"
        class="flex items-center px-6 py-3 transition
        {{ request()->routeIs('inbox.*')
            ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
            : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 7.5l9 6 9-6"/>
            <rect x="3" y="6" width="18" height="12" rx="2"/>
        </svg>
        <span class="ml-3">Inbox</span>
        </a>

        <!-- Settings -->
        <p class="text-xs text-gray-600 mt-8 mb-2 px-6 uppercase">Settings</p>

        <!-- Profil -->
        <a href="{{ route('profile.index') }}"
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

        <!-- Settings -->
        <a href="{{ route('settings.edit') }}"
        class="flex items-center px-6 py-3 transition
        {{ request()->routeIs('settings.*')
            ? 'bg-black bg-opacity-40 text-white border-l-4 border-blue-500'
            : 'hover:bg-black hover:bg-opacity-30 hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="3"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M19.4 15a1.7 1.7 0 00.3 1.8l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.7 1.7 0 00-1.8-.3 1.7 1.7 0 00-1 1.5V21a2 2 0 11-4 0v-.1a1.7 1.7 0 00-1-1.5 1.7 1.7 0 00-1.8.3l-.1.1a2 2 0 11-2.8-2.8l.1-.1a1.7 1.7 0 00.3-1.8 1.7 1.7 0 00-1.5-1H3a2 2 0 110-4h.1a1.7 1.7 0 001.5-1 1.7 1.7 0 00-.3-1.8l-.1-.1a2 2 0 112.8-2.8l.1.1a1.7 1.7 0 001.8.3H9a1.7 1.7 0 001-1.5V3a2 2 0 114 0v.1a1.7 1.7 0 001 1.5h.1a1.7 1.7 0 001.8-.3l.1-.1a2 2 0 112.8 2.8l-.1.1a1.7 1.7 0 00-.3 1.8V9c0 .7.5 1.3 1.2 1.5H21a2 2 0 110 4h-.1a1.7 1.7 0 00-1.5 1z"/>
        </svg>
        <span class="ml-3">Settings</span>
        </a>

    </nav>
</aside>
