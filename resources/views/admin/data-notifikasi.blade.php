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
    <h4 class="text-xl font-semibold mb-5">Notifikasi Table</h4>
    <table class="w-full my-8 whitespace-nowrap" id="tabel_notifikasi">
        <thead class="">
            <tr>
                <th class="text-center">
                    No.
                </th>
                <th class="py-2 pl-2 text-center">
                    Pesan
                </th>
                <th class="py-2 pl-2 text-center">
                    Waktu
                </th>
                <th class="py-2 pl-2 text-center">
                    Status
                </th>
                <th class="py-2 pl-2 text-center">
                    Action
                </th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    
</div>

@endsection

@push('bottom')

<script>
$(document).ready(function () {

    let table = $('#tabel_notifikasi').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('data-notifikasi.datatables') }}",
        },
        columns: [
            {data: 'DT_RowIndex',orderable: false,searchable: false},
            {data: 'message',name: 'message'},
            {data: 'waktu',name: 'waktu'},
            {data: 'status',name: 'status'},
            {data: 'aksi',orderable: false, searchable: false}
        ],
        order: [[2,'desc']]
    });

 

    $(document).on('click', '.btn-mark-as-read', function () {
    let notificationId = $(this).data('id');
    let button = $(this);

    $.ajax({
        url: `/admin/data-notifikasi/${notificationId}/read`,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {

            if (window.loadNotifikasi) {
                loadNotifikasi();
            }

            if (window.loadNotifikasiList) {
                loadNotifikasiList();
            }

            button.text('Loading...').addClass('bg-gray-400');
            table.ajax.reload(null, false);
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
    });


    Echo.join('notification-bell')
        .listen('.notification-update', () => {
            table.ajax.reload(null, false);
        });



});


</script>
@endpush