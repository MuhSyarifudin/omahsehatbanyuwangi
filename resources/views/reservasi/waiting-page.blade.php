@extends('layouts.HomeLayout')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="text-center">
        <div class="w-12 h-12 flex items-center justify-center bg-green-500 text-white rounded-full mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-3-3a1 1 0 011.414-1.414L9 11.586l6.293-6.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
        </div>
        <h4 class="text-lg font-semibold">Menghubungi Terapis...</h4>
        <p class="text-gray-600">Mohon tunggu sebentar, kami sedang mencari terapis terbaik untuk Anda.</p>
        <p class="text-gray-600">Link pembayaran akan dikirimkan.</p>
    </div>
</div>
@endsection
@push('bottom')
    <script src="{{ url(asset('assets/js/nav.js')) }}"></script>
@endpush