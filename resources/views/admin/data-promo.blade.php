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
<div class="max-w-7xl mx-auto p-6">

        
<div class="bg-white rounded-lg px-8 py-6 overflow-x-scroll mb-12">    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Promo</h1>
        
        <button  id="btnTambahPromo"
           class="cursor-pointer hover:cursor-pointer inline-flex items-center gap-2 bg-blue-700 hover:bg-opacity-90 text-white text-sm font-medium px-4 py-2 mb-4 rounded-lg shadow transition duration-200">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4" />
        </svg>
        Tambah Promo
        </button>
    
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-xl overflow-hidden">

            <!-- Modal Tambah Promo -->
    <div id="modalPromo"
    class="fixed inset-0 hidden items-center justify-center z-50 p-4
        bg-black/60 backdrop-blur-md transition-opacity duration-300">

    <div class="w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden
                rounded-3xl bg-white
                shadow-[0_25px_70px_-20px_rgba(0,0,0,0.35)]
                border border-gray-100">

        <!-- HEADER -->
        <div class="flex items-center justify-between px-7 py-5
                    border-b border-gray-100
                    bg-white/80 backdrop-blur
                    sticky top-0 z-10">

            <div>
                <h2 class="text-lg font-semibold text-gray-900 tracking-tight">
                    Tambah Promo
                </h2>
                <p class="text-xs text-gray-500 mt-0.5">
                    Buat promo baru untuk pelanggan
                </p>
            </div>

            <button id="closeModal"
                class="w-9 h-9 flex items-center justify-center
                    rounded-full text-gray-400 hover:text-gray-700
                    hover:bg-gray-100 transition">
                ✕
            </button>
        </div>

        <!-- BODY -->
        <div class="overflow-y-auto px-7 py-6">
            <form id="formPromo" class="space-y-6">

                <!-- BASIC INFO -->
                <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/60 space-y-5">
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="title"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                text-sm shadow-sm
                                focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                transition outline-none">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="3"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                text-sm shadow-sm resize-none
                                focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                transition outline-none"></textarea>
                    </div>
                </div>

                <!-- CONFIG -->
                <div class="grid grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-gray-700">Mode</label>
                        <select name="mode"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                text-sm shadow-sm
                                focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                transition outline-none">
                            <option value="center">Treatment Center</option>
                            <option value="homecare">Homecare</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-gray-700">Tipe</label>
                        <select name="type"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                text-sm shadow-sm
                                focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                transition outline-none">
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Nominal</option>
                        </select>
                    </div>
                </div>

                <!-- VALUE -->
                <div class="grid grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-gray-700">Nilai</label>
                        <input type="number" name="value"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                text-sm shadow-sm
                                focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                transition outline-none">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-gray-700">Minimal Transaksi</label>
                        <input type="number" name="minimum_transaction"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                text-sm shadow-sm
                                focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                transition outline-none">
                    </div>
                </div>

                <!-- DATE -->
                <div class="grid grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="start_date"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                text-sm shadow-sm
                                focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                transition outline-none">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-gray-700">Tanggal Berakhir</label>
                        <input type="date" name="end_date"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                text-sm shadow-sm
                                focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                transition outline-none">
                    </div>
                </div>

                <!-- STATUS CARD -->
                <label class="flex items-center justify-between p-4
                            rounded-2xl border border-gray-200 bg-gray-50">
                    <span class="text-sm font-medium text-gray-700">
                        Promo aktif
                    </span>
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                </label>

            </form>
        </div>

        <!-- FOOTER -->
        <div class="flex justify-end gap-3 px-7 py-5
                    border-t border-gray-100 bg-gray-50/70 backdrop-blur">

            <button type="button" id="batalModal"
                class="px-5 py-2.5 text-sm font-medium
                    rounded-xl border border-gray-200
                    hover:bg-white transition">
                Batal
            </button>

            <button type="submit" form="formPromo"
                class="px-6 py-2.5 text-sm font-semibold text-white
                    rounded-xl bg-blue-600
                    hover:bg-blue-700
                    shadow-lg shadow-blue-600/20
                    transition">
                Simpan Promo
            </button>
        </div>

    </div>
    </div>



        <!--Modal Edit-->
        <div id="modalEditPromo"
            class="fixed inset-0 hidden items-center justify-center z-50 p-4
                bg-black/60 backdrop-blur-md transition-opacity duration-300">

            <div class="w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden
                        rounded-3xl bg-white shadow-[0_20px_60px_-15px_rgba(0,0,0,0.25)]
                        border border-gray-100">

                <!-- HEADER -->
                <div class="flex items-center justify-between px-7 py-5
                            border-b border-gray-100 bg-white/80 backdrop-blur
                            sticky top-0 z-10">

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 tracking-tight">
                            Edit Promo
                        </h2>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Perbarui detail promo
                        </p>
                    </div>

                    <button id="closeEditModal"
                        class="w-9 h-9 flex items-center justify-center
                            rounded-full text-gray-400 hover:text-gray-700
                            hover:bg-gray-100 transition">
                        ✕
                    </button>
                </div>

                <!-- BODY -->
                <div class="overflow-y-auto px-7 py-6">
                    <form id="formEditPromo" class="space-y-6">

                        <input type="hidden" id="edit_id">

                        <!-- INPUT GROUP -->
                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Judul</label>
                            <input type="text" name="title" id="edit_title"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                    text-sm shadow-sm
                                    focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                    transition outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="edit_description" rows="3"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                    text-sm shadow-sm resize-none
                                    focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                    transition outline-none"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-700">Mode</label>
                                <select name="mode" id="edit_mode"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                        text-sm shadow-sm
                                        focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                        transition outline-none">
                                    <option value="center">Treatment Center</option>
                                    <option value="homecare">Homecare</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-700">Tipe</label>
                                <select name="type" id="edit_type"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                        text-sm shadow-sm
                                        focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                        transition outline-none">
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Nominal</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-700">Nilai</label>
                                <input type="number" name="value" id="edit_value"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                        text-sm shadow-sm
                                        focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                        transition outline-none">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-700">Minimal Transaksi</label>
                                <input type="number" name="minimum_transaction"
                                    id="edit_minimum_transaction"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                        text-sm shadow-sm
                                        focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                        transition outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="edit_start_date"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                        text-sm shadow-sm
                                        focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                        transition outline-none">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-700">Tanggal Berakhir</label>
                                <input type="date" name="end_date" id="edit_end_date"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5
                                        text-sm shadow-sm
                                        focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                                        transition outline-none">
                            </div>
                        </div>

                        <!-- SWITCH STYLE -->
                        <label class="flex items-center justify-between p-4
                                    rounded-xl border border-gray-200 bg-gray-50">
                            <span class="text-sm font-medium text-gray-700">
                                Promo aktif
                            </span>
                            <input type="checkbox" name="is_active" id="edit_is_active"
                                value="1"
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </label>

                    </form>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 px-7 py-5
                            border-t border-gray-100 bg-gray-50/70 backdrop-blur">

                    <button type="button" id="batalEditModal"
                        class="px-5 py-2.5 text-sm font-medium
                            rounded-xl border border-gray-200
                            hover:bg-white transition">
                        Batal
                    </button>

                    <button type="submit" form="formEditPromo"
                        class="px-6 py-2.5 text-sm font-semibold text-white
                            rounded-xl bg-blue-600
                            hover:bg-blue-700
                            shadow-lg shadow-blue-600/20
                            transition">
                        Update Promo
                    </button>

                </div>

            </div>
        </div>

        <!-- Modal Delete Elegant -->
        <div
        id="modalDeletePromo"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">

        <div class="w-full max-w-md rounded-2xl bg-white shadow-xl">
            
            <!-- Icon -->
            <div class="flex justify-center pt-6">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-8 w-8 text-red-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m3-3h4a1 1 0 011 1v1H9V5a1 1 0 011-1z" />
                    </svg>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 py-4 text-center">
                <h3 class="text-lg font-semibold text-gray-800">
                    Hapus Data Layanan?
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    Data yang sudah dihapus tidak dapat dikembalikan.
                    Apakah Anda yakin ingin melanjutkan?
                </p>
            </div>

            <!-- Actions -->
            <div class="flex justify-center gap-3 border-t px-6 py-4">
                <button
                    type="button"
                    class="btnCancelDelete rounded-lg border px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                    Batal
                </button>
                <button
                    type="button"
                    id="btnConfirmDelete"
                    class="rounded-lg bg-red-600 px-5 py-2 text-sm font-medium text-white hover:bg-red-700">
                    Ya, Hapus
                </button>
            </div>
        </div>
        </div>

        <div class="overflow-x-auto lg:overflow-visible">
            <table class="min-w-full text-sm" id="tabel_promo">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 text-center py-3">No.</th>
                        <th class="px-6 text-center py-3">Judul</th>
                        <th class="px-6 text-center py-3">Mode</th>
                        <th class="px-6 text-center py-3">Tipe</th>
                        <th class="px-6 text-center py-3">Nilai</th>
                        <th class="px-6 text-center py-3">Periode</th>
                        <th class="px-6 text-center py-3">Status</th>
                        <th class="px-6 text-center py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                </tbody>
            </table>
        </div>

    </div>
</div>
</div>
@endsection
@push('bottom')
<script>
    let table
    $(document).ready(function(){

        table = $('#tabel_promo').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('data-promo.datatables') }}",

        columns: [
            {data: 'DT_RowIndex',orderable: false,searchable: false},
            {data: 'title',name: 'title'},
            {data: 'mode',name: 'mode'},
            {data: 'type',name: 'type'},
            {data: 'nilai',name: 'nilai'},
            {data: 'periode',name: 'periode'},
            {data: 'status',name: 'status'},
            {data: 'aksi',orderable: false,searchable: false}
        ]
        });
        

        // buka modal
        $('#btnTambahPromo').click(function(){
            $('#modalPromo').removeClass('hidden').addClass('flex');
        });

        // tutup modal
        $('#closeModal, #batalModal').click(function(){
            $('#modalPromo').addClass('hidden').removeClass('flex');
        });

        // submit ajax
        $('#formPromo').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: "{{ route('data.promo.store') }}",
                method: "POST",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    $('#modalPromo').addClass('hidden');
                    table.ajax.reload(null, false);
                },
                error: function(xhr){
                    alert('Terjadi kesalahan');
                    console.log(xhr.responseText);
                }
            });

        });

        });

        $(document).on('click', '.btn-edit', function(){

        let id = $(this).data('id');

        $.get('/admin/promo/' + id + '/edit', function(data){

            $('#edit_id').val(data.id);
            $('#edit_title').val(data.title);
            $('#edit_description').val(data.description);
            $('#edit_mode').val(data.mode);
            $('#edit_type').val(data.type);
            $('#edit_value').val(data.value);
            $('#edit_minimum_transaction').val(data.minimum_transaction);
            $('#edit_start_date').val(data.start_date);
            $('#edit_end_date').val(data.end_date);
            $('#edit_is_active').prop('checked', data.is_active);

            $('#modalEditPromo')
                .removeClass('hidden')
                .addClass('flex');

        });

        });

        $('#formEditPromo').submit(function(e){
            e.preventDefault();

            let id = $('#edit_id').val();

            $.ajax({
                url: '/admin/promo/' + id + '/update',
                type: 'PUT',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    $('#modalEditPromo').addClass('hidden');
                    table.ajax.reload(null, false);
                },
                error: function(xhr){
                    if(xhr.status === 422){
                        let errors = xhr.responseJSON.errors;
                        let msg = '';
                        $.each(errors, function(k,v){ msg += v[0] + '\n'; });
                        alert(msg);
                    }
                }
            });
        });

        $('#closeEditModal, #batalEditModal').click(function(){
                closeEditModal();
        });

        function closeEditModal(){
            $('#modalEditPromo')
                .addClass('hidden')
                .removeClass('flex');

            $('#formEditPromo')[0].reset();
        }

            $(document).on('click', '.btn-hapus', function(){

            let id = $(this).data('id');

            $('#modalDeletePromo').data('id', id);

            $('#modalDeletePromo')
                .removeClass('hidden')
                .addClass('flex');
            });
    
            // CLOSE MODAL
            $(document).on('click', '.btnCancelDelete', function () {
                deleteId = null;

                $('#modalDeletePromo')
                    .addClass('hidden')
                    .removeClass('flex');
            });

            $('#btnConfirmDelete').click(function(){

            let id = $('#modalDeletePromo').data('id');

            if(!id) return;

            $.ajax({
                url: '/admin/promo/' + id + '/delete',
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){

                    $('#modalDeletePromo')
                    .addClass('hidden')
                    .removeClass('flex');

                    // reload datatable tanpa reset halaman
                    table.ajax.reload(null, false);

                },
                error: function(xhr){
                    alert('Gagal menghapus data');
                    console.log(xhr.responseText);
                }
            });

            });


</script>
    
@endpush