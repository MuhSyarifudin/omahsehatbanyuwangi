@extends('layouts.HomeLayout')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="text-center bg-white p-8 shadow-lg rounded-lg flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="red" viewBox="0 0 24 24"> 
            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.656 16.242a1.5 1.5 0 1 1-2.121 2.121L12 14.121l-3.535 3.535a1.5 1.5 0 1 1-2.121-2.121L9.879 12 6.344 8.465a1.5 1.5 0 1 1 2.121-2.121L12 9.879l3.535-3.535a1.5 1.5 0 1 1 2.121 2.121L14.121 12l3.535 3.535z"/>
        </svg>
        <h2 class="mt-4 text-2xl font-semibold text-red-600">Pembayaran Gagal!</h2>
        <p class="text-gray-600 mt-2">Terjadi kesalahan dalam proses pembayaran. Silakan coba lagi.</p>
        <a href="/" class="mt-4 px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Kembali ke Beranda</a>
    </div>
</div>
@endsection

@push('bottom')
<script src="{{ url(asset('assets/js/nav.js')) }}"></script>
@endpush