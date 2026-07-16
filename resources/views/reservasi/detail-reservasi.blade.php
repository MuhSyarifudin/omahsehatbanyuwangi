@extends('layouts.HomeLayout')
@push('top')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

@section('content')

<section class="min-h-screen bg-slate-200 py-10 md:py-20 px-4 font-sans text-slate-900 flex items-center justify-center">
  <div class="w-full max-w-5xl bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100 md:min-h-[650px] flex flex-col md:flex-row">
      
      <div class="w-full md:w-3/5 p-8 md:p-16 flex flex-col justify-center border-b md:border-b-0 md:border-r border-slate-100">
          <div class="mb-10">
              <div class="inline-block px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-widest mb-4">
                  Reservation Summary
              </div>
              <h2 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900">Detail Pesanan</h2>
              <p class="text-slate-400 mt-2 text-sm">Pastikan seluruh data di bawah ini sudah sesuai.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
              <div class="space-y-1">
                  <span class="block text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold">Nama Lengkap</span>
                  <p class="text-xl font-bold text-slate-800 leading-tight">{{ $transaksi->nama }}</p>
              </div>
              <div class="space-y-1">
                  <span class="block text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold">WhatsApp</span>
                  <p class="text-xl font-bold text-slate-800 leading-tight">{{ $transaksi->nohp }}</p>
              </div>

              <div class="space-y-1">
                  <span class="block text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold">Layanan</span>
                  <p class="text-xl font-bold text-indigo-600 leading-tight">{{ $transaksi->nama_terapi }}</p>
                  <p class="text-sm text-slate-500 font-medium">{{ $jenis_terapi->jenis_terapi }}</p>
              </div>
              <div class="space-y-1">
                  <span class="block text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold">Lokasi</span>
                  <p class="text-xl font-bold text-slate-800 leading-tight">{{ $transaksi->tempat }}</p>
              </div>

              @if (isset($transaksi->alamat))
              <div class="md:col-span-2 pt-4 border-t border-slate-50">
                  <span class="block text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold mb-2">Alamat Pengiriman/Layanan</span>
                  <p class="text-sm text-slate-500 leading-relaxed italic">"{{ $transaksi->alamat }}"</p>
              </div>
              @endif
          </div>
      </div>

      <div class="w-full md:w-2/5 bg-slate-50/80 p-8 md:p-16 flex flex-col justify-between relative">
          <div class="hidden md:block absolute top-0 right-0 p-8 opacity-10">
              <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="20" stroke-dasharray="20 10"/>
              </svg>
          </div>

          <div class="relative">
              <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-8 border-b border-slate-200 pb-4">
                  Invoice Details
              </h3>

              <div class="space-y-5">
                  <div class="flex justify-between items-center text-slate-600 font-medium">
                      <span>Kuantitas</span>
                      <span>{{ $transaksi->jumlah }} Orang</span>
                  </div>
                  <div class="flex justify-between items-center text-slate-600 font-medium">
                      <span>Biaya Satuan</span>
                      <span>Rp {{ number_format($harga_terapi, 0, ',', '.') }}</span>
                  </div>
                  
                  <div class="pt-8 mt-8 border-t-2 border-dashed border-slate-200">
                      <span class="block text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold mb-2">Total yang harus dibayar</span>
                      <div class="flex items-baseline gap-1">
                          <span class="text-4xl font-black text-slate-900 tracking-tighter">
                              Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                          </span>
                      </div>
                  </div>
              </div>
          </div>

          <div class="mt-12 md:mt-0 relative">
              <button id="pay-button" class="group w-full bg-slate-900 hover:bg-indigo-600 text-white font-bold py-5 rounded-2xl transition-all duration-500 shadow-2xl shadow-indigo-100 flex justify-center items-center gap-3">
                  <span class="tracking-wide">Konfirmasi & Bayar</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                  </svg>
              </button>
              <div class="mt-6 flex items-center justify-center gap-2 opacity-40">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                  <span class="text-[9px] font-bold uppercase tracking-widest">Encrypted & Secure Payment</span>
              </div>
          </div>
      </div>

  </div>
</section>


@endsection

@push('bottom')

<script src="{{ url(asset('assets/js/nav.js')) }}"></script>
<script>
let snapOpen = false;

const payButton = document.getElementById('pay-button');

payButton.addEventListener('click', function () {

    if (snapOpen) return;

    snapOpen = true;

    if (window.snap) {
    window.snap.hide();
    }

    window.snap.pay('{{ $snapToken }}', {
        onSuccess: function (result) {
            snapOpen = false;
            console.log(result);
            alert("Payment success!");
        },
        onPending: function (result) {
            snapOpen = false;
            console.log(result);
            alert("Waiting payment!");
        },
        onError: function (result) {
            snapOpen = false;
            console.log(result);
            alert("Payment failed!");
        },
        onClose: function () {
            snapOpen = false;
            console.log("Popup closed");
        }
    });

});
</script>
@endpush