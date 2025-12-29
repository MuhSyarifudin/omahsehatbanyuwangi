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
    <h4 class="text-xl font-semibold mb-5">Users Table</h4>
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
        <tbody class="text-sm">
            @foreach ($users as $usr)
            <tr class="bg-gray-100 hover:bg-primary hover:bg-opacity-20 transition duration-200 text-center">
                <td class="py-3 pl-2">
                    {{ $loop->iteration }}
                </td>
                <td class="py-3 pl-2">
                    {{ $usr->name }}
                </td>
                <td class="py-3 pl-2">
                    {{ $usr->email }}
                </td>
                <td class="py-3 pl-2">
                    <span class="
                    @php
                        if ($usr->email_verified_at !== null ) {
                            echo 'bg-green-500';
                        } else {
                            echo 'bg-orange-500';
                        }
                    @endphp 
                    px-1.5 py-0.5 rounded-lg text-gray-100">
                        {{ $usr->email_verified_at !== null ? 'Sudah' : 'Belum' }}
                    </span>
                </td>
                <td class="py-3 pl-2">
                    <a class="bg-primary cursor-pointer hover:bg-opacity-90 px-2 py-1 mr-2 text-gray-100 rounded-lg">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    
</div>

@endsection

@push('bottom')
<script>
    $(document).ready(function () {
       let table = $('#tabel_user').DataTable();
   });
</script>
@endpush