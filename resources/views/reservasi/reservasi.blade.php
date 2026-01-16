@extends('layouts.HomeLayout')

@push('top')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')

<!-- Banner Promo Section -->
{{-- <section class="relative bg-gradient-to-r from-blue-500 to-blue-700 text-white py-10 px-6 rounded-lg shadow-md my-10 mx-4 lg:mx-0">
  <div class="container mx-auto flex flex-col lg:flex-row items-center justify-between gap-6">
    <div class="text-center lg:text-left max-w-lg">
      <h2 class="text-3xl lg:text-4xl font-bold mb-4">🎉 Promo Spesial Akhir Tahun!</h2>
      <p class="text-lg mb-6">
        Dapatkan diskon hingga <span class="font-bold text-yellow-300">50%</span> untuk semua layanan terapi kami. Berlaku hingga <span class="font-bold">31 Desember 2024</span>.
      </p>
    </div>
  </div>
</section> --}}

<!-- Form Layout Section -->
<section class="max-w-4xl mx-auto my-12 px-4">
  <div class="card bg-base-100 shadow-xl">
    <div class="card-body">
      <h2 class="card-title justify-center text-2xl">
        Formulir Reservasi
      </h2>

      <form action="{{ route('checkout') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Nama & WA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label">
              <span class="label-text">Nama Lengkap</span>
            </label>
            <input type="text" name="nama_lengkap"
              value="{{ old('nama_lengkap') }}"
              class="input input-bordered w-full"
              placeholder="Masukkan nama lengkap">
            @error('nama_lengkap') <span class="text-error text-sm">{{ $message }}</span> @enderror
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Nomor WhatsApp</span>
            </label>
            <input type="tel" name="nohp"
              value="{{ old('nohp') }}"
              class="input input-bordered w-full"
              placeholder="08xxxxxxxxxx">
            @error('nohp') <span class="text-error text-sm">{{ $message }}</span> @enderror
          </div>
        </div>

        {{-- Gender & Layanan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Jenis Kelamin</span></label>
            <select name="jenis_kelamin" class="select select-bordered w-full">
              <option disabled selected>Pilih</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
            @error('jenis_kelamin') <span class="text-error text-sm">{{ $message }}</span> @enderror
          </div>

          <div class="form-control">
            <label class="label"><span class="label-text">Jenis Layanan</span></label>
            <select id="jenisLayanan" name="layanan" class="select select-bordered w-full">
              <option disabled selected>Pilih</option>
              <option value="Center">Datang ke Center</option>
              <option value="Homecare">Homecare</option>
            </select>
            @error('layanan') <span class="text-error text-sm">{{ $message }}</span> @enderror
          </div>
        </div>

        {{-- Tanggal & Jam --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Tanggal</span></label>
            <input id="tanggalPicker" type="text" name="tanggal"
              class="input input-bordered w-full"
              placeholder="Pilih tanggal">
            @error('tanggal') <span class="text-error text-sm">{{ $message }}</span> @enderror
          </div>

          <input type="text" name="hari" id="hari" style="display: none">
          
          <div class="form-control">
            <label class="label"><span class="label-text">Jam</span></label>
            <select id="jam" name="jam" class="select select-bordered w-full">
              <option disabled selected>Pilih Jam</option>
            </select>
            @error('jam') <span class="text-error text-sm">{{ $message }}</span> @enderror
          </div>
        </div>

        {{-- Terapi --}}
        <div class="form-control">
          <label class="label"><span class="label-text">Jenis Terapi</span></label>
          <select name="terapi" class="select select-bordered w-full">
            <option disabled selected>Pilih Terapi</option>
            @foreach ($layanan_terapi as $item)
              <option value="{{ $item->id }}">
                {{ $item->nama_terapi }} - {{ $item->jenis_terapi }}
              </option>
            @endforeach
          </select>
          @error('terapi') <span class="text-error text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Alamat (Homecare) --}}
        <div id="alamatSection" class="form-control hidden">
          <label class="label"><span class="label-text">Alamat</span></label>
          <textarea name="alamat"
            class="textarea textarea-bordered w-full"
            placeholder="Alamat lengkap di Banyuwangi"></textarea>
        </div>

        {{-- Jumlah --}}
        <div class="form-control w-32">
          <label class="label"><span class="label-text">Jumlah Orang</span></label>
          <input type="number" name="jumlah" min="1" value="1"
            class="input input-bordered">
        </div>

        {{-- Submit --}}
        <div class="pt-4">
          <button class="btn btn-primary w-full uppercase" type="submit">
            Reservasi Sekarang
          </button>
        </div>
      </form>
    </div>
  </div>
</section>


@endsection

@push('bottom')
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="{{ url(asset('assets/js/nav.js')) }}"></script>
  <script type="module" src="{{ url(asset('assets/js/reservasi.js')) }}"></script>
@endpush