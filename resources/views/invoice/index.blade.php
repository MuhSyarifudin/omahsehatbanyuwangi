@extends('layouts.HomeLayout')
@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6 md:p-10 my-10 font-helvetica-neue">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between gap-6 border-b-2 border-green-500 pb-6 mb-10">

            <div>
                <h1 class="text-3xl font-bold text-green-600 tracking-wide">
                    <img src="{{asset('assets/img/logo-landscape.png')}}" class="w-[196px]" alt="">
                </h1>

                <p class="text-sm text-gray-500 mt-2">
                    Rumah Terapi
                </p>

                <p class="text-sm text-gray-500">
                Perum. Taman Permata Hijau Blok E11,<br>
                Kel. Kebalenan, Kec. Banyuwangi,<br>
                Banyuwangi, Jawa Timur 68417
                </p>
            </div>

            <div class="text-left md:text-right">
                <h2 class="text-4xl font-light text-gray-800 uppercase">
                    Invoice
                </h2>

                <div class="mt-2 text-lg font-semibold text-green-600">
                    #{{substr($transaksi->order_id,0,11)}}
                </div>

                <div class="text-sm text-gray-500">
                    Tanggal: {{ dateId('j F Y',$transaksi->created_at) }}
                </div>

                <div class="mt-3">
                    <span
                        class="inline-flex items-center rounded-full 
                        @if ($transaksi->status == 'paid')
                            bg-green-100 text-green-700
                        @else
                            bg-red-100 text-red-700
                        @endif
                        px-3 py-1 text-xs font-semibold uppercase tracking-wide ">
                        {{$transaksi->status == 'paid' ? 'Lunas' : 'Belum Lunas'}}
                    </span>
                </div>
            </div>

        </div>

        <!-- Information -->
        <div class="grid md:grid-cols-2 gap-6 mb-10">

            <div class="bg-gray-50 border-l-4 border-green-500 rounded-lg p-5">
                <h3 class="text-xs uppercase tracking-widest text-gray-400 mb-3">
                    Data Pasien
                </h3>

                <p class="mb-1">
                    <span class="font-semibold">Nama:</span>
                    {{$transaksi->nama}}
                </p>

                <p class="mb-1">
                    <span class="font-semibold">No. HP:</span>
                    {{$transaksi->nohp}}
                </p>

                <p>
                    <span class="font-semibold">Jenis Kelamin:</span>
                    {{$transaksi->jenis_kelamin == 'L' ? 'Laki-laki':'Perempuan'}}
                </p>
            </div>

            <div class="bg-gray-50 border-l-4 border-green-500 rounded-lg p-5">
                <h3 class="text-xs uppercase tracking-widest text-gray-400 mb-3">
                    Detail Reservasi
                </h3>

                <p class="mb-1">
                    <span class="font-semibold">Terapis:</span>
                    Putriyani
                </p>

                <p class="mb-1">
                    <span class="font-semibold">Jadwal:</span>
                    {{dateId('j F Y',$transaksi->tanggal).', '.$transaksi->jam}} WIB
                </p>

                <p>
                    <span class="font-semibold">Layanan:</span>
                    {{$transaksi->tempat == 'center' ? 'Treatment Center':'Homecare'}}
                </p>
            </div>

        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">

                <thead>
                    <tr class="bg-green-600 text-white">
                        <th class="px-4 py-4 text-left text-xs uppercase tracking-wider">
                            Layanan Terapi
                        </th>

                        <th class="px-4 py-4 text-left text-xs uppercase tracking-wider">
                            Qty
                        </th>

                        <th class="px-4 py-4 text-right text-xs uppercase tracking-wider">
                            Harga
                        </th>

                        <th class="px-4 py-4 text-right text-xs uppercase tracking-wider">
                            Total
                        </th>
                    </tr>
                </thead>

                <tbody>

                    <tr class="border-b border-gray-200">
                        <td class="px-4 py-4">
                            <div class="font-semibold text-gray-800">
                                {{$jenis_terapi->jenis_terapi.' '.$transaksi->nama_terapi}}
                            </div>

                            {{-- <div class="text-sm text-gray-500 mt-1">
                                Sesi 60 menit dengan minyak aromaterapi
                            </div> --}}
                        </td>

                        <td class="px-4 py-4">
                            {{$transaksi->jumlah}}
                        </td>

                        <td class="px-4 py-4 text-right">
                            {{rupiah($transaksi->total_harga)}}
                        </td>

                        <td class="px-4 py-4 text-right">
                            {{rupiah($transaksi->total_harga)}}
                        </td>
                    </tr>

                </tbody>

                <tfoot class="bg-gray-50">

                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-medium">
                            Subtotal
                        </td>

                        <td class="px-4 py-3 text-right font-medium">
                            {{rupiah($transaksi->total_harga)}}
                        </td>
                    </tr>

                    <tr>
                        {{-- <td colspan="3" class="px-4 py-3 text-right font-medium">
                            Pajak (10%)
                        </td> --}}

                        {{-- <td class="px-4 py-3 text-right font-medium">
                            Rp 15.000
                        </td> --}}
                    </tr>

                    <tr>
                        <td colspan="3" class="px-4 py-4 text-right text-lg font-bold">
                            TOTAL PENAGIHAN
                        </td>

                        <td class="px-4 py-4 text-right text-lg font-bold text-green-600">
                            {{rupiah($transaksi->total_harga)}}
                        </td>
                    </tr>

                </tfoot>

            </table>
        </div>

        <!-- Footer -->
        <div class="mt-12 pt-6 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-500">
                <strong>Catatan:</strong>
                Pembayaran dilakukan maksimal H-1 sebelum jadwal terapi.
                Bukti transfer dikirim via WhatsApp ke nomor resmi Klinik.
            </p>

            <p class="mt-4 text-green-600 font-bold uppercase tracking-wide">
                Terima Kasih Atas Kepercayaan Anda
            </p>

            <p class="mt-5 text-xs text-gray-400">
                Invoice ini adalah sah jika dibubuhi cap dan tanda tangan resmi.
            </p>
            <a href="{{ route('invoice.download', ['order_id' => $transaksi->order_id,'token'=>$transaksi->invoice_token]) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition duration-200 mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v10m0 0l-4-4m4 4l4-4m-9 6h10" />
                </svg>
                Download Invoice
            </a>
        </div>

    </div>

</body>
@endsection