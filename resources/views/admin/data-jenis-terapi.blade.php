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

    <h4 class="text-xl font-semibold mb-5">Data Jenis Terapi</h4>

    <a id="btnTambahLayanan"
       class="openModal cursor-pointer hover:cursor-pointer inline-flex items-center gap-2 bg-blue-600 hover:bg-opacity-90 text-white text-sm font-medium px-4 py-2 mb-4 rounded-lg shadow transition duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4" />
        </svg>
        Tambah Jenis Terapi
    </a>
    </div>

        <!-- Modal Tambah Layanan -->
<div
id="modalTambahLayanan"
class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">

<div class="w-full max-w-lg rounded-2xl bg-white shadow-xl">
    
    <!-- Header -->
    <div class="flex items-center gap-3 border-b px-6 py-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 text-blue-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4" />
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">
                Tambah Data Jenis Terapi
            </h2>
            <p class="text-sm text-gray-500">
                Masukkan Data Jenis Terapi baru
            </p>
        </div>
    </div>

    <!-- Body -->
    <form id="formTambahLayanan" class="space-y-4 px-6 py-5">
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Nama Layanan
            </label>
            <input
                type="text"
                name="nama"
                class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                placeholder="Contoh: Konsultasi"
                required>
        </div>
    </form>

    <!-- Footer -->
    <div class="flex justify-end gap-3 border-t px-6 py-4">
        <button
            type="button"
            class="btnCloseTambah rounded-lg border px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
            Batal
        </button>
        <button
            type="submit"
            form="formTambahLayanan"
            class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">
            Simpan
        </button>
    </div>
</div>
</div>


         <!-- Modal Edit Layanan -->
<div
id="modalEditLayanan"
class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">

<div class="w-full max-w-md rounded-2xl bg-white shadow-xl">
    
    <!-- Header -->
    <div class="flex items-center gap-3 border-b px-6 py-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 text-blue-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M11 5h2M12 7v10m9-5a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">
                Edit Jenis Terapi
            </h2>
            <p class="text-sm text-gray-500">
                Perbarui Jenis Terapi
            </p>
        </div>
    </div>

    <!-- Body -->
    <form id="formEditLayanan" class="space-y-4 px-6 py-5">
        <input type="hidden" name="id" id="edit_id">

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Nama Jenis Terapi
            </label>
            <input
                type="text"
                name="nama"
                id="edit_nama"
                class="w-full rounded-lg border px-4 py-2 focus:border-blur-500 focus:ring-2 focus:ring-blue-500"
                placeholder="Contoh: Konsultasi"
                required>
        </div>
    </form>

    <!-- Footer -->
    <div class="flex justify-end gap-3 border-t px-6 py-4">
        <button
            type="button"
            class="btnCloseEdit rounded-lg border px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
            Batal
        </button>
        <button
            type="submit"
            form="formEditLayanan"
            class="rounded-lg bg-blue-500 px-5 py-2 text-sm font-medium text-white hover:bg-blue-600">
            Update
        </button>
    </div>
</div>
</div>

        <!-- Modal Delete Elegant -->
<div
id="modalDeleteLayanan"
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
            Hapus Data Jenis Terapi?
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


    <table class="w-full my-8 whitespace-nowrap" id="tabel_jenis_terapi">
        <thead>
            <tr>
                <td class="text-center">
                    No.
                </td>
                <td class="py-2 pl-2 text-center">
                    Nama
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
<script>
    $(document).ready(function () {
       let table = $('#tabel_jenis_terapi').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('data-jenis-terapi.datatables') }}"
        },
        columns: [
            {data: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'nama', name: 'nama'},
            {data: 'aksi',orderable: false,searchable: false,className: 'text-center'}
        ],
        order: [[0,'desc']]
       });

        // Open modal
        $('#btnTambahLayanan').on('click', function () {
            $('#modalTambahLayanan')
                .removeClass('hidden')
                .addClass('flex');
        });

        // Close modal
        $('.btnCloseTambah').on('click', function () {
            $('#modalTambahLayanan')
                .addClass('hidden')
                .removeClass('flex');
        });

        // Submit form (contoh)
        $('#formTambahLayanan').on('submit', function (e) {
            e.preventDefault();

            let data = $(this).serialize();
            console.log(data);

        });

        // CSRF Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#formTambahLayanan').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('data.jenis.terapi.store') }}",
                type: "POST",
                data: formData,
                success: function (res) {
                    // alert(res.message);

                    // Reset form
                    $('#formTambahLayanan')[0].reset();

                    // Tutup modal
                    $('#modalTambahLayanan').addClass('hidden').removeClass('flex');

                    // TODO: reload table / datatable
                    table.ajax.reload(null,false);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let msg = '';

                        $.each(errors, function (key, value) {
                            msg += value[0] + "\n";
                        });

                        alert(msg);
                    } else {
                        alert('Terjadi kesalahan server');
                    }
                }
            });
        });

            // OPEN MODAL EDIT
            $(document).on('click', '.btnEditLayanan', function () {
                let id   = $(this).data('id');
                let nama = $(this).data('nama');

                $('#edit_id').val(id);
                $('#edit_nama').val(nama);

                $('#modalEditLayanan')
                    .removeClass('hidden')
                    .addClass('flex');
            });

            // CLOSE MODAL
            $('.btnCloseEdit').on('click', function () {
                $('#modalEditLayanan')
                    .addClass('hidden')
                    .removeClass('flex');
            });

            // SUBMIT UPDATE
            $('#formEditLayanan').on('submit', function (e) {
                e.preventDefault();

                let id = $('#edit_id').val();

                $.ajax({
                    url: '{{ route("data.jenis.terapi.update",["id"=>"__id__"]) }}'.replace('__id__',id),
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function (res) {
                        alert(res.message);

                        table.ajax.reload(null,false);

                        $('#modalEditLayanan')
                            .addClass('hidden')
                            .removeClass('flex');

                        // TODO: update row / reload table
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert('Terjadi kesalahan server');
                        }
                    }
                });
            });

            // OPEN MODAL DELETE (DataTables friendly)
            $(document).on('click', '.btnDeleteLayanan', function () {
                deleteId = $(this).data('id');

                $('#modalDeleteLayanan')
                    .removeClass('hidden')
                    .addClass('flex');
            });

            // CANCEL DELETE
            $(document).on('click', '.btnCancelDelete', function () {
                deleteId = null;

                $('#modalDeleteLayanan')
                    .addClass('hidden')
                    .removeClass('flex');
            });

            // CONFIRM DELETE
            $('#btnConfirmDelete').on('click', function () {
                if (!deleteId) return;

                $.ajax({
                    url: '{{ route("data.jenis.terapi.destroy",["id"=>"__id__"]) }}'.replace('__id__',deleteId),
                    type: 'DELETE',
                    success: function (res) {
                        
                        table.ajax.reload(null, false);
                        
                        $('#modalDeleteLayanan')
                        .addClass('hidden')
                        .removeClass('flex');
                    },
                    error: function () {
                        alert('Gagal menghapus data');
                    }
                });
            });

    });

</script>
@endpush