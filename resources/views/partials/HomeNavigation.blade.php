<nav class="navbar bg-base-100 shadow-lg">
    <div class="container mx-auto flex justify-end items-center h-full p-0">
        <ul class="flex space-x-4">
            <li><a href="{{ route('login') }}" class="btn btn-ghost p-0 text-sm px-1">Login</a></li>
            <li><a href="{{ route('register') }}" class="btn btn-ghost p-0 text-sm px-1">Daftar</a></li>
        </ul>
    </div>
</nav>

<header id="header" class="h-25 bg-base-200 transition-all duration-300 relative top-0 z-[1000]">
    <div class="container mx-auto flex justify-between items-center p-3">
        <div class="flex items-center">
            <a href="{{ url('/') }}">
                <img src="{{ url(asset('assets/img/logo-landscape.png')) }}" alt="Logo" class="mr-3" style="width:200px;height:70px" />
            </a>
        </div>
        <nav class="hidden md:flex space-x-4 ml-auto">
            <a href="{{ url('/') }}" class="link link-hover">Beranda</a>
            <a href="#" class="link link-hover">Tentang Kami</a>
            <a href="{{ url('layanan') }}" class="link link-hover">Layanan</a>
            <a href="https://wa.me/6282302030800" class="link link-hover">Kontak Kami</a>
        </nav>
        <div class="md:hidden">
            <button class="btn btn-ghost" id="menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </div>
    <!-- Tambahkan class bg-white di sini -->
    <div id="mobile-menu" class="md:hidden hidden bg-white transition-all duration-300 mt-0">
        <nav class="flex flex-col space-y-2 p-4">
            <a href="{{ url('/') }}" class="link link-hover">Beranda</a>
            <a href="#" class="link link-hover">Tentang Kami</a>
            <a href="{{ url('layanan') }}" class="link link-hover">Layanan</a>
            <a href="https://wa.me/6282302030800" class="link link-hover">Kontak Kami</a>
        </nav>
    </div>
    
</header>
