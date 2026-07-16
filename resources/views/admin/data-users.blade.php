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
    
<div class="bg-white rounded-lg px-8 py-6 overflow-x-scroll mb-12">
    <h4 class="text-xl font-semibold mb-5">Data Users</h4>
    <table class="w-full my-8 whitespace-nowrap" id="tabel_user">
        <thead>
            <tr>
                <td class="text-center">
                    No.
                </td>
                <td class="py-2 pl-2 text-center">
                    Nama
                </td>
                <td class="py-2 pl-2 text-center">
                    Email
                </td>
                <td class="py-2 pl-2 text-center">
                    Verifikasi
                </td>
                <td class="py-2 pl-2 text-center">
                    Action
                </td>
            </tr>
        </thead>
        <tbody class="text-sm"></tbody>
    </table>

    <!-- MODAL DETAIL USER -->
<div id="modalDetailUser"
    class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">

    <div class="bg-white rounded-md w-full max-w-md relative overflow-hidden py-3">

        <!-- HEADER -->
        <div class="flex items-center justify-between border-b px-3 pb-2">
            <h2 class="text-xl font-semibold">
                Detail User
            </h2>

            <button id="closeModal"
                class="text-gray-500 hover:text-red-500 text-2xl leading-none">
                ✕
            </button>
        </div>

        <!-- CONTENT -->
        <table class="w-full text-sm border-collapse">

            <tbody>

                <tr class="border-b">
                    <td class="w-32 font-semibold px-3 py-2 bg-gray-50">
                        Nama
                    </td>
                    <td class="px-3 py-2" id="detail_name">
                        -
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="font-semibold px-3 py-2 bg-gray-50">
                        Email
                    </td>
                    <td class="px-3 py-2" id="detail_email">
                        -
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="font-semibold px-3 py-2 bg-gray-50">
                        Role
                    </td>
                    <td class="px-3 py-2" id="detail_role">
                        -
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="font-semibold px-3 py-2 bg-gray-50">
                        Verifikasi
                    </td>
                    <td class="px-3 py-2" id="detail_verified">
                        -
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="font-semibold px-3 py-2 bg-gray-50">
                        Dibuat
                    </td>
                    <td class="px-3 py-2" id="detail_created">
                        -
                    </td>
                </tr>

                <tr>
                    <td class="font-semibold px-3 py-2 bg-gray-50">
                        Update
                    </td>
                    <td class="px-3 py-2" id="detail_updated">
                        -
                    </td>
                </tr>

            </tbody>

        </table>
    </div>
</div>
    
</div>

@endsection

@push('bottom')
<script>
    $(document).ready(function () {
       let table = $('#tabel_user').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('data-users.datatables') }}"
        },
        columns: [
            {data: 'DT_RowIndex', orderable: false,searchable: false},
            {data: 'name', name: 'name',className: 'text-center'},
            {data: 'email', name: 'email',className: 'text-center'},
            {data: 'verified', name:'verified',className: 'text-center'},
            {data: 'aksi', orderable: false,searchable: false,className: 'text-center'}
        ]
       });
   });
   
    $(document).on('click', '.btn-detail', function () {

        let id = $(this).data('id');

        $('#modalDetailUser').removeClass('hidden').addClass('flex');

        // skeleton loading
        $('#detail_name').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-32"></div>');
        $('#detail_email').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-40"></div>');
        $('#detail_role').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-20"></div>');
        $('#detail_verified').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-24"></div>');
        $('#detail_created').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-36"></div>');
        $('#detail_updated').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-36"></div>');

        $.ajax({
    url: '/data-users/' + id,
    type: 'GET',

    beforeSend: function(){

        $('#detail_name').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-32"></div>');
        $('#detail_email').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-40"></div>');
        $('#detail_role').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-20"></div>');
        $('#detail_verified').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-24"></div>');
        $('#detail_created').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-36"></div>');
        $('#detail_updated').html('<div class="h-4 bg-gray-200 rounded animate-pulse w-36"></div>');
    },

        success: function(response){

            console.log(response);

            $('#detail_name').text(response.name);
            $('#detail_email').text(response.email);
            $('#detail_role').text(response.role);

            $('#detail_verified').html(
                response.email_verified_at
                ? '<span class="text-green-600 font-semibold">Terverifikasi</span>'
                : '<span class="text-red-600 font-semibold">Belum Verifikasi</span>'
            );

            $('#detail_created').text(response.created_at);
            $('#detail_updated').text(response.updated_at);
        },

        error: function(xhr){

            console.log(xhr.responseText);

            $('#detail_name').text('Gagal load data');
        }
    });

        });

        // CLOSE MODAL
        $('#closeModal').click(function () {
            $('#modalDetailUser').addClass('hidden').removeClass('flex');
        });

        // CLOSE SAAT KLIK BACKDROP
        $('#modalDetailUser').click(function(e){
            if(e.target === this){
                $('#modalDetailUser').addClass('hidden').removeClass('flex');
            }
        });

</script>
@endpush