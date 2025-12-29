@extends('layouts.DashboardLayout')

@push('top')

<link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.tailwindcss.css">

<!-- CDN Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
   
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.tailwindcss.js"></script>
@endpush

@section('content')
    
<div class="bg-white rounded-lg px-8 py-6 overflow-x-scroll custom-scrollbar mb-12">
    <h4 class="text-xl font-semibold mb-5">Reservasi Table</h4>

    <table id="tabel_reservasi" class="display" style="width:100%">
        <thead class="border-b border-gray-300">
            <tr>
                <td class="py-2 pl-2 text-center">
                    No.
                </td>
                <td class="py-2 pl-2 text-center">
                    Nama Customer
                </td>
                <td class="py-2 pl-2 text-center">
                    Terapi
                </td>
                <td class="py-2 pl-2 text-center">
                    Tempat
                </td>
                <td class="py-2 pl-2 text-center">
                    Status
                </td>
                <td class="py-2 pl-2 text-center">
                    Tanggal
                </td>
                <td class="py-2 pl-2 text-center">
                    View Details
                </td>
            </tr>
        </thead>
        <tbody class="text-sm">
            @foreach ($transaksi as $trans)
            <tr class="bg-gray-100 hover:bg-primary hover:bg-opacity-20 transition duration-200 text-center">
                <td class="py-3 pl-2 text-center">
                    {{ $loop->iteration }}
                </td>
                <td class="py-3 pl-2 text-center">
                    {{ $trans->nama }}
                </td>
                <td class="py-3 pl-2 text-center">
                    {{ $trans->nama_terapi }}
                </td>
                <td class="py-3 pl-2 text-center">
                    {{ $trans->tempat }}
                </td>
                <td class="py-3 pl-2 text-center">
                    
                    <span class="@php
                        if ($trans->status == 'pending') {
                            echo 'bg-orange-400';
                        } elseif ($trans->status == 'paid') {
                            echo 'bg-green-500';
                        } elseif ($trans->status == 'canceled'){
                            echo 'bg-red-500';
                        }
                    @endphp 
                    px-1.5 py-0.5 rounded-lg text-gray-100 capitalize">
                        {{ $trans->status }}
                    </span>
                </td>
                <td class="py-3 pl-2 text-center">
                    {{ dateid('l,j F Y',$trans->created_at) }}
                </td>
                <td class="py-3 pl-2">
                    <a data-modal="modal{{ $trans->id }}" class="openModal cursor-pointer bg-primary hover:bg-opacity-90 px-2 py-1 mr-2 text-gray-100 rounded-lg">View Details</a>
                </td>
                <div id="modal{{ $trans->id }}" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-[9999]">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                        <h2 class="text-xl font-semibold"> Detail Reservasi</h2>
                        <p class="mt-2 text-gray-900">Nama: {{ $trans->nama }}</p>
                        <p class="text-gray-900">No. Whatsapp: {{ $trans->nohp }}</p>
                        <p class="text-gray-900">Jenis Kelamin: {{ $trans->jenis_kelamin == 'L' ? 'Laki - laki' : 'Perempuan' }}</p>
                        <p class="text-gray-900">Jenis Layanan: {{ $trans->tempat }}</p>
                        <p class="text-gray-900">Alamat: {{ $trans->alamat }}</p>
                        <p class="text-gray-900">Tanggal: {{ dateid('l,j F Y',$trans->tanggal) }}</p>
                        <p class="text-gray-900">Jam: {{ $trans->jam }}</p>
                        <p class="text-gray-900">Jenis Terapi: {{ $trans->nama_layanan.' - '.$trans->nama_jenis_terapi }}</p>
                        <p class="text-gray-900">Jumlah: {{ $trans->jumlah }} Orang</p>
                        <p class="text-gray-900">Total Harga: {{ rupiah($trans->total_harga) }}</p>

                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('send.payment.page',['id'=>$trans->id]) }}" class="px-4 py-2 mr-2 text-white bg-purple-600 rounded hover:bg-purple-700">Send Payment</a>
                            <button class="closeModal px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>



@endsection



@push('bottom')
<script>
    $(document).ready(function () {
        let table = $('#tabel_reservasi').DataTable();
    });

    $(document).ready(function() {
        // Buka modal berdasarkan tombol yang diklik
        $(".openModal").click(function() {
            let modalId = $(this).data("modal");
            $("#" + modalId).removeClass("hidden").addClass("flex");
        });

        // Tutup modal saat tombol "Tutup" diklik
        $(".closeModal").click(function() {
            $(this).closest(".modal").removeClass("flex").addClass("hidden");
        });

        // Tutup modal jika klik di luar kontennya
        $(".modal").click(function(event) {
            if ($(event.target).is(".modal")) {
                $(this).removeClass("flex").addClass("hidden");
            }
        });
    });
</script>

@endpush