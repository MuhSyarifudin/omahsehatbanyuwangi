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

    <div class="flex flex-wrap items-center gap-3 mb-4">
        <!-- Filter Bulan -->
        <select id="filterBulan"
            class="min-w-[160px] rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700
                   shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30
                   transition duration-200">
            <option value="">Semua Bulan</option>
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>
    
        <!-- Filter Tahun -->
        <select id="filterTahun"
            class="min-w-[140px] rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700
                   shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30
                   transition duration-200">
            <option value="">Semua Tahun</option>
            @for($i = date('Y'); $i >= 2020; $i--)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    
        <!-- Button Filter -->
        <button id="btnFilter"
            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2 text-sm font-medium text-white
                   shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-500/40
                   transition duration-200">
            🔍 Filter
        </button>
    
        <!-- Button Reset -->
        <button id="btnReset"
            class="inline-flex items-center gap-2 rounded-xl bg-gray-200 px-5 py-2 text-sm font-medium text-gray-700
                   hover:bg-gray-300 focus:ring-2 focus:ring-gray-400/40
                   transition duration-200">
            ♻ Reset
        </button>
    </div>
    

    <table id="tabel_reservasi" class="display" style="width:100%">
        <thead class="border-b border-gray-300">
            <tr>
                <th>No.</th>
                <th>Nama Customer</th>
                <th>Terapi</th>
                <th>Tempat</th>
                <th>Status</th>
                <th>Tanggal Reservasi</th>
                <th>View Details</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div id="modalDetail"
     class="fixed inset-0 hidden z-[9999] bg-black bg-opacity-50">

    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="bg-white w-[800px] max-w-lg rounded-xl shadow-xl p-6 relative">

            <button class="closeModal absolute top-3 right-3">✕</button>

            <h2 class="text-xl font-semibold mb-5 border-b pb-2">
                Detail Reservasi
            </h2>

            <div class="space-y-2 text-sm">
                <p><b>Nama Customer:</b> <span id="m_nama"></span></p>
                <p><b>Tanggal Booking:</b> <span id="m_tanggal_booking"></span></p>
                <p><b>Jam Booking:</b> <span id="m_jam_booking"></span></p>
                <p><b>No. Whatsapp:</b> <span id="m_nohp"></span></p>
                <p><b>Jenis Kelamin:</b> <span id="m_jk"></span></p>
                <p><b>Jenis Layanan:</b> <span id="m_tempat"></span></p>
                <p><b>Alamat:</b> <span id="m_alamat"></span></p>
                <p><b>Tanggal Reservasi:</b> <span id="m_tanggal_reservasi"></span></p>
                <p><b>Jam:</b> <span id="m_jam_reservasi"></span></p>
                <p><b>Jenis Terapi:</b> <span id="m_terapi"></span></p>
                <p><b>Jumlah:</b> <span id="m_jumlah"></span></p>

                <p class="pt-2 border-t">
                    <b>Total Harga:</b>
                    <span id="m_total" class="text-green-600 font-bold"></span>
                </p>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a id="btnPayment"
                   class="px-4 py-2 text-sm text-white bg-purple-600 rounded-lg hidden">
                   Loading...
                </a>                    
                <button class="closeModal px-4 py-2 text-sm bg-gray-500 text-white rounded-lg">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

@endsection



@push('bottom')

<script>

$(document).ready(function () {

    let table = $('#tabel_reservasi').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('data-reservasi.datatables') }}",
            data: function(d) {
                d.bulan = $('#filterBulan').val();
                d.tahun = $('#filterTahun').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'nama', name: 'nama' },
            { data: 'nama_jenis_terapi', name: 'jenis_terapi.nama' },
            { data: 'tempat', name: 'tempat' },
            { data: 'status_badge', name: 'status' },
            { data: 'tanggal', name: 'created_at' },
            { data: 'aksi', orderable:false, searchable:false }
        ],
        order: [[5, 'desc']]
    });

    $('#btnFilter').on('click', function() {
        table.draw();
        table.ajax.reload(null, false);
    });

    $('#btnReset').on('click', function() {
        $('#filterBulan').val('');
        $('#filterTahun').val('');
        table.draw();
        table.ajax.reload(null, false);
    });

    $(document).on('click', '.openModal', function () {

        let id = $(this).data('id');

        $.ajax({
            url: '/admin/data-reservasi/detail/' + id,
            type: 'GET',
            beforeSend: function () {
                $('#modalDetail').removeClass('hidden');
                $('#modalDetail span').text('Loading...');
            },
            success: function (res) {
                $('#m_nama').text(res.nama);
                $('#m_nohp').text(res.nohp);
                $('#m_jk').text(res.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan');
                $('#m_tempat').text(res.tempat);
                $('#m_alamat').text(res.alamat);
                $('#m_tanggal_booking').text(res.tanggal_booking);
                $('#m_jam_booking').text(res.jam_booking);
                $('#m_tanggal_reservasi').text(res.tanggal_reservasi);
                $('#m_jam_reservasi').text(res.jam_reservasi);
                $('#m_terapi').text(res.terapi);
                $('#m_jumlah').text(res.jumlah + ' Orang');
                $('#m_total').text(res.total);

                if (res.status == 'expired') {
                    $('#btnPayment').removeClass('hidden');
                    $('#btnPayment').removeClass('bg-purple-600');
                    $('#btnPayment').addClass('bg-gray-400');
                    $('#btnPayment').attr('disabled', true);
                    $('#btnPayment').attr('href', null);
                    $('#btnPayment').text('Loading...');
                    setTimeout(() => {
                        $('#btnPayment').text('Expired');
                    }, 1000);
                } else if(res.status == 'pending') {
                    $('#btnPayment').removeClass('hidden');
                    $('#btnPayment').removeClass('bg-gray-400');
                    $('#btnPayment').addClass('bg-purple-600');
                    $('#btnPayment').attr('disabled', false);
                    $('#btnPayment').attr('href', null);
                    $('#btnPayment').text('Loading...');
                    setTimeout(() => {
                        $('#btnPayment').text('Send Payment');
                        $('#btnPayment').attr('href', res.payment_url);
                    }, 1000);
                }
                

                $("body").addClass("overflow-hidden");
            },
            error: function () {
                alert('Gagal mengambil data');
                $('#modalDetail').addClass('hidden');
            }

        });
        });

        $(document).on('click', '.closeModal', function () {
        $('#modalDetail').addClass('hidden');
        $('#btnPayment').addClass('hidden');
        $("body").removeClass("overflow-hidden");
        });
        
        Echo.join('notification-bell')
        .listen('.notification-update', () => {
            table.ajax.reload(null, false);
        });
    
    });
</script>

@endpush