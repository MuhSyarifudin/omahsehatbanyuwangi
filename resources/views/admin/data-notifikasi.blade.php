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
    <table class="w-full my-8 whitespace-nowrap" id="table_notifikasi">
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
            
        </tbody>
    </table>

    
</div>

@endsection

@push('bottom')
<script type="module" src="{{ url(asset('assets/js/notification.js')) }}"></script>
<script>
    $(document).ready(function () {
       let table = $('#table_notifikasi').DataTable();
   });
</script>
@endpush