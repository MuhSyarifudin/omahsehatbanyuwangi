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

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-5">

    <h4 class="text-xl font-semibold mb-5">Data WhatsApp Log</h4>

    </div>

<div class="max-w-7xl mx-auto p-6">

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="p-5 border-b">
            <h1 class="text-2xl font-bold">
                WhatsApp Logs
            </h1>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="px-4 py-3 text-left">
                            Order ID
                        </th>

                        <th class="px-4 py-3 text-left">
                            Nomor
                        </th>

                        <th class="px-4 py-3 text-left">
                            Type
                        </th>

                        <th class="px-4 py-3 text-left">
                            Status
                        </th>

                        <th class="px-4 py-3 text-left">
                            Updated
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($messages as $item)

                    <tr class="border-b">

                        <td class="px-4 py-3">
                            {{ $item->transaksi->order_id }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->target_number }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->type }}
                        </td>

                        <td class="px-4 py-3">

                            @if($item->status == 'pending')

                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>

                            @elseif($item->status == 'sent')

                                <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                    Sent
                                </span>

                            @elseif($item->status == 'delivered')

                                <span class="px-3 py-1 rounded-full text-xs bg-indigo-100 text-indigo-700">
                                    Delivered
                                </span>

                            @elseif($item->status == 'read')

                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Read
                                </span>

                            @elseif($item->status == 'failed')

                                <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                    Failed
                                </span>

                            @endif

                        </td>

                        <td class="px-4 py-3">
                            {{ $item->status_updated_at }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="p-4">
            {{ $messages->links() }}
        </div>

    </div>

</div>
</div>

@endsection