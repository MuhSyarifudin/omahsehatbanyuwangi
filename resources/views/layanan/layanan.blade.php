@extends('layouts.app')

@section('content')
<main class="container mx-auto py-10">
    <div class="grid md:grid-cols-3 gap-8">
        <!-- Terapi Bekam -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <img src="/path/to/terapi-bekam.jpg" alt="Terapi Bekam" class="w-full h-48 object-cover">
            <div class="p-5">
                <h2 class="text-xl font-semibold text-primary">Terapi Bekam</h2>
                <p class="text-gray-600 mt-2">Meningkatkan sirkulasi darah dan membuang racun dari tubuh.</p>
            </div>
        </div>

        <!-- Terapi Kecantikan -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <img src="/path/to/terapi-kecantikan.jpg" alt="Terapi Kecantikan" class="w-full h-48 object-cover">
            <div class="p-5">
                <h2 class="text-xl font-semibold text-primary">Terapi Kecantikan</h2>
                <p class="text-gray-600 mt-2">Perawatan untuk kulit sehat dan bercahaya secara alami.</p>
            </div>
        </div>

        <!-- Terapi Akupuntur -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <img src="/path/to/terapi-akupuntur.jpg" alt="Terapi Akupuntur" class="w-full h-48 object-cover">
            <div class="p-5">
                <h2 class="text-xl font-semibold text-primary">Terapi Akupuntur</h2>
                <p class="text-gray-600 mt-2">Membantu meredakan berbagai macam keluhan kesehatan.</p>
            </div>
        </div>

        <!-- Tambahan Layanan -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <img src="/path/to/layanan-lain.jpg" alt="Layanan Lainnya" class="w-full h-48 object-cover">
            <div class="p-5">
                <h2 class="text-xl font-semibold text-primary">Layanan Lainnya</h2>
                <p class="text-gray-600 mt-2">Kami juga menyediakan layanan lain yang sesuai kebutuhan Anda.</p>
            </div>
        </div>
    </div>
</main>

@endsection

@push('bottom')
  <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
  <script src="{{ url(asset('assets/js/nav.js')) }}"></script>
@endpush