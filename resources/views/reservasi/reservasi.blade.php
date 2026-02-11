@extends('layouts.HomeLayout')

@push('top')
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

{{-- <div class="max-w-4xl mx-auto mt-8 px-4">
  <div class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-indigo-600 to-violet-700 rounded-3xl p-6 text-white shadow-2xl mb-[-1.5rem] z-10 border-b-4 border-indigo-900">
      
      <div class="absolute right-0 top-0 opacity-10 translate-x-1/4 -translate-y-1/4">
          <svg width="200" height="200" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
          </svg>
      </div>

      <div class="flex flex-col md:flex-row items-center gap-6 relative z-20">
          <div class="flex-shrink-0">
              <div class="w-20 h-20 bg-yellow-400 rounded-full flex items-center justify-center shadow-inner border-4 border-white/30">
                  <span class="text-3xl font-black text-blue-900 leading-none">20%</span>
              </div>
          </div>

          <div class="text-center md:text-left flex-grow">
              <div class="inline-block bg-white/20 px-3 py-1 rounded-full text-xs font-bold tracking-widest uppercase mb-2">
                  🔥 Special In-Store Promo
              </div>
              <h3 class="text-2xl md:text-3xl font-black italic tracking-tight uppercase">
                  CASHBACK LANGSUNG!
              </h3>
              <p class="text-indigo-50 font-medium">
                  Tanpa kode ribet, cukup pilih layanan <span class="text-yellow-300 underline font-bold text-lg px-1">"Datang ke Center"</span> dan dapatkan potongan 20% di tempat.
              </p>
          </div>

          <div class="hidden lg:block">
              <div class="flex flex-col items-center rotate-3 bg-white text-blue-800 p-3 rounded-xl shadow-xl">
                  <span class="text-[10px] font-bold uppercase leading-none">Status</span>
                  <span class="text-lg font-black leading-none">AKTIF</span>
              </div>
          </div>
      </div>
  </div>
</div> --}}

<div class="max-w-4xl mx-auto mt-8 px-4">
  <div class="relative overflow-hidden bg-gradient-to-br from-amber-400 via-orange-500 to-red-500 rounded-3xl p-6 text-white shadow-2xl mb-[-1.5rem] z-10 border-b-4 border-orange-700">
      
      <div class="absolute right-2 top-0 opacity-20 translate-x-1/4 -translate-y-1/8">
          <svg width="180" height="180" fill="currentColor" viewBox="0 0 24 24">
              <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
          </svg>
      </div>

      <div class="flex flex-col md:flex-row items-center gap-6 relative z-20">
          <div class="flex-shrink-0">
              <div class="w-24 h-24 bg-white rounded-full flex flex-col items-center justify-center shadow-xl border-4 border-orange-200">
                  <span class="text-xs font-bold text-orange-600 leading-none uppercase">Cashback</span>
                  <span class="text-4xl font-black text-orange-600 leading-none">20%</span>
              </div>
          </div>

          <div class="text-center md:text-left flex-grow">
              <div class="inline-flex items-center gap-2 bg-black/20 px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase mb-2">
                  <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-300 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-400"></span>
                  </span>
                  Promo Khusus Homecare
              </div>
              <h3 class="text-2xl md:text-3xl font-black tracking-tight uppercase leading-tight">
                  TERAPIS DATANG, <br class="hidden md:block">UANG KEMBALI!
              </h3>
              <p class="text-orange-50 font-medium mt-1">
                  Nikmati layanan profesional di rumah Anda dan dapatkan <span class="text-yellow-200 font-bold underline">Cashback Langsung 20%</span> tanpa ribet input kode!
              </p>
          </div>

          <div class="hidden lg:flex flex-col items-end">
              <div class="bg-white/20 backdrop-blur-sm border border-white/30 p-2 rounded-lg text-right">
                  <p class="text-[10px] uppercase opacity-80 leading-tight">Metode:</p>
                  <p class="text-sm font-bold leading-tight">Potongan Saldo / Tunai</p>
              </div>
          </div>
      </div>
  </div>
</div>

<!-- Form Layout Section -->
<section class="max-w-4xl mx-auto my-12 px-4">
  <div class="card bg-base-100 shadow-xl">
    <div class="card-body">
      <h2 class="card-title justify-center text-2xl">
        Formulir Reservasi
      </h2>

      {{-- <div class="alert alert-info shadow-sm mb-6 bg-blue-50 border-none">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6 text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div class="text-sm">
            <span class="font-bold text-blue-800 italic">Diskon Homecare!</span> 
            <span class="text-blue-700">Dapatkan potongan Rp20.000 untuk layanan pertama Anda hari ini.</span>
        </div>
    </div> --}}

      <form action="{{ route('checkout') }}" method="POST" class="space-y-6">
        @csrf
      
        {{-- Nama & WA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Nama Lengkap</span></label>
            <input type="text" name="nama_lengkap"
              value="{{ old('nama_lengkap') }}"
              class="@error('nama_lengkap')
                border border-red-500
              @enderror input input-bordered w-full"
              placeholder="Masukkan nama lengkap">
            @error('nama_lengkap') <span class="text-error text-xs">ⓘ {{ $message }}</span> @enderror
          </div>
      
          <div class="form-control">
            <label class="label"><span class="label-text">Nomor WhatsApp</span></label>
            <input type="tel" name="nohp"
              value="{{ old('nohp') }}"
              class="@error('nohp')
              border border-red-500
            @enderror input input-bordered w-full"
              placeholder="081xxx / +6281xxxxx / +44xxxxx">
            @error('nohp') <span class="text-error text-xs">ⓘ {{ $message }}</span> @enderror
          </div>
        </div>
      
        {{-- Gender & Layanan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Jenis Kelamin</span></label>
            <select name="jenis_kelamin" class="@error('jenis_kelamin')
            border border-red-500
          @enderror select select-bordered w-full">
              <option disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih</option>
              <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
              <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin') <span class="text-error text-xs">ⓘ {{ $message }}</span> @enderror
          </div>
      
          <div class="form-control">
            <label class="label"><span class="label-text">Jenis Layanan</span></label>
            <select id="jenisLayanan" name="layanan" class="@error('layanan')
            border border-red-500
          @enderror select select-bordered w-full">
              <option disabled {{ old('layanan') ? '' : 'selected' }}>Pilih</option>
              <option value="center" {{ old('layanan') == 'Center' ? 'selected' : '' }}>
                Datang ke Center
              </option>
              <option value="homecare" {{ old('layanan') == 'Homecare' ? 'selected' : '' }}>
                Homecare
              </option>
            </select>
            @error('layanan') <span class="text-error text-xs">ⓘ {{ $message }}</span> @enderror
          </div>
        </div>
      
        {{-- Tanggal & Jam --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text">Tanggal</span></label>
            <input id="tanggalPicker" type="text" name="tanggal"
              value="{{ old('tanggal') }}"
              class="@error('tanggal')
              border border-red-500
            @enderror input input-bordered w-full"
              placeholder="Pilih tanggal">
            @error('tanggal') <span class="text-error text-xs">ⓘ {{ $message }}</span> @enderror
            <small id="tanggalHelp" class="text-slate-500 text-xs mt-1 block">
              Pilih jenis layanan terlebih dahulu
          </small>
          </div>
      
          <input type="hidden" name="hari" id="hari" value="{{ old('hari') }}">
          <input type="text" name="website" style="display:none">
      
          <div class="form-control">
            <label class="label"><span class="label-text">Jam</span></label>
            <select id="jam" name="jam" class="@error('jam')
            border border-red-500
          @enderror select select-bordered w-full">
              <option disabled {{ old('jam') ? '' : 'selected' }}>Pilih Jam</option>
              @if(old('jam'))
                <option value="{{ old('jam') }}" selected>{{ old('jam') }}</option>
              @endif
            </select>
            @error('jam') <span class="text-error text-xs">ⓘ {{ $message }}</span> @enderror
            <small id="jamHelp" class="text-slate-500 text-xs mt-1 block">
              Pilih tanggal untuk melihat jam tersedia
          </small>
          </div>
        </div>
      
        {{-- Terapi --}}
        <div class="form-control">
          <label class="label"><span class="label-text">Jenis Terapi</span></label>
          <select name="terapi" class="@error('terapi')
          border border-red-500
        @enderror select select-bordered w-full">
            <option disabled {{ old('terapi') ? '' : 'selected' }}>Pilih Terapi</option>
            @foreach ($layanan_terapi as $item)
              <option value="{{ $item->id }}"
                {{ old('terapi') == $item->id ? 'selected' : '' }}>
                {{ $item->nama_terapi }} - {{ $item->jenis_terapi }}
              </option>
            @endforeach
          </select>
          @error('terapi') <span class="text-error text-xs">ⓘ {{ $message }}</span> @enderror
        </div>
      
        {{-- Alamat Homecare --}}
        <div id="alamatSection"
          class="form-control {{ old('layanan') == 'Homecare' ? '' : 'hidden' }}">
          <label class="label"><span class="label-text">Alamat</span></label>
          <textarea name="alamat"
            class="@error('alamat')
            border border-red-500
          @enderror textarea textarea-bordered w-full"
            placeholder="Alamat lengkap di Banyuwangi">{{ old('alamat') }}</textarea>
          @error('alamat') <span class="text-error text-xs">ⓘ {{ $message }}</span> @enderror
        </div>
      
        {{-- Jumlah --}}
        <div class="form-control w-32">
          <label class="label"><span class="label-text">Jumlah Orang</span></label>
          <input type="number" name="jumlah" min="1"
            value="{{ old('jumlah', 1) }}"
            class="@error('jumlah')
            border border-red-500
          @enderror input input-bordered">
          @error('jumlah') <span class="text-error text-xs">ⓘ {{ $message }}</span> @enderror
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
  <script src="{{ url(asset('assets/js/nav.js')) }}"></script>
  <script type="module" src="{{ url(asset('assets/js/reservasi.js')) }}"></script>
@endpush