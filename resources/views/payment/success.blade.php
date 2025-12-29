@extends('layouts.HomeLayout')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="text-center bg-white p-8 shadow-lg rounded-lg flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="green" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 10.97a.75.75 0 0 0 1.06 0l4-4a.75.75 0 1 0-1.06-1.06L7.5 9.44 5.53 7.47a.75.75 0 1 0-1.06 1.06l2.5 2.5z"/>
        </svg>
        <h2 class="mt-4 text-2xl font-semibold">Pembayaran Berhasil!</h2>
        <p class="text-gray-600 mt-2">Terima kasih telah melakukan pembayaran. Pesanan Anda akan segera diproses.</p>
        <a href="/" class="mt-4 px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Kembali ke Beranda</a>
    </div>
</div>
@endsection

@push('bottom')
<script src="{{ url(asset('assets/js/nav.js')) }}"></script>
@endpush