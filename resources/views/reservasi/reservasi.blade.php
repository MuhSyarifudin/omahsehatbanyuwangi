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
<section class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md my-10">
  <h2 class="text-2xl font-bold mb-6 text-center text-black">Formulir Reservasi</h2>
  <form action="{{ route('checkout') }}" method="POST" class="space-y-4">
    @csrf
    <div class="form-control">
      <label class="label"><span class="label-text">Nama Lengkap</span></label>
      <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" class="input input-bordered" />
      @error('nama_lengkap') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
    </div>

    <div class="form-control">
      <label class="label"><span class="label-text">Nomor WA</span></label>
      <input type="tel" name="nohp" value="{{ old('nohp') }}" placeholder="Masukkan nomor telepon" class="input input-bordered" />
      @error('nohp') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
    </div>

    <div class="form-control">
      <label class="label"><span class="label-text">Jenis Kelamin</span></label>
      <select name="jenis_kelamin" class="select select-bordered">
        <option disabled selected>Pilih Jenis Kelamin</option>
        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
      </select>
      @error('jenis_kelamin') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
    </div>

    <div class="form-control">
      <label class="label"><span class="label-text">Jenis Layanan</span></label>
      <select id="jenisLayanan" name="layanan" class="select select-bordered">
        <option disabled selected>Pilih Layanan</option>
        <option value="Center" {{ old('layanan') == 'Center' ? 'selected' : '' }}>Datang ke Center</option>
        <option value="Homecare" {{ old('layanan') == 'Homecare' ? 'selected' : '' }}>Homecare</option>
      </select>
      @error('layanan') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
    </div>

    <div class="form-control w-full">
      <label class="label">
        <span class="label-text">Pilih Tanggal</span>
      </label>
      <input 
        type="text" 
        id="tanggalPicker" 
        name="tanggal" 
        placeholder="Pilih Tanggal" 
        class="input input-bordered w-full"
      />
      @error('tanggal')
        <span class="text-sm text-red-600">{{ $message }}</span>
      @enderror
    </div>

    <input type="text" name="hari" id="hari" style="display: none">

    <div class="form-control">
      <label class="label"><span class="label-text">Pilih Jam</span></label>
      <select id="jam" name="jam" class="select select-bordered">
        <option disabled selected>Pilih Jam</option>
      </select>
      @error('jam') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
    </div>

    <div class="form-control">
      <label class="label"><span class="label-text">Jenis Terapi</span></label>
      <select name="terapi" class="select select-bordered">
        <option disabled selected>Pilih Terapi</option>
        @foreach ($layanan_terapi as $item)
          <option value="{{ $item->id }}" {{ old('terapi') == $item->id ? 'selected' : '' }}>{{ $item->nama_terapi }} - {{ $item->jenis_terapi }}</option>
        @endforeach
      </select>
      @error('terapi') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
    </div>

    <div class="form-control" id="alamatSection" style="display: none;">
      <label class="label"><span class="label-text">Alamat</span></label>
      <textarea name="alamat" class="textarea textarea-bordered w-full" placeholder="Layanan hanya tersedia di Kab. Banyuwangi">{{ old('alamat') }}</textarea>
      @error('alamat') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
    </div>

    <div class="form-control">
      <label class="label"><span class="label-text">Jumlah Orang</span></label>
      <input type="number" name="jumlah" min="1" value="{{ old('jumlah') ?? '1' }}" class="input input-bordered" />
      @error('jumlah') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
    </div>

    <div class="form-control mt-6">
      <button type="submit" class="btn btn-primary w-full">Reservasi Sekarang</button>
    </div>
  </form>
</section>

@endsection

@push('bottom')
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="{{ url(asset('assets/js/nav.js')) }}"></script>
  <script type="module" src="{{ url(asset('assets/js/reservasi.js')) }}"></script>
@endpush