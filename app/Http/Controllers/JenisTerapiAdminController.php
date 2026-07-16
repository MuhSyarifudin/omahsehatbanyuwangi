<?php

namespace App\Http\Controllers;

use App\Models\JenisTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JenisTerapiAdminController extends Controller
{
    
    public function data_jenis_terapi(){

        return view('admin.data-jenis-terapi');
    }

    public function data_jenis_terapi_datatables(){
        $query = JenisTerapi::all();

        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('aksi', function($row){
            
            return '
            <a 
            data-id="'.$row->id.'"
            data-nama="'.$row->nama.'"
            class="btnEditLayanan bg-blue-600 cursor-pointer hover:bg-opacity-90 text-white px-2 py-1 rounded-lg"
            >
            Edit
            </a>
            <a data-id="'.$row->id.'"
            class="btnDeleteLayanan bg-red-600 cursor-pointer hover:bg-opacity-90 px-2 py-1 ml-2 text-gray-100 rounded-lg">
            Hapus
            </a>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama'      => 'required|string|max:255',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Simpan ke database
        $layanan = JenisTerapi::create([
            'nama'      => $request->nama,
        ]);

        // Response sukses
        return response()->json([
            'status'  => true,
            'message' => 'Data layanan berhasil disimpan',
            'data'    => $layanan,
        ],201);
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
    
        $layanan = JenisTerapi::findOrFail($id);
    
        $layanan->update([
            'nama' => $request->nama,
        ]);
    
        return response()->json([
            'status'  => true,
            'message' => 'Nama layanan berhasil diperbarui',
            'data'    => $layanan,
        ]);
    }

    public function destroy($id){
        $layanan = JenisTerapi::where('id',$id);

        if (!$layanan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data layanan tidak ditemukan'
            ], 404);
        }

        $layanan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus!'
        ]);
    }

}
