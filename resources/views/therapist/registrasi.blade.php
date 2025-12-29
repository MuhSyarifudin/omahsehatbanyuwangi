@extends('layouts.HomeLayout')

@section('content')
<section class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md my-10">
    <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Pendaftaran Terapis</h2>

    <form method="POST" action="{{ route('therapist.store') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukan nama lengkap anda" class="input input-bordered w-full" required autofocus>
            @error('nama')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Alamat -->
        <div class="mb-4">
            <label for="alamat" class="block text-sm font-medium text-gray-600">Alamat</label>
            <textarea id="alamat" name="alamat" class="textarea textarea-bordered w-full" rows="3" required placeholder="Masukan Alamat lengkap anda">{{ old('alamat') }}</textarea>
            @error('alamat')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Keahlian -->
        <div class="mb-4">
            <label for="keahlian" class="block text-sm font-medium text-gray-600">Keahlian</label>
            <select id="keahlian" name="keahlian" class="select select-bordered w-full" required>
                <option value="">Pilih Keahlian</option>
                @foreach ($keahlian as $item)
                {{-- <option value="{{ $item->nama }}" @if(old('keahlian') == {{ $item->nama }}) selected @endif>{{ $item->nama }}</option> --}}
                <option value="{{ $item->nama }}" {{ old('keahlian') == $item->nama ? 'selected' : '' }}>{{ $item->nama }}</option>
                @endforeach
            </select>
            @error('keahlian')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="input input-bordered w-full" required placeholder="Masukan Email anda">
            @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Nomor WhatsApp -->
        <div class="mb-4">
            <label for="whatsapp" class="block text-sm font-medium text-gray-600">Nomor WhatsApp</label>
            <input type="phone" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" class="input input-bordered w-full" required placeholder="Masukan nomor WA anda">
            @error('whatsapp')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="btn btn-primary w-full">
                Daftar Sekarang
            </button>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Sudah punya akun? Masuk</a>
        </div>
    </form>
</section>
@endsection
@push('bottom')
    <script src="{{ url('assets/js/nav.js') }}"></script>
@endpush
