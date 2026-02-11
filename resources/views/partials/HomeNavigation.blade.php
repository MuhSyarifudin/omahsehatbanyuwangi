<nav class="bg-slate-900 text-white py-2 border-b border-white/10">
    <div class="container mx-auto flex justify-end items-center px-6">
        <ul class="flex items-center space-x-6">
            <li>
                <a href="{{ route('login') }}" class="text-xs uppercase tracking-widest hover:text-yellow-400 transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-user text-[10px]"></i> Login
                </a>
            </li>
            <li class="h-3 w-[1px] bg-white/20"></li>
            <li>
                <a href="{{ route('register') }}" class="text-xs uppercase tracking-widest hover:text-yellow-400 transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-[10px]"></i> Daftar
                </a>
            </li>
        </ul>
    </div>
</nav>

<header id="header" class="sticky top-0 z-[1000] bg-white/95 backdrop-blur-md shadow-sm transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center">
            <a href="{{ url('/') }}" class="transition-transform duration-300 hover:scale-105">
                <img src="{{ url(asset('assets/img/logo-landscape.png')) }}" alt="Logo" class="w-[180px] h-auto object-contain" />
            </a>
        </div>

        <nav class="hidden md:flex items-center space-x-8">
            <a href="{{ url('/') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors relative group">
                Beranda
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="#" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors relative group">
                Tentang Kami
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="{{ url('layanan') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors relative group">
                Layanan
                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="https://wa.me/6282302030800" class="bg-blue-600 text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-blue-700 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                Kontak Kami
            </a>
        </nav>

        <div class="md:hidden">
            <button class="p-2 text-slate-700 focus:outline-none" id="menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full left-0 shadow-xl animate-fade-in-down">
        <nav class="flex flex-col p-6 space-y-4">
            <a href="{{ url('/') }}" class="text-base font-medium text-slate-700 hover:text-blue-600 border-b border-gray-50 pb-2">Beranda</a>
            <a href="#" class="text-base font-medium text-slate-700 hover:text-blue-600 border-b border-gray-50 pb-2">Tentang Kami</a>
            <a href="{{ url('layanan') }}" class="text-base font-medium text-slate-700 hover:text-blue-600 border-b border-gray-50 pb-2">Layanan</a>
            <a href="https://wa.me/6282302030800" class="text-base font-bold text-blue-600">Kontak Kami (WhatsApp)</a>
        </nav>
    </div>
</header>