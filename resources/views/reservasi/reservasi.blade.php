@extends('layouts.HomeLayout')

@push('top')
@endpush

@section('content')

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
</div>

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
</div> --}}
@if($promos->count() > 0)
<div class="swiper promoSwiper h-[320px] md:h-[240px] overflow-hidden">
    <div class="swiper-wrapper">

        @foreach($promos as $promo)
        <div class="swiper-slide !h-auto flex items-center">
        <div class="max-w-4xl mx-auto mt-8 px-4">
            <div class="relative overflow-hidden
                @if($promo->mode == 'homecare')
                relative overflow-hidden bg-gradient-to-br from-amber-400 via-orange-500 to-red-500 rounded-3xl p-6 text-white shadow-2xl z-10 border-b-4 border-orange-700
                @else
                relative overflow-hidden bg-gradient-to-br from-blue-700 via-indigo-600 to-violet-700 rounded-3xl p-6 text-white shadow-2xl z-10 border-b-4 border-indigo-900
                @endif
                rounded-3xl p-6 text-white shadow-2xl z-10 border-b-4">


                @if ($promo->mode == 'homecare')
                <div class="absolute right-2 top-0 opacity-20 translate-x-1/4 -translate-y-1/8">
                  <svg width="180" height="180" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                  </svg>
                </div>
                @else
                <div class="absolute right-0 top-0 opacity-10 translate-x-1/4 -translate-y-1/4">
                  <svg width="200" height="200" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                  </svg>
                </div>           
                @endif

                <div class="flex flex-col md:flex-row items-center gap-6 relative z-20">

                    {{-- Circle --}}
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 bg-white rounded-full flex flex-col items-center justify-center shadow-xl border-4
                            @if($promo->mode == 'homecare')
                                border-orange-200
                            @else
                                border-indigo-200
                            @endif">

                            <span class="text-xs font-bold text-gray-600 uppercase">
                                {{ $promo->type == 'percentage' ? 'Diskon' : 'Cashback' }}
                            </span>

                            <span class="text-3xl font-black text-gray-800">
                                @if($promo->type == 'percentage')
                                    {{ $promo->value }}%
                                @else
                                    {{ number_format($promo->value / 1000, 0) }}K
                                @endif
                            </span>
                        </div>

                        
                    </div>

                    {{-- Content --}}
                    <div class="text-center md:text-left flex-grow">

                        <div class="inline-flex items-center gap-2 bg-black/20 px-3 py-1 rounded-full text-[10px] font-bold uppercase mb-2">
                          @if ($promo->mode == 'homecare')
                          <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-300 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-400"></span>
                          </span>                      
                          @else
                          <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-300 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-400"></span>
                          </span>                      
                          @endif
                            {{ $promo->mode == 'homecare' ? 'Promo Homecare' : 'Promo Treatment Center' }}
                        </div>

                        <h3 class="text-2xl md:text-3xl font-black uppercase">
                            {{ $promo->title }}
                        </h3>

                        <p class="mt-2 text-sm">
                            {!! $promo->description !!}
                        </p>

                        <p class="text-xs mt-2 opacity-80">
                            Berlaku sampai {{ dateid('j F Y',$promo->end_date) }}
                        </p>

                      </div>

                      @if ($promo->mode == 'homecare')
                      <div class="hidden lg:flex flex-col items-end">
                        <div class="bg-white/20 backdrop-blur-sm border border-white/30 p-2 rounded-lg text-right">
                            <p class="text-[10px] uppercase opacity-80 leading-tight">Metode:</p>
                            <p class="text-sm font-bold leading-tight">Potongan Saldo / Tunai</p>
                        </div>
                      </div>                  
                      @else
                      <div class="hidden lg:block">
                          <div class="flex flex-col items-center rotate-3 bg-white text-blue-800 p-3 rounded-xl shadow-xl">
                              <span class="text-[10px] font-bold uppercase leading-none">Status</span>
                              <span class="text-lg font-black leading-none">AKTIF</span>
                          </div>
                      </div>                  
                      @endif
                </div>
            </div>
        </div>
        </div>
        @endforeach
      </div>
      <div class="swiper-pagination mt-4"></div>
</div>
@endif

<!-- Form Layout Section -->
<section class="max-w-4xl mx-auto mb-12 @if ($promos->count() > 0)
  mt-2  
  @else
  mt-10
@endif px-4">
  <div class="card bg-base-100 shadow-xl border">
    <div class="card-body">

      <h2 class="text-2xl font-semibold text-center mb-4">
        Formulir Reservasi
      </h2>

      <form action="{{ route('checkout') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Section Nama & WA -->
        <div class="grid md:grid-cols-2 gap-5">
          <div class="form-control w-full">
            <label class="label">
              <span class="label-text font-medium">Nama Lengkap</span>
            </label>
            <input type="text"
              name="nama_lengkap"
              value="{{ old('nama_lengkap') }}"
              placeholder="Masukkan nama lengkap"
              class="input input-bordered w-full @error('nama_lengkap') input-error @enderror">
            @error('nama_lengkap')
              <span class="text-error text-xs mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-control w-full">
            <label class="label">
              <span class="label-text font-medium">Nomor WhatsApp</span>
            </label>
            <input type="tel"
              name="nohp"
              value="{{ old('nohp') }}"
              placeholder="081xxx / +6281xxxxx / +44xxxxx"
              class="input input-bordered w-full @error('nohp') input-error @enderror">
            @error('nohp')
              <span class="text-error text-xs mt-1">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <!-- Section Gender & Layanan -->
        <div class="grid md:grid-cols-2 gap-5">
          <div class="form-control w-full">
            <label class="label">
              <span class="label-text font-medium">Jenis Kelamin</span>
            </label>
            <select name="jenis_kelamin"
              class="select select-bordered w-full @error('jenis_kelamin') select-error @enderror">
              <option disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih</option>
              <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
              <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
              <span class="text-error text-xs mt-1">{{ $message }}</span>
            @enderror
          </div>

          <!-- Section Jenis Layanan -->
          <div class="form-control w-full">
            <label class="label">
              <span class="label-text font-medium">Jenis Layanan</span>
            </label>
            <select id="jenisLayanan"
              name="layanan"
              class="select select-bordered w-full @error('layanan') select-error @enderror">
              <option disabled {{ old('layanan') ? '' : 'selected' }}>Pilih</option>
              <option value="center" {{ old('layanan') == 'center' ? 'selected' : '' }}>
                Treatment Center
              </option>
              <option value="homecare" {{ old('layanan') == 'homecare' ? 'selected' : '' }}>
                Homecare
              </option>
            </select>
            @error('layanan')
              <span class="text-error text-xs mt-1">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <!-- Section Tanggal & Jam -->
        <div class="grid md:grid-cols-2 gap-5">

          <div class="form-control w-full">
            <label class="label">
              <span class="label-text font-medium">Tanggal</span>
            </label>
            <input id="tanggalPicker"
              type="text"
              name="tanggal"
              value="{{ old('tanggal') }}"
              placeholder="Pilih tanggal"
              class="input input-bordered w-full @error('tanggal') input-error @enderror">

            <small id="tanggalHelp" class="text-xs text-base-content/60 mt-1">
              Pilih jenis layanan terlebih dahulu
            </small>

            @error('tanggal')
              <span class="text-error text-xs mt-1">{{ $message }}</span>
            @enderror
          </div>

          <input type="hidden" name="hari" id="hari" value="{{ old('hari') }}">
          <input type="text" name="website" style="display:none">

          <!-- Section Jam -->
          <div class="form-control w-full">
            <label class="label">
              <span class="label-text font-medium">Jam</span>
            </label>
            <select id="jam"
              name="jam"
              class="select select-bordered w-full @error('jam') select-error @enderror">
              <option disabled {{ old('jam') ? '' : 'selected' }}>Pilih Jam</option>
              @if(old('jam'))
                <option value="{{ old('jam') }}" selected>{{ old('jam') }}</option>
              @endif
            </select>

            <small id="jamHelp" class="text-xs text-base-content/60 mt-1">
              Pilih tanggal untuk melihat jam tersedia
            </small>

            @error('jam')
              <span class="text-error text-xs mt-1">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <!-- Section Jenis Terapi -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text font-medium">Jenis Terapi</span>
          </label>
          <select name="terapi"
            class="select select-bordered w-full @error('terapi') select-error @enderror">
            <option disabled {{ old('terapi') ? '' : 'selected' }}>Pilih Terapi</option>
            @foreach ($layanan_terapi as $item)
              <option value="{{ $item->id }}"
                {{ old('terapi') == $item->id ? 'selected' : '' }}>
                {{ $item->nama_terapi }} - {{ $item->jenis_terapi }}
              </option>
            @endforeach
          </select>
          @error('terapi')
            <span class="text-error text-xs mt-1">{{ $message }}</span>
          @enderror
        </div>

        <!-- Section Alamat -->
        <div id="alamatSection"
          class="form-control w-full {{ old('layanan') == 'homecare' ? '' : 'hidden' }}">
          <label class="label">
            <span class="label-text font-medium">Alamat</span>
          </label>
          <textarea name="alamat"
            placeholder="Alamat lengkap di Banyuwangi"
            class="textarea textarea-bordered w-full @error('alamat') textarea-error @enderror">{{ old('alamat') }}</textarea>
          @error('alamat')
            <span class="text-error text-xs mt-1">{{ $message }}</span>
          @enderror
        </div>

        <!-- Section Jumlah & Promo -->
        <div class="grid md:grid-cols-2 gap-5">
          <div class="form-control w-full">
            <label class="label">
              <span class="label-text font-medium">Jumlah Orang</span>
            </label>
            <input type="number"
              name="jumlah"
              min="1"
              value="{{ old('jumlah', 1) }}"
              class="input input-bordered w-full @error('jumlah') input-error @enderror">
            @error('jumlah')
              <span class="text-error text-xs mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-control w-full">
            <label class="label">
              <span class="label-text font-medium">Pilih Promo</span>
            </label>
            <select name="promo_id" class="select select-bordered w-full">
              <option value="">Tanpa Promo</option>
              @foreach($promos as $promo)
                <option value="{{ $promo->id }}">
                  {{ $promo->title }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-full mt-4 uppercase">
          Reservasi Sekarang
        </button>

      </form>
    </div>
  </div>
</section>


@endsection

@push('bottom')
  <script src="{{ url(asset('assets/js/nav.js')) }}"></script>
  <script type="module" src="{{ url(asset('assets/js/reservasi.js')) }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {

    new window.Swiper(".promoSwiper", {
        loop: true,
        spaceBetween: 20,

        autoplay: {
            delay: 10000,
            disableOnInteraction: false,
        },

        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

});
  </script>
@endpush