@extends('layouts.HomeLayout')
@push('top')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

@section('content')

<!-- Detail Pesanan Section -->
<section class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md my-10">
  <h2 class="text-2xl font-bold mb-6 text-center text-black">Detail Reservasi</h2>
  
    <div class="space-y-4">
      <div class="form-control w-full">
        <label class="label">
          <span class="text-black">Nama Lengkap</span>
        </label>
        <input type="text" name="nama_lengkap" value="{{ $transaksi->nama }}" class="input input-bordered w-full" readonly />
      </div>
      
      <div class="form-control w-full">
        <label class="label">
          <span class="text-black">Jenis Layanan</span>
        </label>
        <input type="text" name="tempat" value="{{ $transaksi->tempat }}" class="input input-bordered w-full" readonly />
      </div>
      
      <div class="form-control w-full">
        <label class="label">
          <span class="text-black">Nomor WA</span>
        </label>
        <input type="text" name="nohp" value="{{ $transaksi->nohp }}" class="input input-bordered w-full" readonly />
      </div>


      @if (isset($transaksi->alamat))
      <div class="form-control w-full">
        <label class="label">
          <span class="text-black">Alamat</span>
        </label>
        <textarea name="alamat" class="textarea textarea-bordered w-full" readonly>{{ $transaksi->alamat }}</textarea>
      </div>          
      @endif
  
      <div class="overflow-x-auto">
        <table class="table w-full">
          <thead>
            <tr>
              <th class="text-left">Nama Terapi</th>
              <th class="text-left">Jumlah Orang</th>
              <th class="text-left">Harga Satuan</th>
              <th class="text-left">Total</th>
            </tr>
          </thead>
          <tbody>
            <!-- Contoh data produk -->
            <tr>
              <td class="border-b">{{ $transaksi->nama_terapi }}</td>
              <td class="border-b">{{ $transaksi->jumlah }}</td>
              <td class="border-b">{{ $harga_terapi }}</td>
              <td class="border-b">{{ $transaksi->total_harga }}</td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <div class="mt-6">
        <div class="flex justify-between mt-2">
          <span class="font-bold text-xl text-black">Total:</span>
          <span class="text-xl text-black">Rp {{ $transaksi->total_harga }}</span>
        </div>
      </div>
  
      
      <div class="form-control mt-6">
        <button class="btn btn-primary w-full" id="pay-button">Konfirmasi Reservasi</button>
      </div>
    </div>
  </section>

@endsection

@push('bottom')

<script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
<script src="{{ url(asset('assets/js/nav.js')) }}"></script>
{{-- <script src="{{ url(asset('assets/js/mditrans.js')) }}"></script> --}}
<script>
  // For example trigger on button clicked, or any time you need
var payButton = document.getElementById('pay-button');
payButton.addEventListener('click', function () {
  // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
  // Also, use the embedId that you defined in the div above, here.
  window.snap.pay('{{ $snapToken }}', {
    onSuccess: function (result) {
      /* You may add your own implementation here */
      alert("payment success!"); console.log(result);
    },
    onPending: function (result) {
      /* You may add your own implementation here */
      alert("wating your payment!"); console.log(result);
    },
    onError: function (result) {
      /* You may add your own implementation here */
      alert("payment failed!"); console.log(result);
    },
    onClose: function () {
      /* You may add your own implementation here */
      alert('you closed the popup without finishing the payment');
    }
  });
});
</script>
@endpush